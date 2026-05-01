<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.dashboard');
    }

    public function cars(Request $request)
    {
        $query = Car::query();

        if ($request->has('search')) {
            $query->where('model', 'like', '%' . $request->search . '%')
                ->orWhere('plate_number', 'like', '%' . $request->search . '%');
        }

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $cars = $query->latest()->get();

        return view('admin.cars.index', compact('cars'));
    }

    public function createCar()
    {
        $categories = Category::all();
        return view('admin.cars.create', compact('categories'));
    }

    public function storeCar(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'model' => 'required|string|max:255',
            'plate_number' => 'required|string|unique:cars,plate_number',
            'capacity' => 'required|integer',
            'year' => 'required|integer',
            'daily_rate' => 'required|numeric',
            'color' => 'required|string',
        ]);

        Car::create([
            'category_id' => $request->category_id,
            'model' => $request->model,
            'plate_number' => $request->plate_number,
            'capacity' => $request->capacity,
            'year' => $request->year,
            'daily_rate' => $request->daily_rate,
            'color' => $request->color,
            'status' => 'available'
        ]);

        return redirect()->route('admin.cars')->with('success', 'Mobil berhasil ditambahkan!');
    }

    public function editCar($id)
    {
        $car = Car::findOrFail($id);
        $categories = Category::all();
        return view('admin.cars.edit', compact('car', 'categories'));
    }

    public function updateCar(Request $request, $id)
    {
        $car = Car::findOrFail($id);

        $validated = $request->validate([
            'model' => 'required|string',
            'category_id' => 'required',
            'plate_number' => 'required|unique:cars,plate_number,' . $car->id,
            'year' => 'required|numeric',
            'daily_rate' => 'required|numeric',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('cars', 'public');
            $car->image = $imagePath;
        }

        $car->update([
            'model' => $validated['model'],
            'category_id' => $validated['category_id'],
            'plate_number' => $validated['plate_number'],
            'year' => $validated['year'],
            'daily_rate' => $validated['daily_rate'],
            'color' => $request->color,
            'capacity' => $request->capacity,
            'transmission' => $request->transmission,
        ]);

        return redirect()->route('admin.cars')->with('success', 'Data armada ' . $car->model . ' berhasil diperbarui!');
    }

    public function toggleMaintenance(Car $car)
    {

        $newStatus = ($car->status === 'available') ? 'maintenance' : 'available';

        if ($car->status === 'rented') {
            return redirect()->back()->with('error', 'Mobil sedang disewa, tidak bisa masuk mode maintenance.');
        }

        $car->update(['status' => $newStatus]);

        return redirect()->back()->with('success', 'Status armada berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $car = Car::findOrFail($id);

        if ($car->image) {
            Storage::delete('public/' . $car->image);
        }

        $car->delete();

        return redirect()->back()->with('success', 'Armada berhasil dihapus!');
    }
}

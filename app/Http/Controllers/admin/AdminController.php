<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\Category;
use App\Models\Motorcycle;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.dashboard');
    }

    public function vehicles(Request $request)
    {
        $query = Vehicle::query()->with(['car', 'motorcycle']);

        if ($request->filled('type')) {
            $query->where('vehicle_type', $request->type);
        }

        if ($request->has('search')) {
            $query->where('model', 'like', '%' . $request->search . '%')
                ->orWhere('plate_number', 'like', '%' . $request->search . '%');
        }

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $vehicles = $query->latest()->paginate(11)->withQueryString();

        return view('admin.cars.index', compact('vehicles'));
    }

    public function createCar()
    {
        $categories = Category::all();
        return view('admin.cars.create', compact('categories'));
    }

    public function storeCar(Request $request)
    {
        $type = $request->vehicle_type;

        DB::beginTransaction();
        try {
            $vehicle = Vehicle::create([
                'category_id' => $request->category_id,
                'vehicle_type' => $type,
                'model' => $request->model,
                'plate_number' => $request->plate_number,
                'year' => $request->year ?? date('Y'),
                'color' => $request->color ?? 'Hitam',
                'daily_rate' => $request->daily_rate,
            ]);

            if ($type === 'car') {
                Car::create([
                    'vehicle_id' => $vehicle->id,
                    'capacity' => $request->capacity,
                    'transmission' => $request->transmission,
                    'fuel_type' => $request->fuel_type,
                ]);
            } else {
                Motorcycle::create([
                    'vehicle_id' => $vehicle->id,
                    'engine_capacity' => $request->engine_capacity,
                    'includes_helmet' => $request->includes_helmet,
                    'transmission' => $request->transmission,
                ]);
            }

            DB::commit();
            return redirect()->route('admin.vehicles')->with('success', 'Armada berhasil ditambahkan!');
        } catch (\Exception $e) {
            dd($e->getMessage());
            DB::rollback();
            return back()->with('error', $e->getMessage());
        }
    }

    public function editCar($id)
    {
        $vehicle = Vehicle::with(['car', 'motorcycle'])->findOrFail($id);
        $categories = Category::all();
        return view('admin.cars.edit', compact('vehicle', 'categories'));
    }

    public function updateCar(Request $request, $id)
    {
        $vehicle = Vehicle::findOrFail($id);

        DB::beginTransaction();
        try {
            $vehicle->update([
                'category_id' => $request->category_id,
                'model' => $request->model,
                'plate_number' => $request->plate_number,
                'year' => $request->year ?? date('Y'),
                'color' => $request->color ?? 'Hitam',
                'daily_rate' => $request->daily_rate,
            ]);

            if ($vehicle->vehicle_type === 'car') {
                $vehicle->car()->update([
                    'capacity' => $request->capacity,
                    'transmission' => $request->transmission,
                    'fuel_type' => $request->fuel_type,
                ]);
            } else {
                $vehicle->motorcycle()->update([
                    'engine_capacity' => $request->engine_capacity,
                    'includes_helmet' => $request->includes_helmet,
                    'transmission' => $request->transmission,
                ]);
            }

            DB::commit();
            return redirect()->route('admin.vehicles')->with('success', 'Armada berhasil diupdate!');
        } catch (\Exception $e) {
            dd($e->getMessage());
            DB::rollback();
            return back()->with('error', $e->getMessage());
        }
    }

    public function toggleMaintenance(Vehicle $vehicle)
    {

        $newStatus = ($vehicle->status === 'available') ? 'maintenance' : 'available';

        if ($vehicle->status === 'rented') {
            return redirect()->back()->with('error', 'Mobil sedang disewa, tidak bisa masuk mode maintenance.');
        }

        $vehicle->update(['status' => $newStatus]);

        return redirect()->back()->with('success', 'Status armada berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $vehicle = Vehicle::findOrFail($id);

        if ($vehicle->image) {
            Storage::delete('public/' . $vehicle->image);
        }

        $vehicle->delete();

        return redirect()->back()->with('success', 'Armada berhasil dihapus!');
    }
}

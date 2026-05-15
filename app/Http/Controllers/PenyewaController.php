<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Rental;
use Illuminate\Http\Request;

class PenyewaController extends Controller
{
    public function index()
    {
        $cars = Car::where('status', 'available')->get();
        $recentRentals = Rental::where('status', 'ongoing')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.rentals.index', compact('cars', 'recentRentals'));
    }

    public function store(Request $request)
    {
        $request->merge([
            'total_price' => $request->total_price ? str_replace('.', '', $request->total_price) : 0,
            'amount_paid' => $request->amount_paid ? str_replace('.', '', $request->amount_paid) : 0,
        ]);

        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_address' => 'nullable|string',
            'car_id' => 'required|exists:cars,id',
            'rental_date' => 'required|date',
            'return_date_scheduled' => 'required|date|after:rental_date',
            'total_price' => 'required|numeric|min:0',
            'amount_paid' => 'nullable|numeric|min:0',
            'admin_notes' => 'nullable|string',
        ]);

        Rental::create([
            'customer_name' => $validated['customer_name'],
            'customer_phone' => $validated['customer_phone'],
            'customer_address' => $validated['customer_address'],
            'car_id' => $validated['car_id'],
            'rental_date' => $validated['rental_date'],
            'return_date_scheduled' => $validated['return_date_scheduled'],
            'total_price' => $validated['total_price'],
            'amount_paid' => $request->amount_paid ?? 0,
            'admin_notes' => $validated['admin_notes'],
            'status' => 'ongoing',
        ]);

        return redirect()->back()->with('success', 'Data rental berhasil dicatat!');
    }

    public function update(Request $request, $id)
    {
        $rental = Rental::findOrFail($id);

        $request->validate([
            'return_date_actual' => 'required|date',
            'amount_paid' => 'required|numeric|min:0',
            'admin_notes' => 'nullable|string'
        ]);

        $rental->update([
            'return_date_actual' => $request->return_date_actual,
            'amount_paid' => $request->amount_paid,
            'status' => 'completed',
            'admin_notes' => $rental->admin_notes . "\n Catatan Kembali: " . $request->admin_notes,
        ]);

        return redirect()->back()->with('success', 'Armada telah berhasil dikembalikan dan status diperbarui.');
    }

    public function cancel(Rental $rental)
    {
        if ($rental->status !== 'ongoing') {
            return redirect()->back()->with('error', 'Hanya penyewaan aktif yang dapat dibatalkan.');
        }

        $rental->update([
            'status' => 'cancelled'
        ]);

        return redirect()->back()->with('success', 'Penyewaan telah dibatalkan dan unit kembali tersedia.');
    }

    public function report(Request $request)
    {
        $query = Rental::with('car');

        if ($request->start_date && $request->end_date) {
            $query->whereBetween('rental_date', [$request->start_date, $request->end_date]);
        }

        $rentals = $query->orderBy('created_at', 'desc')->paginate(10);

        $statsQuery = Rental::query();
        if ($request->start_date && $request->end_date) {
            $statsQuery->whereBetween('rental_date', [$request->start_date, $request->end_date]);
        }

        $totalRevenue = $statsQuery->clone()->where('status', 'completed')->sum('total_price');
        $totalPaid = $statsQuery->clone()->sum('amount_paid');
        $totalPending = $statsQuery->clone()->where('status', 'ongoing')->get()->sum(function ($r) {
            return $r->total_price - $r->amount_paid;
        });

        return view('admin.rentals.report', compact('rentals', 'totalRevenue', 'totalPaid', 'totalPending'));
    }
}

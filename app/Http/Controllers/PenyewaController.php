<?php

namespace App\Http\Controllers;

use App\Models\Rental;
use App\Models\ReturnCar;
use App\Models\Vehicle;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PenyewaController extends Controller
{
    public function index(Request $request)
    {
        $vehicles = Vehicle::query()->orderBy('model', 'asc')->get();
        $query = Rental::with(['vehicle.car', 'vehicle.motorcycle', 'payment', 'user.userDetail'])
            ->withSum(['payment as total_paid' => function ($q) {
                $q->where('status', 'paid');
            }], 'net_amount');
        if ($request->filled('search')) {
            $searchTerm = '%' . $request->search . '%';
            $query->whereHas('user.userDetail', function ($q) use ($searchTerm) {
                $q->where('full_name', 'like', $searchTerm)
                    ->orWhere('phone', 'like', $searchTerm);
            });
        }
        if ($request->filled('vehicle_type')) {
            $query->whereHas('vehicle', function ($q) use ($request) {
                $q->where('vehicle_type', $request->vehicle_type);
            });
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        $recentRentals = $query->orderBy('created_at', 'desc')->get()
            ->map(function ($rental) {
                $rental->remaining_payment = $rental->total_price - ($rental->total_paid ?? 0);
                return $rental;
            });
        return view('admin.rentals.index', compact('vehicles', 'recentRentals'));
    }

    public function update(Request $request, $id)
    {
        $rental = Rental::with(['vehicle'])->findOrFail($id);
        $returnDateActual = Carbon::parse($request->return_date);
        $returnDateScheduled = Carbon::parse($rental->return_date_scheduled);

        $penalty = 0;

        if ($returnDateActual->greaterThan($returnDateScheduled)) {
            $lateDays = $returnDateActual->copy()->startOfDay()->diffInDays($returnDateScheduled->copy()->startOfDay(), true);
            if ($lateDays == 0) {
                $lateDays = 1;
            }

            if ($lateDays > 0) {
                $dailyPrice = $rental->vehicle->daily_rate ?? 0;
                $penaltyPerDay = $dailyPrice + ($dailyPrice * 0.10);
                $penalty = $lateDays * $penaltyPerDay;
                $rental->total_price += $penalty;
                $rental->save();
            }
        }

        ReturnCar::create([
            'rental_id'       => $rental->id,
            'return_date'     => Carbon::parse($request->return_date),
            'car_condition'   => $request->car_condition ?? 'Good',
            'payment_penalty' => $penalty,
            'admin_notes'     => $request->admin_notes,
        ]);

        $rental->update([
            'status' => 'completed'
        ]);

        return redirect()->back()->with('success', 'Unit berhasil dikembalikan.' . ($penalty > 0 ? ' Terkena denda keterlambatan sebesar Rp ' . number_format($penalty, 0, ',', '.') : ''));
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

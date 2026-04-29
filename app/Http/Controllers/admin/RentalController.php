<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\Rental;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class RentalController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'car_id' => 'required|exists:cars,id',
            'rental_date' => 'required|date|after_or_equal:today',
            'return_date_scheduled' => 'required|date|after:rental_date',
        ]);

        $car = Car::findOrFail($request->car_id);

        if ($car->status !== 'available') {
            return back()->with('error', 'Maaf, mobil ini sedang tidak tersedia.');
        }

        $start = Carbon::parse($request->rental_date);
        $end = Carbon::parse($request->return_date_scheduled);
        $days = $start->diffInDays($end);
        if ($days == 0) $days = 1;

        $totalPrice = $days * $car->daily_rate;

        Rental::create([
            'user_id' => Auth::id(),
            'car_id' => $car->id,
            'rental_date' => $request->rental_date,
            'return_date_scheduled' => $request->return_date_scheduled,
            'total_price' => $totalPrice,
            'status' => 'pending'
        ]);

        $car->update(['status' => 'rented']);

        return redirect()->route('customer.bookings')->with('success', 'Pemesanan berhasil! Silakan lakukan pembayaran.');
    }
}

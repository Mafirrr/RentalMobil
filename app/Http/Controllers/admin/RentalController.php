<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\Rating;
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

    public function rating(Request $request)
    {
        $request->validate([
            'rental_id' => 'required|integer',
            'rating'    => 'required|integer|between:1,5',
            'comment'   => 'required|string|max:500',
        ], [
            'rating.required'  => 'Anda wajib memilih jumlah bintang.',
            'comment.required' => 'Komentar ulasan tidak boleh kosong.',
            'comment.max'      => 'Ulasan terlalu panjang, maksimal 500 karakter.'
        ]);
        $rental = Rental::find($request->rental_id);

        if (!$rental) {
            return redirect()->back()->with('error', 'Data transaksi tidak ditemukan.');
        }
        if ($rental->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses untuk mengulas transaksi ini.');
        }
        if ($rental->status !== 'completed' || $rental->remaining_amount > 0) {
            return redirect()->back()->with('error', 'Anda hanya bisa memberikan ulasan pada transaksi yang sudah selesai dan lunas.');
        }
        $alreadyReviewed = Rating::where('rental_id', $request->rental_id)->exists();
        if ($alreadyReviewed) {
            return redirect()->back()->with('warning', 'Anda sudah memberikan ulasan untuk transaksi ini sebelumnya.');
        }
        try {
            Rating::create([
                'rental_id' => $request->rental_id,
                'rating'    => $request->rating,
                'comment'   => strip_tags($request->comment),
            ]);

            return redirect()->back()->with('success', 'Terima kasih! Ulasan Anda berhasil dikirim.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengirim ulasan. Silakan coba beberapa saat lagi.');
        }
    }
}

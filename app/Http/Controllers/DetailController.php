<?php

namespace App\Http\Controllers;

use App\Models\Rental;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DetailController extends Controller
{
    public function detail($id)
    {
        $vehicle = Vehicle::with(['car', 'motorcycle', 'category'])->findOrFail($id);
        $rentalsWithRating = Rental::with('rating')
            ->where('vehicle_id', $id)
            ->has('rating')
            ->get();

        $rating = $rentalsWithRating->pluck('rating.skala_rating')->avg() ?? 0;
        $total_ulasan = $rentalsWithRating->count();

        $riwayat = DB::table('vehicle_price_histories')
            ->where('vehicle_id', $id)
            ->orderBy('changed_at', 'desc')
            ->first();

        $hargaLama = $riwayat ? $riwayat->old_price : null;
        $similar_vehicles = Vehicle::with(['category', 'car', 'motorcycle'])
            ->where('category_id', $vehicle->category_id)
            ->where('vehicle_type', $vehicle->vehicle_type)
            ->where('id', '!=', $id)
            ->latest()
            ->take(3)
            ->get();

        $isSaved = false;
        if (Auth::check()) {
            $isSaved = DB::table('wishlists')
                ->where('user_id', Auth::id())
                ->where('vehicle_id', $id)
                ->exists();
        }

        return view('detail', compact('vehicle', 'rating', 'total_ulasan', 'hargaLama', 'similar_vehicles', 'isSaved'));
    }
}

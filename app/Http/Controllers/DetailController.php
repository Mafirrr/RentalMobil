<?php

namespace App\Http\Controllers;

use App\Models\Rental;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DetailController extends Controller
{
    public function detail($id)
    {
        $vehicle = Vehicle::with(['car', 'category'])->findOrFail($id);
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
        $similar_vehicles = Vehicle::with(['category', 'car'])
            ->where('category_id', $vehicle->category_id)
            ->where('vehicle_type', $vehicle->vehicle_type)
            ->where('id', '!=', $id)
            ->latest()
            ->take(3)
            ->get();

        foreach ($similar_vehicles as $similar) {
            $similar->image_front = !empty($similar->image_front)
                ? $similar->image_front
                : asset('images/placeholder.jpg');
        }

        $isSaved = false;
        if (Auth::check()) {
            $isSaved = DB::table('wishlists')
                ->where('user_id', Auth::id())
                ->where('vehicle_id', $id)
                ->exists();
        }

        $images = [
            'front'    => null,
            'side'     => null,
            'interior' => null,
            'engine'   => null,
        ];

        if (!empty($vehicle->image_front)) $images['front'] = $vehicle->image_front;
        if (!empty($vehicle->image_side)) $images['side'] = $vehicle->image_side;
        if (!empty($vehicle->image_interior)) $images['interior'] = $vehicle->image_interior;
        if (!empty($vehicle->image_engine)) $images['engine'] = $vehicle->image_engine;

        $vehicle->images_gallery = $images;
        return view('detail', compact('vehicle', 'rating', 'total_ulasan', 'hargaLama', 'similar_vehicles', 'isSaved'));
    }
}

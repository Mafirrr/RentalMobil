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

        foreach ($similar_vehicles as $similar) {
            $similarImages = ['front' => null];
            $similarFolderPath = 'vehicles/' . $similar->id;
            if (Storage::disk('public')->exists($similarFolderPath)) {
                $files = Storage::disk('public')->files($similarFolderPath);
                foreach ($files as $file) {
                    if (Str::startsWith(basename($file), 'foto_depan')) {
                        $similarImages['front'] = asset('storage/' . $file);
                        break;
                    }
                }
            }
            $similar->image_front = $similarImages['front'];
        }

        $isSaved = false;
        if (Auth::check()) {
            $isSaved = DB::table('wishlists')
                ->where('user_id', Auth::id())
                ->where('vehicle_id', $id)
                ->exists();
        }
        $images = [
            'samping'  => null,
            'depan'    => null,
            'interior' => null,
            'mesin'    => null,
        ];

        $folderPath = 'vehicles/' . $id;

        if (Storage::disk('public')->exists($folderPath)) {
            $files = Storage::disk('public')->files($folderPath);
            foreach ($files as $file) {
                $filename = basename($file);
                if (Str::startsWith($filename, 'foto_samping')) {
                    $images['samping'] = asset('storage/' . $file);
                } elseif (Str::startsWith($filename, 'foto_depan')) {
                    $images['depan'] = asset('storage/' . $file);
                } elseif (Str::startsWith($filename, 'foto_interior')) {
                    $images['interior'] = asset('storage/' . $file);
                } elseif (Str::startsWith($filename, 'foto_mesin')) {
                    $images['mesin'] = asset('storage/' . $file);
                }
            }
        }

        $vehicle->images_gallery = $images;
        return view('detail', compact('vehicle', 'rating', 'total_ulasan', 'hargaLama', 'similar_vehicles', 'isSaved'));
    }
}

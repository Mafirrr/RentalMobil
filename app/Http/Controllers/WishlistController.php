<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WishlistController extends Controller
{
    public function toggleWishlist($id)
    {
        if (!Auth::check()) {
            return response()->json(['status' => 'unauthorized'], 401);
        }

        $userId = Auth::id();
        $wishlist = DB::table('wishlists')
            ->where('user_id', $userId)
            ->where('vehicle_id', $id)
            ->first();

        if ($wishlist) {
            DB::table('wishlists')->where('id', $wishlist->id)->delete();
            return response()->json(['status' => 'removed']);
        } else {
            DB::table('wishlists')->insert([
                'user_id' => $userId,
                'vehicle_id' => $id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            return response()->json(['status' => 'added']);
        }
    }
}

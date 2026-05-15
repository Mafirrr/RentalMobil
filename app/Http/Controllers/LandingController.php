<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Vehicle;
use Illuminate\Http\Request;


class LandingController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();

        $query = Vehicle::with('category', 'car', 'motorcycle');

        if ($request->has('category') && $request->category != '') {
            $query->where('category_id', $request->category);
        }

        $vehicles = $query->latest()->take(6)->get();

        return view('welcome', compact('vehicles', 'categories'));
    }
}

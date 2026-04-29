<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Category;
use Illuminate\Http\Request;


class LandingController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();

        $query = Car::with('category');

        if ($request->has('category') && $request->category != '') {
            $query->where('category_id', $request->category);
        }

        $cars = $query->latest()->get();

        return view('welcome', compact('cars', 'categories'));
    }
}

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

        $query = Vehicle::with(['category', 'car', 'motorcycle']);

        if ($request->has('category') && $request->category != '') {
            $query->where('category_id', $request->category);
        }

        $vehicles = $query->latest()->take(6)->get();

        return view('welcome', compact('vehicles', 'categories'));
    }

    public function category(Request $request)
    {
        $categories = Category::all();
        $query = Vehicle::with(['car', 'motorcycle', 'category']);

        if ($request->filled('type')) {
            $query->where('vehicle_type', $request->type);
        }

        if ($request->filled('category')) {
            $categoryName = $request->category;
            $query->whereHas('category', function ($q) use ($categoryName) {
                $q->where('name', $categoryName);
            });
        }

        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('model', 'like', '%' . $searchTerm . '%')
                    ->orWhere('plate_number', 'like', '%' . $searchTerm . '%');
            });
        }

        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'price-asc':
                    $query->orderBy('daily_rate', 'asc');
                    break;
                case 'price-desc':
                    $query->orderBy('daily_rate', 'desc');
                    break;
                case 'name-asc':
                    $query->orderBy('model', 'asc');
                    break;
                default:
                    $query->latest();
                    break;
            }
        } else {
            $query->latest();
        }

        $allVehicles = $query->get();

        $cars = $allVehicles->filter(function ($vehicle) {
            return !is_null($vehicle->car);
        });

        $motorcycles = $allVehicles->filter(function ($vehicle) {
            return !is_null($vehicle->motorcycle);
        });

        return view('category', compact('motorcycles', 'cars', 'categories'));
    }
}

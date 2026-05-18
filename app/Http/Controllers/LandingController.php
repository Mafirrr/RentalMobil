<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Rental;
use App\Models\Vehicle;
use App\Models\Wishlist;
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

    public function wishlist(Request $request)
    {
        $userId = auth()->id();
        $search = $request->input('search');
        $categoryName = $request->input('category');
        $sort = $request->input('sort', 'default');
        $type = $request->input('type');

        $wishlistQuery = Wishlist::where('user_id', $userId)
            ->whereHas('vehicles');

        $categories = Category::all();

        $cars = collect();
        if (empty($type) || $type === 'car') {
            $carsQuery = clone $wishlistQuery;

            // Filter hanya yang memiliki relasi mobil
            $carsQuery->whereHas('vehicles.car', function ($q) use ($search, $categoryName) {
                if ($search) {
                    $q->where('model', 'like', "%{$search}%");
                }
            });

            if ($categoryName) {
                $carsQuery->whereHas('vehicles.category', function ($q) use ($categoryName) {
                    $q->where('name', $categoryName);
                });
            }

            $cars = $carsQuery->with(['vehicles.car', 'vehicles.category'])->get()->pluck('vehicles');

            if ($sort === 'price-asc') {
                $cars = $cars->sortBy('daily_rate');
            } elseif ($sort === 'price-desc') {
                $cars = $cars->sortByDesc('daily_rate');
            } elseif ($sort === 'name-asc') {
                $cars = $cars->sortBy('model');
            }
        }

        $motorcycles = collect();
        if (empty($type) || $type === 'motorcycle') {
            $motorcyclesQuery = clone $wishlistQuery;

            $motorcyclesQuery->whereHas('vehicles.motorcycle', function ($q) use ($search) {
                if ($search) {
                    $q->where('model', 'like', "%{$search}%");
                }
            });

            if ($categoryName) {
                $motorcyclesQuery->whereHas('vehicles.category', function ($q) use ($categoryName) {
                    $q->where('name', $categoryName);
                });
            }

            $motorcycles = $motorcyclesQuery->with(['vehicles.motorcycle', 'vehicles.category'])->get()->pluck('vehicles');

            if ($sort === 'price-asc') {
                $motorcycles = $motorcycles->sortBy('daily_rate');
            } elseif ($sort === 'price-desc') {
                $motorcycles = $motorcycles->sortByDesc('daily_rate');
            } elseif ($sort === 'name-asc') {
                $motorcycles = $motorcycles->sortBy('model');
            }
        }

        return view('wishlist', compact('cars', 'motorcycles', 'categories'));
    }

    public function riwayat(Request $request)
    {
        $userId = auth()->id();
        $status = $request->input('status');
        $type = $request->input('type');
        $search = $request->input('search');

        $query = Rental::where('user_id', $userId)
            ->with(['vehicle.car', 'vehicle.motorcycle', 'vehicle.category', 'payment']);

        if ($status) {
            $query->where('status', $status);
        }

        if ($type) {
            if ($type === 'car') {
                $query->whereHas('vehicle.car');
            } elseif ($type === 'motorcycle') {
                $query->whereHas('vehicle.motorcycle');
            }
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('booking_code', 'like', "%{$search}%")
                    ->orWhereHas('vehicle', function ($vQ) use ($search) {
                        $vQ->where('model', 'like', "%{$search}%");
                    });
            });
        }

        $bookings = $query->latest()->get();

        // dd($bookings->payment);
        // dd($bookings->payment->net_amount);

        return view('riwayat', compact('bookings'));
    }
}

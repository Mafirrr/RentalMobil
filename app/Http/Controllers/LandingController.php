<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Rental;
use App\Models\Vehicle;
use App\Models\Wishlist;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Str;

class LandingController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();

        $query = Vehicle::with(['category', 'car', 'motorcycle'])->where('status', 'available');

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

        $bookings->each(function ($booking) {
            $payments = $booking->payment;
            $dpPayment = $payments->where('status', 'paid')->first();
            $repayment = $dpPayment
                ? $payments->where('id', '!=', $dpPayment->id)->first()
                : null;
            if ($repayment && $repayment->status === 'paid') {
                $booking->remaining_amount = 0;
            } elseif ($dpPayment) {
                $booking->remaining_amount = $booking->total_price - $dpPayment->amount;
            } else {
                $booking->remaining_amount = $booking->total_price;
            }
            $booking->is_repayment_created = (bool) $repayment;
            $booking->repayment_status = $repayment ? $repayment->status : 'unpaid';
        });
        return view('riwayat', compact('bookings'));
    }

    public function search(Request $request)
    {
        $categories = Category::all();

        $lokasi = $request->get('lokasi');
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');
        $kapasitasDibutuhkan = (int) $request->get('kapasitas', 2);
        $priceRange = $request->get('price_range');

        if (!$lokasi || !$startDate || !$endDate) {
            return redirect()->back()->with('error', 'Silakan isi parameter pencarian terlebih dahulu.');
        }

        $start = Carbon::parse($startDate);
        $end = Carbon::parse($endDate);
        $diffInDays = Carbon::now()->startOfDay()->diffInDays($end->startOfDay()) + 1;

        if ($diffInDays > 3) {
            $diffInDays = 3;
        }

        $cacheKey = 'weather_' . Str::slug($lokasi) . '_' . $diffInDays;

        $isRainyPeriod = Cache::remember($cacheKey, now()->addHours(2), function () use ($lokasi, $diffInDays, $start, $end) {
            try {
                $response = Http::timeout(3)->get("https://api.weatherapi.com/v1/forecast.json", [
                    'key'  => env('WHEATER_API'),
                    'q'    => $lokasi . ', Indonesia',
                    'days' => $diffInDays,
                ]);

                if ($response->successful()) {
                    $weatherResponse = $response->json();
                    if (isset($weatherResponse['forecast']['forecastday'])) {
                        foreach ($weatherResponse['forecast']['forecastday'] as $forecast) {
                            $date = Carbon::parse($forecast['date']);
                            if ($date->between($start, $end)) {
                                $condition = strtolower($forecast['day']['condition']['text']);
                                if (str_contains($condition, 'rain') || str_contains($condition, 'storm')) {
                                    return true;
                                }
                            }
                        }
                    }
                }
            } catch (\Exception $e) {
            }
            return false;
        });

        $baseQuery = Vehicle::with(['category', 'car', 'motorcycle'])->where('status', 'available');

        if ($kapasitasDibutuhkan > 2) {
            $baseQuery->whereHas('car', function ($q) use ($kapasitasDibutuhkan) {
                $q->where('capacity', '>=', $kapasitasDibutuhkan);
            });
        } else {
            $baseQuery->where(function ($q) use ($kapasitasDibutuhkan) {
                $q->whereHas('car', function ($subQ) use ($kapasitasDibutuhkan) {
                    $subQ->where('capacity', '>=', $kapasitasDibutuhkan);
                })->orHas('motorcycle');
            });
        }

        if ($priceRange && $priceRange !== 'all') {
            [$minPrice, $maxPrice] = explode('-', $priceRange);
            $baseQuery->whereBetween('daily_rate', [$minPrice, $maxPrice]);
        }

        if ($request->filled('category')) {
            $baseQuery->whereHas('category', function ($q) use ($request) {
                $q->where('name', $request->category);
            });
        }

        if ($request->filled('search')) {
            $keyword = $request->search;
            $baseQuery->where('model', 'like', "%{$keyword}%");
        }

        $selectedCategory = $request->get('category');

        $carQuery = clone $baseQuery;
        $motorQuery = clone $baseQuery;

        if ($selectedCategory === 'motorcycle' || $request->get('type') === 'motorcycle') {
            $carQuery->whereRaw('1 = 0');
            $motorQuery->where('vehicle_type', 'motorcycle');
        } elseif ($selectedCategory === 'car' || $request->get('type') === 'car') {
            $carQuery->where('vehicle_type', 'car');
            $motorQuery->whereRaw('1 = 0');
        } else {
            $carQuery->where('vehicle_type', 'car');
            $motorQuery->where('vehicle_type', 'motorcycle');
        }

        $sortOption = $request->get('sort', 'default');
        if ($sortOption === 'price-asc') {
            $carQuery->orderBy('daily_rate', 'asc');
            $motorQuery->orderBy('daily_rate', 'asc');
        } elseif ($sortOption === 'price-desc') {
            $carQuery->orderBy('daily_rate', 'desc');
            $motorQuery->orderBy('daily_rate', 'desc');
        } elseif ($sortOption === 'name-asc') {
            $carQuery->orderBy('model', 'asc');
            $motorQuery->orderBy('model', 'asc');
        } else {
            if ($isRainyPeriod) {
                $carQuery->orderBy('daily_rate', 'asc');
                $motorQuery->orderBy('daily_rate', 'asc');
            } else {
                $carQuery->orderBy('daily_rate', 'asc');
                $motorQuery->orderBy('daily_rate', 'asc');
            }
        }

        $perPage = 8;

        $cars = $carQuery->paginate($perPage, ['*'], 'cars_page');
        $motorcycles = $motorQuery->paginate($perPage, ['*'], 'motorcycles_page');

        $cars->appends($request->all());
        $motorcycles->appends($request->all());

        $pesanCuaca = $isRainyPeriod
            ? "Peringatan cuaca: Diperkirakan hujan di " . $lokasi . " selama waktu sewa. Kami mengutamakan rekomendasi kendaraan roda 4 demi kenyamanan Anda."
            : "Cuaca diprediksi cerah di " . $lokasi . ". Silakan pilih armada terbaik Anda!";

        return view('pencarian', compact('cars', 'motorcycles', 'pesanCuaca', 'isRainyPeriod', 'categories'));
    }
}

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
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class LandingController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();
        $query = Vehicle::with(['category', 'car'])->where('status', 'available');
        if ($request->has('category') && $request->category != '') {
            $query->where('category_id', $request->category);
        }
        $vehicles = $query->latest()->take(6)->get();
        foreach ($vehicles as $vehicle) {
            $images = [
                'front'    => asset('images/placeholder.jpg'),
                'side'     => asset('images/placeholder.jpg'),
                'interior' => asset('images/placeholder.jpg'),
                'engine'   => asset('images/placeholder.jpg'),
            ];
            if (!empty($vehicle->image_front)) $images['front'] = $vehicle->image_front;
            if (!empty($vehicle->image_side)) $images['side'] = $vehicle->image_side;
            if (!empty($vehicle->image_interior)) $images['interior'] = $vehicle->image_interior;
            if (!empty($vehicle->image_engine)) $images['engine'] = $vehicle->image_engine;

            $vehicle->images_data = $images;
        }
        return view('welcome', compact('vehicles', 'categories'));
    }

    public function category(Request $request)
    {
        $categories = Category::all();

        $query = Vehicle::with(['car', 'category']);

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

        $cars = $query->paginate(8)->withQueryString();

        foreach ($cars as $car) {
            $car->images_data = [
                'front'    => !empty($car->image_front) ? $car->image_front : asset('images/placeholder.jpg'),
                'side'     => !empty($car->image_side) ? $car->image_side : asset('images/placeholder.jpg'),
                'interior' => !empty($car->image_interior) ? $car->image_interior : asset('images/placeholder.jpg'),
                'engine'   => !empty($car->image_engine) ? $car->image_engine : asset('images/placeholder.jpg'),
            ];
        }

        return view('category', compact('cars', 'categories'));
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

        return view('wishlist', compact('cars',  'categories'));
    }

    public function riwayat(Request $request)
    {
        $userId = auth()->id();
        $status = $request->input('status');
        $type = $request->input('type');
        $search = $request->input('search');

        $query = Rental::where('user_id', $userId)
            ->with(['vehicle.car', 'vehicle.category', 'payment'])
            ->withSum(['payment as total_paid' => function ($q) {
                $q->where('status', 'paid');
            }], 'net_amount');

        if ($status) {
            $query->where('status', $status);
        }

        if ($type) {
            if ($type === 'car') {
                $query->whereHas('vehicle.car');
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
            $totalPaid = $booking->total_paid ?? 0;
            $booking->remaining_amount = max(0, $booking->total_price - $totalPaid);
            $payments = $booking->payment;
            $dpPayment = $payments->where('status', 'paid')->first();
            $repayment = $dpPayment
                ? $payments->where('id', '!=', $dpPayment->id)->first()
                : null;

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
                // Log error jika diperlukan
            }
            return false;
        });

        $carQuery = Vehicle::with(['category', 'car'])
            ->where('status', 'available')
            ->where('vehicle_type', 'car');

        if ($kapasitasDibutuhkan > 0) {
            $carQuery->whereHas('car', function ($q) use ($kapasitasDibutuhkan) {
                $q->where('capacity', '>=', $kapasitasDibutuhkan);
            });
        }

        if ($priceRange && $priceRange !== 'all') {
            [$minPrice, $maxPrice] = explode('-', $priceRange);
            $carQuery->whereBetween('daily_rate', [$minPrice, $maxPrice]);
        }

        if ($request->filled('category')) {
            $carQuery->whereHas('category', function ($q) use ($request) {
                $q->where('name', $request->category);
            });
        }

        if ($request->filled('search')) {
            $keyword = $request->search;
            $carQuery->where('model', 'like', "%{$keyword}%");
        }

        $sortOption = $request->get('sort', 'default');
        if ($sortOption === 'price-asc') {
            $carQuery->orderBy('daily_rate', 'asc');
        } elseif ($sortOption === 'price-desc') {
            $carQuery->orderBy('daily_rate', 'desc');
        } elseif ($sortOption === 'name-asc') {
            $carQuery->orderBy('model', 'asc');
        } else {
            $carQuery->orderBy('daily_rate', 'asc');
        }

        $perPage = 8;
        $cars = $carQuery->paginate($perPage, ['*'], 'cars_page');
        $cars->appends($request->all());

        foreach ($cars as $car) {
            $car->images_data = [
                'front'    => !empty($car->image_front) ? $car->image_front : asset('images/placeholder.jpg'),
                'side'     => !empty($car->image_side) ? $car->image_side : asset('images/placeholder.jpg'),
                'interior' => !empty($car->image_interior) ? $car->image_interior : asset('images/placeholder.jpg'),
                'engine'   => !empty($car->image_engine) ? $car->image_engine : asset('images/placeholder.jpg'),
            ];
        }

        $pesanCuaca = $isRainyPeriod
            ? "Informasi cuaca: Diperkirakan akan turun hujan di wilayah " . $lokasi . " selama masa sewa Anda. Pastikan performa wiper dan ban mobil dalam kondisi prima."
            : "Cuaca diprediksi cerah di wilayah " . $lokasi . ". Selamat menikmati perjalanan Anda dengan armada pilihan kami!";

        return view('pencarian', compact('cars', 'pesanCuaca', 'isRainyPeriod', 'categories'));
    }
}

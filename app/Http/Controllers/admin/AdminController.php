<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\Category;
use App\Models\Motorcycle;
use App\Models\Rating;
use App\Models\Rental;
use App\Models\Vehicle;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $totalArmada = Vehicle::count();
        $penyewaAktif = Rental::where('status', 'ongoing')->distinct('user_id')->count('user_id');
        $pendapatanCompleted = Rental::where('status', 'completed')->sum('amount_paid');

        $pendapatanOngoing = Rental::where('rentals.status', 'ongoing')
            ->join('payments', 'rentals.id', '=', 'payments.rental_id')
            ->where('payments.status', 'paid')
            ->sum('payments.net_amount');

        $totalPendapatan = $pendapatanCompleted + $pendapatanOngoing;
        $ratingRataRata = Rating::avg('rating') ?? 0.0;
        $totalUlasan = Rating::count();

        $availableMonths = Rental::select(
            DB::raw('MONTH(rental_date) as month'),
            DB::raw('YEAR(rental_date) as year')
        )
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get()
            ->map(function ($item) {
                $date = Carbon::createFromDate($item->year, $item->month, 1)->locale('id');
                return [
                    'value' => $date->format('Y-m'),
                    'label' => $date->monthName . ' ' . $item->year
                ];
            });

        $defaultMonthValue = $availableMonths->first()['value'] ?? Carbon::now()->format('Y-m');
        $selectedMonthValue = $request->get('month', $defaultMonthValue);

        if (!str_contains($selectedMonthValue, '-')) {
            try {
                $parseMonth = Carbon::parse("1 " . $selectedMonthValue)->locale('id');
                $monthNumber = $parseMonth->month;
                $yearNumber = Carbon::now()->year;
                $selectedMonthValue = $yearNumber . '-' . str_pad($monthNumber, 2, '0', STR_PAD_LEFT);
            } catch (\Exception $e) {
                $monthNumber = Carbon::now()->month;
                $yearNumber = Carbon::now()->year;
            }
        } else {
            $parts = explode('-', $selectedMonthValue);
            $yearNumber = (int)$parts[0];
            $monthNumber = (int)$parts[1];
        }

        $daysInMonth = Carbon::createFromDate($yearNumber, $monthNumber, 1)->daysInMonth;

        $rentalDailyData = Rental::select(
            DB::raw('DAY(rental_date) as day'),
            DB::raw('COUNT(*) as total')
        )
            ->whereIn('status', ['ongoing', 'completed'])
            ->whereMonth('rental_date', $monthNumber)
            ->whereYear('rental_date', $yearNumber)
            ->groupBy('day')
            ->pluck('total', 'day')
            ->toArray();


        $chartLabels = [];
        $chartData = [];
        for ($day = 1; $day <= $daysInMonth; $day++) {
            $chartLabels[] = "Tgl $day";
            $chartData[] = $rentalDailyData[$day] ?? 0;
        }

        return view('admin.dashboard', compact(
            'totalArmada',
            'penyewaAktif',
            'totalPendapatan',
            'ratingRataRata',
            'totalUlasan',
            'chartLabels',
            'chartData',
            'availableMonths',
            'selectedMonthValue'
        ));
    }
    public function vehicles(Request $request)
    {
        $query = Vehicle::query()->with(['car']);

        if ($request->has('search')) {
            $query->where('model', 'like', '%' . $request->search . '%')
                ->orWhere('plate_number', 'like', '%' . $request->search . '%');
        }

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $vehicles = $query->latest()->paginate(11)->withQueryString();

        return view('admin.cars.index', compact('vehicles'));
    }

    public function createCar()
    {
        $categories = Category::all();
        return view('admin.cars.create', compact('categories'));
    }

    public function storeCar(Request $request)
    {
        $type = $request->vehicle_type;

        DB::beginTransaction();
        try {
            $vehicle = Vehicle::create([
                'category_id' => $request->category_id,
                'vehicle_type' => $type,
                'model' => $request->model,
                'plate_number' => $request->plate_number,
                'year' => $request->year ?? date('Y'),
                'color' => $request->color ?? 'Hitam',
                'daily_rate' => $request->daily_rate,
            ]);

            $imagePositions = ['image_front', 'image_side', 'image_interior', 'image_engine'];
            $uploadedImages = [];

            foreach ($imagePositions as $position) {
                if ($request->hasFile($position)) {
                    switch ($position) {
                        case 'image_front':
                            $customName = 'foto_depan';
                            break;
                        case 'image_side':
                            $customName = 'foto_samping';
                            break;
                        case 'image_interior':
                            $customName = 'foto_interior';
                            break;
                        case 'image_engine':
                            $customName = 'foto_mesin';
                            break;
                        default:
                            $customName = $position;
                    }
                    $file = $request->file($position);
                    $extension = $file->getClientOriginalExtension();
                    $fileName = $customName . '.' . $extension;
                    $folderPath = 'vehicles/' . $vehicle->id;

                    $path = Storage::disk('supabase')->putFileAs($folderPath, $file, $fileName);

                    $s3Url = Storage::disk('supabase')->url($path);
                    $urlPublic = str_replace(
                        '.storage.supabase.co/storage/v1/s3/',
                        '.supabase.co/storage/v1/object/public/',
                        $s3Url
                    );
                    $uploadedImages[$position] = $urlPublic;
                }
            }

            if (!empty($uploadedImages)) {
                $vehicle->update($uploadedImages);
            }

            if ($type === 'car') {
                Car::create([
                    'vehicle_id' => $vehicle->id,
                    'capacity' => $request->capacity,
                    'transmission' => $request->transmission,
                    'fuel_type' => $request->fuel_type,
                ]);
            }

            DB::commit();
            return redirect()->route('admin.vehicles')->with('success', 'Armada berhasil ditambahkan!');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', $e->getMessage());
        }
    }

    public function editCar($id)
    {
        $vehicle = Vehicle::with(['car'])->findOrFail($id);
        $categories = Category::all();

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

        return view('admin.cars.edit', compact('vehicle', 'categories', 'images'));
    }

    public function updateCar(Request $request, $id)
    {
        $vehicle = Vehicle::findOrFail($id);

        DB::beginTransaction();
        try {
            $vehicleData = [
                'category_id'  => $request->category_id,
                'model'        => $request->model,
                'plate_number' => $request->plate_number,
                'year'         => $request->year ?? date('Y'),
                'color'        => $request->color ?? 'Hitam',
                'daily_rate'   => $request->daily_rate,
            ];

            $imagePositions = ['image_front', 'image_side', 'image_interior', 'image_engine'];

            foreach ($imagePositions as $position) {
                if ($request->hasFile($position)) {
                    if (!empty($vehicle->$position)) {
                        $pathOnly = parse_url($vehicle->$position, PHP_URL_PATH);
                        $bucketName = env('SUPABASE_BUCKET', 'laravel-rental');
                        $cleanOldPath = Str::after($pathOnly, $bucketName . '/');

                        if (Storage::disk('supabase')->exists($cleanOldPath)) {
                            Storage::disk('supabase')->delete($cleanOldPath);
                        }
                    }

                    switch ($position) {
                        case 'image_front':
                            $customName = 'foto_depan';
                            break;
                        case 'image_side':
                            $customName = 'foto_samping';
                            break;
                        case 'image_interior':
                            $customName = 'foto_interior';
                            break;
                        case 'image_engine':
                            $customName = 'foto_mesin';
                            break;
                        default:
                            $customName = $position;
                    }
                    $file = $request->file($position);
                    $extension = $file->getClientOriginalExtension();
                    $fileName = $customName . '_' . time() . '.' . $extension;
                    $folderPath = 'vehicles/' . $id;
                    $path = Storage::disk('supabase')->putFileAs($folderPath, $file, $fileName);
                    $s3Url = Storage::disk('supabase')->url($path);
                    $urlPublic = str_replace(
                        '.storage.supabase.co/storage/v1/s3/',
                        '.supabase.co/storage/v1/object/public/',
                        $s3Url
                    );
                    $vehicleData[$position] = $urlPublic;
                }
            }

            $vehicle->update($vehicleData);

            if ($vehicle->vehicle_type === 'car') {
                $vehicle->car()->update([
                    'capacity' => $request->capacity,
                    'transmission' => $request->transmission,
                    'fuel_type' => $request->fuel_type,
                ]);
            }

            DB::commit();
            return redirect()->route('admin.vehicles')->with('success', 'Armada berhasil diupdate!');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', $e->getMessage());
        }
    }

    public function toggleMaintenance(Vehicle $vehicle)
    {

        $newStatus = ($vehicle->status === 'available') ? 'maintenance' : 'available';

        if ($vehicle->status === 'rented') {
            return redirect()->back()->with('error', 'Mobil sedang disewa, tidak bisa masuk mode maintenance.');
        }

        $vehicle->update(['status' => $newStatus]);

        return redirect()->back()->with('success', 'Status armada berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $vehicle = Vehicle::findOrFail($id);

        DB::beginTransaction();
        try {
            $imagePositions = ['image_front', 'image_side', 'image_interior', 'image_engine'];
            $bucketName = env('SUPABASE_BUCKET', 'laravel-rental');

            foreach ($imagePositions as $position) {
                if (!empty($vehicle->$position)) {
                    $pathOnly = parse_url($vehicle->$position, PHP_URL_PATH);
                    $cleanPath = Str::after($pathOnly, $bucketName . '/');
                    if (Storage::disk('supabase')->exists($cleanPath)) {
                        Storage::disk('supabase')->delete($cleanPath);
                    }
                }
            }
            $vehicle->delete();

            DB::commit();
            return redirect()->back()->with('success', 'Armada beserta seluruh fotonya berhasil dihapus!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Gagal menghapus armada: ' . $e->getMessage());
        }
    }
}

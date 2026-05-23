<?php

use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\admin\RentalController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\DetailController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PenyewaController;
use App\Http\Controllers\WishlistController;
use App\Models\Driver;
use App\Models\Rental;
use App\Models\Vehicle;
use Carbon\Carbon;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schedule;

Schedule::call(function () {
    $today = Carbon::today()->toDateString();
    $activeRentals = Rental::where('status', 'ongoing')
        ->whereDate('rental_date', '<=', $today)
        ->whereDate('return_date_scheduled', '>=', $today);

    $rentedVehicleIds = $activeRentals->clone()->pluck('vehicle_id')->filter()->toArray();
    $assignedDriverIds = $activeRentals->clone()->where('with_driver', 1)->pluck('driver_id')->filter()->toArray();

    Vehicle::whereNotIn('id', $rentedVehicleIds)
        ->where('status', '!=', 'available')
        ->update(['status' => 'available']);

    Vehicle::whereIn('id', $rentedVehicleIds)
        ->where('status', '!=', 'rented')
        ->update(['status' => 'rented']);

    Driver::whereNotIn('id', $assignedDriverIds)
        ->where('status', 'assigned')
        ->update(['status' => 'available']);

    Driver::whereIn('id', $assignedDriverIds)
        ->where('status', '!=', 'assigned')
        ->update(['status' => 'assigned']);
})->daily();

Route::get('/',  [LandingController::class, 'index'])->name('landing');
Route::get('forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])
    ->name('password.request');

Route::post('forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])
    ->name('password.email');
Route::get('reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])
    ->name('password.reset');

Route::post('reset-password', [ResetPasswordController::class, 'reset'])
    ->name('password.update');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    Route::prefix('vehicles')->group(function () {
        Route::get('/', [AdminController::class, 'vehicles'])->name('admin.vehicles');
        Route::get('/create', [AdminController::class, 'createCar'])->name('admin.vehicles.create');
        Route::post('/store', [AdminController::class, 'storeCar'])->name('admin.vehicles.store');
        Route::get('/edit/{id}', [AdminController::class, 'editCar'])->name('admin.vehicles.edit');
        Route::put('/update/{id}', [AdminController::class, 'updateCar'])->name('admin.vehicles.update');
        Route::put('/{vehicle}/toggle-maintenance', [AdminController::class, 'toggleMaintenance'])->name('admin.vehicles.maintenance');
        Route::delete('/delete/{id}', [AdminController::class, 'destroy'])->name('admin.vehicles.destroy');
    });

    Route::prefix('drivers')->group(function () {
        Route::get('/', [DriverController::class, 'index'])->name('admin.drivers');
        Route::post('/create', [DriverController::class, 'store'])->name('admin.drivers.store');
        Route::put('/update/{id}', [DriverController::class, 'update'])->name('admin.drivers.update');
        Route::delete('/delete/{id}', [DriverController::class, 'destroy'])->name('admin.drivers.destroy');
    });

    Route::prefix('rental')->group(function () {
        Route::get('/', [PenyewaController::class, 'index'])->name('admin.rentals');
        Route::put('/assign/{id}', [PenyewaController::class, 'assign'])->name('admin.rentals.assign-driver');
        Route::put('/return/{id}', [PenyewaController::class, 'update'])->name('admin.rentals.return');
        Route::put('/{rental}/cancel', [PenyewaController::class, 'cancel'])->name('admin.rentals.cancel');
    });
});

Route::get('/kendaraan', [LandingController::class, 'category'])->name('category');
Route::get('/pencarian', [LandingController::class, 'search'])->name('vehicle.search');
Route::get('/detail/{id}', [DetailController::class, 'detail'])->name('detail');


Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('/rent', [RentalController::class, 'store'])->name('rental.store');
    Route::post('/vehicle/{id}/wishlist', [WishlistController::class, 'toggleWishlist'])->name('vehicle.wishlist');
    Route::post('/pembayaran', [PaymentController::class, 'index'])->name('pembayaran');
    Route::post('/pelunasan', [PaymentController::class, 'pelunasan'])->name('pelunasan');
    Route::post('/pembayaran/tripay-api', [PaymentController::class, 'generateTripayPayment']);
    Route::post('/rentals/store', [PaymentController::class, 'store']);
    Route::get('/wishlist', [LandingController::class, 'wishlist'])->name('wishlist');
    Route::get('/pesanan', [LandingController::class, 'riwayat'])->name('riwayat');
    Route::post('/rating', [RentalController::class, 'rating'])->name('rating.store');
});

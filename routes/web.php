<?php

use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\admin\RentalController;
use App\Http\Controllers\DetailController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PenyewaController;
use App\Http\Controllers\WishlistController;
use Illuminate\Support\Facades\Route;

Route::get('/',  [LandingController::class, 'index'])->name('landing');

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

    Route::prefix('rental')->group(function () {
        Route::get('/', [PenyewaController::class, 'index'])->name('admin.rentals');
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
});

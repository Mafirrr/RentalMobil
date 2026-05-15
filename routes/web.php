<?php

use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\admin\RentalController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\PenyewaController;
use Illuminate\Support\Facades\Route;

Route::get('/',  [LandingController::class, 'index'])->name('landing');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
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
        Route::post('/add', [PenyewaController::class, 'store'])->name('admin.rentals.store');
        Route::put('/return/{id}', [PenyewaController::class, 'update'])->name('admin.rentals.return');
        Route::put('/{rental}/cancel', [PenyewaController::class, 'cancel'])->name('admin.rentals.cancel');
        Route::get('/report', [PenyewaController::class, 'report'])->name('admin.report');
    });
});

Route::get('/kendaraan', function () {
    return view('category');
})->name('category');

Route::get('/detail', function () {
    return view('detail');
})->name('detail');
Route::get('/pembayaran', function () {
    return view('pembayaran');
})->name('pembayaran');

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('/rent', [RentalController::class, 'store'])->name('rental.store');
    Route::get('/my-bookings', function () {
        return view('customer.bookings');
    })->name('customer.bookings');
});

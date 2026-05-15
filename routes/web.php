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

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    Route::get('/vehicles', [AdminController::class, 'vehicles'])->name('admin.vehicles');
    Route::get('/vehicles/create', [AdminController::class, 'createCar'])->name('admin.vehicles.create');
    Route::post('/vehicles/store', [AdminController::class, 'storeCar'])->name('admin.vehicles.store');
    Route::get('/vehicles/create', [AdminController::class, 'createCar'])->name('admin.vehicles.create');
    Route::get('/vehicles/edit/{id}', [AdminController::class, 'editCar'])->name('admin.vehicles.edit');
    Route::put('/vehicles/update/{id}', [AdminController::class, 'updateCar'])->name('admin.vehicles.update');
    Route::put('/vehicles/{vehicle}/toggle-maintenance', [AdminController::class, 'toggleMaintenance'])->name('admin.vehicles.maintenance');
    Route::delete('/vehicles/delete/{id}', [AdminController::class, 'destroy'])->name('admin.vehicles.destroy');

    Route::get('/rental', [PenyewaController::class, 'index'])->name('admin.rentals');
    Route::post('/rental/add', [PenyewaController::class, 'store'])->name('admin.rentals.store');
    Route::put('/rental/return/{id}', [PenyewaController::class, 'update'])->name('admin.rentals.return');
    Route::put('/rental/{rental}/cancel', [PenyewaController::class, 'cancel'])->name('admin.rentals.cancel');
    Route::get('/rental/report', [PenyewaController::class, 'report'])->name('admin.report');
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

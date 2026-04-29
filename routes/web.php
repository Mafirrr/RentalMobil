<?php

use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\admin\RentalController;
use App\Http\Controllers\LandingController;
use Illuminate\Support\Facades\Route;

Route::get('/',  [LandingController::class, 'index'])->name('landing');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/cars', [AdminController::class, 'cars'])->name('admin.cars');
    Route::get('/cars/create', [AdminController::class, 'createCar'])->name('admin.cars.create');
    Route::post('/cars/store', [AdminController::class, 'storeCar'])->name('admin.cars.store');
    Route::get('/cars/create', [AdminController::class, 'createCar'])->name('admin.cars.create');
    Route::get('/cars/edit/{id}', [AdminController::class, 'editCar'])->name('admin.cars.edit');
    Route::put('/cars/update/{id}', [AdminController::class, 'updateCar'])->name('admin.cars.update');
    Route::delete('/cars/delete/{id}', [AdminController::class, 'destroy'])->name('admin.cars.destroy');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('/rent', [RentalController::class, 'store'])->name('rental.store');
    Route::get('/my-bookings', function () {
        return view('customer.bookings');
    })->name('customer.bookings');
});

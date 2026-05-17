<?php

use App\Http\Controllers\Webhook\TripayCallbackController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/test', function () {
    return response()->json([
        'message' => 'API aktif'
    ]);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/callback-tripay', [TripayCallbackController::class, 'handle']);

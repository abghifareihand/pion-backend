<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


// ==============================
// Routes Public (belum login)
// ==============================
Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
});

// ==============================
// Routes Protected (sudah login)
// ==============================
Route::middleware('auth:sanctum')->group(function () {

    // ----- Auth Route -----
    Route::prefix('auth')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/profile', [AuthController::class, 'profile']);
        Route::post('/fcm-token', [AuthController::class, 'updateFcmToken']);
    });
});

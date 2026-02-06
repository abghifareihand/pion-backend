<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\InformationController;
use App\Http\Controllers\Api\FinancialController;
use App\Http\Controllers\Api\LearningController;
use App\Http\Controllers\Api\OrganizationController;
use App\Http\Controllers\Api\ResetPasswordController;
use App\Http\Controllers\Api\SocialController;
use App\Http\Controllers\Api\VisionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


// ==============================
// Routes Public (belum login)
// ==============================
Route::prefix('auth')->group(function () {
    // ✅ ROUTE UNTUK AUTHENTICATION
    Route::post('/login', [AuthController::class, 'login']);

    // ✅ ROUTE UNTUK FORGOT PASSWORD
    // STEP 1 — Request OTP
    Route::post('/request-otp', [ResetPasswordController::class, 'requestOtp'])->middleware('throttle:3,5');
    // STEP 2 — Verify OTP (generate reset_token)
    Route::post('/verify-otp', [ResetPasswordController::class, 'verifyOtp']);
    // STEP 3 — Reset password pakai reset_token
    Route::post('/reset-password', [ResetPasswordController::class, 'resetPassword']);
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

    // ----- Informations Route -----
    Route::prefix('informations')->group(function () {
        Route::get('/', [InformationController::class, 'index']);
        Route::get('/{information}', [InformationController::class, 'show']);
    });

    // ----- Financials Route -----
    Route::prefix('financials')->group(function () {
        Route::get('/', [FinancialController::class, 'index']);
        Route::get('/{financial}', [FinancialController::class, 'show']);
    });

    // ----- Learnings Route -----
    Route::prefix('learnings')->group(function () {
        Route::get('/', [LearningController::class, 'index']);
        Route::get('/{learning}', [LearningController::class, 'show']);
    });

    // ----- Organizations Route -----
    Route::prefix('organizations')->group(function () {
        Route::get('/', [OrganizationController::class, 'index']);
        Route::get('/{organization}', [OrganizationController::class, 'show']);
    });

    // ----- Socials Route -----
    Route::prefix('socials')->group(function () {
        Route::get('/', [SocialController::class, 'index']);
        Route::get('/{social}', [SocialController::class, 'show']);
    });

    // ----- Vision Route -----
    Route::get('/vision', [VisionController::class, 'show']);
});

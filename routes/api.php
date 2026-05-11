<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CheckInController;
use App\Http\Controllers\Api\EquipmentController;
use Illuminate\Support\Facades\Route;

// Public
Route::post('/auth/login', [AuthController::class, 'login']);

// Authenticated (any role)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::get('/auth/me',     [AuthController::class, 'me']);

    Route::get('/equipments',        [EquipmentController::class, 'index']);
    Route::get('/equipments/{equipment}', [EquipmentController::class, 'show']);

    // Member: submit check-in from tablet
    Route::post('/check-ins/borrow', [CheckInController::class, 'borrowCheckIn']);
    Route::post('/check-ins/return', [CheckInController::class, 'returnCheckIn']);

    // Admin: manage check-ins
    Route::middleware('admin')->group(function () {
        Route::get('/check-ins',                    [CheckInController::class, 'index']);
        Route::put('/check-ins/{checkIn}/approve',  [CheckInController::class, 'approve']);
        Route::put('/check-ins/{checkIn}/reject',   [CheckInController::class, 'reject']);
    });
});

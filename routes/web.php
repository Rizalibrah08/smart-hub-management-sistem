<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BorrowingScheduleController;
use App\Http\Controllers\EquipmentController;
use Illuminate\Support\Facades\Route;

// Auth routes (public)
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin dashboard routes (auth + admin role required)
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/', fn() => redirect()->route('dashboard'));
    Route::get('/dashboard', fn() => view('dashboard'))->name('dashboard');

    Route::resource('equipments', EquipmentController::class);

    Route::resource('borrowing-schedules', BorrowingScheduleController::class);
    Route::put('borrowing-schedules/{borrowingSchedule}/approve', [BorrowingScheduleController::class, 'approve'])
        ->name('borrowing-schedules.approve');
    Route::put('borrowing-schedules/{borrowingSchedule}/reject', [BorrowingScheduleController::class, 'reject'])
        ->name('borrowing-schedules.reject');
});

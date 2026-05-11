<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BorrowingScheduleController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\Member;
use Illuminate\Support\Facades\Route;

// ── Admin Auth ──────────────────────────────────────────────
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ── Admin Dashboard ─────────────────────────────────────────
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

// ── Member Auth ──────────────────────────────────────────────
Route::get('/member/login', [Member\AuthController::class, 'showLogin'])->name('member.login');
Route::post('/member/login', [Member\AuthController::class, 'login']);
Route::post('/member/logout', [Member\AuthController::class, 'logout'])->name('member.logout');

// ── Member Portal ────────────────────────────────────────────
Route::middleware(['auth', 'member'])->prefix('member')->name('member.')->group(function () {
    Route::get('/dashboard', [Member\DashboardController::class, 'index'])->name('dashboard');

    Route::get('/borrowings',           [Member\BorrowingController::class, 'index'])->name('borrowings.index');
    Route::get('/borrowings/create',    [Member\BorrowingController::class, 'create'])->name('borrowings.create');
    Route::post('/borrowings',          [Member\BorrowingController::class, 'store'])->name('borrowings.store');
    Route::get('/borrowings/{borrowing}',[Member\BorrowingController::class, 'show'])->name('borrowings.show');

    Route::get('/notifications',                        [Member\NotificationController::class, 'index'])->name('notifications.index');
    Route::put('/notifications/{notification}/read',    [Member\NotificationController::class, 'markAsRead'])->name('notifications.read');
});

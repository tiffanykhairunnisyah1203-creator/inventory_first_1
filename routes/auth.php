<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    // Rute Tampilan Form Login
    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    // Rute Proses Pengecekan Login
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
});

Route::middleware('auth')->group(function () {
    // Rute Keluar Aplikasi (Logout)
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});
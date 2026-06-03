<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('welcome');
});

// Guest Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Authenticated Routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/dashboard/booking/{id}/status', [DashboardController::class, 'updateBookingStatus'])->name('dashboard.booking.status');
    Route::post('/dashboard/testimoni', [DashboardController::class, 'addTestimoni'])->name('dashboard.testimoni');
});

// Placeholder booking route (as referenced in dashboard)
Route::get('/booking', function () {
    return "Halaman Form Booking (Belum diimplementasikan)";
})->name('booking');


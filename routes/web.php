<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Beranda publik — redirect ke dashboard jika sudah login
Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
})->name('beranda');

// Login & register bebas diakses (tanpa guest middleware agar bisa ganti akun saat dev)
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Hanya untuk yang sudah login
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard routes (untuk admin dan user)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/dashboard/booking/{id}/status', [DashboardController::class, 'updateBookingStatus'])->name('dashboard.booking.status');
    Route::post('/dashboard/testimoni', [DashboardController::class, 'saveTestimoni'])->name('dashboard.testimoni');
});

// Khusus admin (uji middleware role di sini)
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        return 'Halo Admin! Halaman ini hanya bisa diakses role admin.';
    })->name('admin.dashboard');
});

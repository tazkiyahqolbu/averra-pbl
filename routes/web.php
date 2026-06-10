<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;


// Redirect root ke login
Route::get('/', fn () => redirect()->route('login'));

// Autentikasi
Route::get('/login',     [AuthController::class, 'showLogin'])->name('login');
Route::post('/login',    [AuthController::class, 'login']);
Route::get('/register',  [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout',   [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// ── Rute User ─────────────────────────────────────────────────────────────────
Route::middleware('auth')->name('user.')->group(function () {
   Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

});


// ── Rute Admin ────────────────────────────────────────────────────────────────
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
});

// Route preview untuk halaman admin jasa, dihapus setelah backend jasa selesai
Route::prefix('admin')->name('admin.')->group(function () {
    Route::view('/jasa', 'admin.jasa.index')->name('jasa.index');
    Route::view('/jasa/create', 'admin.jasa.create')->name('jasa.create');
    Route::view('/jasa/edit', 'admin.jasa.edit')->name('jasa.edit');
});


// Route preview untuk halaman admin paket, dihapus setelah backend paket selesai
Route::prefix('admin')->name('admin.')->group(function () {
    Route::view('/paket', 'admin.paket.index')->name('paket.index');
    Route::view('/paket/create', 'admin.paket.create')->name('paket.create');
    Route::view('/paket/edit', 'admin.paket.edit')->name('paket.edit');
});

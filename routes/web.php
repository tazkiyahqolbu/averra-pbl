<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
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
    Route::get('/dashboard', fn () => view('user.dashboard.index'))->name('dashboard');
});

// ── Rute Admin ────────────────────────────────────────────────────────────────
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
});

// Route preview untuk halaman admin jasa, dihapus setelah backend jasa selesai
Route::get('/preview/admin/jasa', function () {
    return view('admin.jasa.index');
});

Route::view(
    '/preview/admin/jasa/create',
    'admin.jasa.create'
);

Route::view(
    '/preview/admin/jasa/edit',
    'admin.jasa.edit'
);

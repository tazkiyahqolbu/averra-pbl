<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// Autentikasi
Route::get('/login',     [AuthController::class, 'showLogin'])->name('login');
Route::post('/login',    [AuthController::class, 'login']);
Route::get('/register',  [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout',   [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// ── Rute User ─────────────────────────────────────────────────────────────────
// Route::middleware('auth')->name('user.')->group(function () {
//     Route::get('/dashboard', [UserController::class, 'index'])->name('dashboard');
// });

// ── Rute Admin ────────────────────────────────────────────────────────────────
// Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
//     Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
// });

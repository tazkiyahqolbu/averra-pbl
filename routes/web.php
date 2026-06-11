<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\JasaController;
use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// Untuk Preview Frontend
use App\Models\Barang;
use App\Models\KategoriBarang;

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

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [AdminDashboardController::class, 'index'])
            ->name('dashboard');

        Route::get('/jasa', [JasaController::class, 'index'])
            ->name('jasa.index');

        Route::get('/jasa/create', [JasaController::class, 'create'])
            ->name('jasa.create');

        Route::post('/jasa', [JasaController::class, 'store'])
            ->name('jasa.store');

        Route::get('/jasa/{id}/edit', [JasaController::class, 'edit'])
            ->name('jasa.edit');

        Route::put('/jasa/{id}', [JasaController::class, 'update'])
            ->name('jasa.update');

        Route::delete('/jasa/{id}', [JasaController::class, 'destroy'])
            ->name('jasa.destroy');
    });


// Untuk Preview Frontend (sementara pakai view statis)
Route::prefix('admin')->name('admin.')->group(function () {
    Route::view('/paket', 'admin.paket.index')->name('paket.index');
    Route::view('/paket/create', 'admin.paket.create')->name('paket.create');
    Route::view('/paket/edit', 'admin.paket.edit')->name('paket.edit');
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::view('/barang', 'admin.barang.index')->name('barang.index');
    Route::view('/barang/create', 'admin.barang.create')->name('barang.create');
    Route::view('/barang/edit', 'admin.barang.edit')->name('barang.edit');

    Route::view('/kategori', 'admin.kategori.index')->name('kategori.index');
});

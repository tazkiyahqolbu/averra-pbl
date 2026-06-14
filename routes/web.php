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

    // Paket
    Route::view('/paket', 'admin.paket.index')->name('paket.index');
    Route::view('/paket/create', 'admin.paket.create')->name('paket.create');
    Route::view('/paket/edit', 'admin.paket.edit')->name('paket.edit');

    // Barang
    Route::view('/barang', 'admin.barang.index')->name('barang.index');
    Route::view('/barang/create', 'admin.barang.create')->name('barang.create');
    Route::view('/barang/edit', 'admin.barang.edit')->name('barang.edit');

    // Kategori
    Route::view('/kategori-paket', 'admin.kategori-paket.index')->name('kategori-paket.index');
    Route::view('/kategori-barang', 'admin.kategori-barang.index')->name('kategori-barang.index');
    Route::view('/kategori-jasa', 'admin.kategori-jasa.index')->name('kategori-jasa.index');

    // Pemesanan
    Route::view('/pemesanan', 'admin.pemesanan.index')->name('pemesanan.index');
    Route::view('/pemesanan/show', 'admin.pemesanan.show')->name('pemesanan.show');

    // Pembayaran
    Route::view('/pembayaran', 'admin.pembayaran.index')->name('pembayaran.index');
    Route::view('/pembayaran/show', 'admin.pembayaran.show')->name('pembayaran.show');

    // Galeri
    Route::view('/galeri', 'admin.galeri.index')->name('galeri.index');
    Route::view('/galeri/create', 'admin.galeri.create')->name('galeri.create');
    Route::view('/galeri/edit', 'admin.galeri.edit')->name('galeri.edit');

// Testimoni
    Route::view('/testimoni', 'admin.testimoni.index')->name('testimoni.index');

// Zona Lokasi
    Route::view('/zona-lokasi', 'admin.zona-lokasi.index')->name('zona-lokasi.index');
    Route::view('/zona-lokasi/create', 'admin.zona-lokasi.create')->name('zona-lokasi.create');
    Route::view('/zona-lokasi/edit', 'admin.zona-lokasi.edit')->name('zona-lokasi.edit');

});

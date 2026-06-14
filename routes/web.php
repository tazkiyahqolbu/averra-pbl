<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\JasaController;
use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\Admin\PaketController;
use App\Http\Controllers\Admin\KategoriPaketController;
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

        Route::get('/paket', [PaketController::class, 'index'])
            ->name('paket.index');

        Route::get('/paket/create', [PaketController::class, 'create'])
            ->name('paket.create');

        Route::post('/paket', [PaketController::class, 'store'])
            ->name('paket.store');

        Route::get('/paket/{id}/edit', [PaketController::class, 'edit'])
            ->name('paket.edit');

        Route::put('/paket/{id}', [PaketController::class, 'update'])
            ->name('paket.update');

        Route::delete('/paket/{id}', [PaketController::class, 'destroy'])
            ->name('paket.destroy');

        Route::get('/paket/foto/{id}/hapus', [PaketController::class, 'destroyFoto']
            )->name('paket.foto.destroy');

        Route::get('/kategori-paket', [KategoriPaketController::class, 'index']
            )->name('kategori-paket.index');

            Route::post('/kategori-paket', [KategoriPaketController::class, 'store']
            )->name('kategori-paket.store');

            Route::put('/kategori-paket/{id}', [KategoriPaketController::class, 'update']
            )->name('kategori-paket.update');

            Route::delete('/kategori-paket/{id}', [KategoriPaketController::class, 'destroy']
            )->name('kategori-paket.destroy');
    });

Route::prefix('admin')->name('admin.')->group(function () {

    Route::view('/barang', 'admin.barang.index')->name('barang.index');
    Route::view('/barang/create', 'admin.barang.create')->name('barang.create');
    Route::view('/barang/edit', 'admin.barang.edit')->name('barang.edit');

    // Kategori
    Route::view('/kategori-barang', 'admin.kategori-barang.index')->name('kategori-barang.index');

    // Pemesanan
    Route::view('/pemesanan', 'admin.pemesanan.index')->name('pemesanan.index');
    Route::view('/pemesanan/show', 'admin.pemesanan.show')->name('pemesanan.show');

    // Pembayaran
    Route::view('/pembayaran', 'admin.pembayaran.index')->name('pembayaran.index');
    Route::view('/pembayaran/show', 'admin.pembayaran.show')->name('pembayaran.show');
});

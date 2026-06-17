<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\JasaController;
use App\Http\Controllers\Admin\PaketController;
use App\Http\Controllers\Admin\KategoriPaketController;
use App\Http\Controllers\Admin\PemesananController as AdminPemesananController;
use App\Http\Controllers\Admin\PembayaranController as AdminPembayaranController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\User\PemesananController;
use App\Http\Controllers\User\PembayaranController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn() => redirect()->route('login'));

// Halaman publik
Route::get('/katalog', fn() => redirect()->route('user.pemesanan.index'))->name('public.katalog.index');

// Testimoni
Route::middleware('auth')->post('/testimoni/{pemesanan_id}', function ($pemesanan_id) {
    return redirect()->back()->with('info', 'Fitur testimoni segera hadir.');
})->name('testimoni.store');

// Autentikasi
Route::get('/login',     [AuthController::class, 'showLogin'])->name('login');
Route::post('/login',    [AuthController::class, 'login']);
Route::get('/register',  [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout',   [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// ── Rute User ─────────────────────────────────────────────────────────────────
Route::middleware('auth')->name('user.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    // Pemesanan
    Route::get('/pemesanan', [PemesananController::class, 'index'])->name('pemesanan.index');
    Route::get('/pemesanan/buat/acara', [PemesananController::class, 'createAcara'])->name('pemesanan.create.acara');
    Route::get('/pemesanan/buat/sewa',  [PemesananController::class, 'createSewa'])->name('pemesanan.create.sewa');
    Route::post('/pemesanan', [PemesananController::class, 'store'])->name('pemesanan.store');
    Route::get('/pemesanan/{id}', [PemesananController::class, 'show'])->name('pemesanan.show');
    Route::put('/pemesanan/{id}', [PemesananController::class, 'update'])->name('pemesanan.update');
    Route::get('/pemesanan/{id}/invoice', [PemesananController::class, 'invoice'])->name('pemesanan.invoice');

    // Pembayaran
    Route::post('/pembayaran/upload', [PembayaranController::class, 'upload'])->name('pembayaran.upload');

    // Profile
    Route::get('/profil', fn() => view('user.profile.index'))->name('profile.index');
});

// ── Rute Admin ────────────────────────────────────────────────────────────────
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        // Jasa
        Route::get('/jasa',             [JasaController::class, 'index'])->name('jasa.index');
        Route::get('/jasa/create',      [JasaController::class, 'create'])->name('jasa.create');
        Route::post('/jasa',            [JasaController::class, 'store'])->name('jasa.store');
        Route::get('/jasa/{id}/edit',   [JasaController::class, 'edit'])->name('jasa.edit');
        Route::put('/jasa/{id}',        [JasaController::class, 'update'])->name('jasa.update');
        Route::delete('/jasa/{id}',     [JasaController::class, 'destroy'])->name('jasa.destroy');

        // Paket
        Route::get('/paket',              [PaketController::class, 'index'])->name('paket.index');
        Route::get('/paket/create',       [PaketController::class, 'create'])->name('paket.create');
        Route::post('/paket',             [PaketController::class, 'store'])->name('paket.store');
        Route::get('/paket/{id}/edit',    [PaketController::class, 'edit'])->name('paket.edit');
        Route::put('/paket/{id}',         [PaketController::class, 'update'])->name('paket.update');
        Route::delete('/paket/{id}',      [PaketController::class, 'destroy'])->name('paket.destroy');
        Route::get('/paket/foto/{id}/hapus', [PaketController::class, 'destroyFoto'])->name('paket.foto.destroy');

        // Kategori Paket
        Route::get('/kategori-paket',      [KategoriPaketController::class, 'index'])->name('kategori-paket.index');
        Route::post('/kategori-paket',     [KategoriPaketController::class, 'store'])->name('kategori-paket.store');
        Route::put('/kategori-paket/{id}', [KategoriPaketController::class, 'update'])->name('kategori-paket.update');
        Route::delete('/kategori-paket/{id}', [KategoriPaketController::class, 'destroy'])->name('kategori-paket.destroy');

        // Pemesanan
        Route::get('/pemesanan',                       [AdminPemesananController::class, 'index'])->name('pemesanan.index');
        Route::get('/pemesanan/{id}',                  [AdminPemesananController::class, 'show'])->name('pemesanan.show');
        Route::patch('/pemesanan/{id}/konfirmasi',     [AdminPemesananController::class, 'konfirmasi'])->name('pemesanan.konfirmasi');
        Route::patch('/pemesanan/{id}/tolak',          [AdminPemesananController::class, 'tolak'])->name('pemesanan.tolak');

        // Pembayaran
        Route::get('/pembayaran',                          [AdminPembayaranController::class, 'index'])->name('pembayaran.index');
        Route::get('/pembayaran/{id}',                     [AdminPembayaranController::class, 'show'])->name('pembayaran.show');
        Route::patch('/pembayaran/{id}/verifikasi',        [AdminPembayaranController::class, 'verifikasi'])->name('pembayaran.verifikasi');
        Route::patch('/pembayaran/{id}/tolak',             [AdminPembayaranController::class, 'tolak'])->name('pembayaran.tolak');
    });

// Admin view-only routes (preview frontend)
Route::prefix('admin')->name('admin.')->group(function () {
    Route::view('/barang',        'admin.barang.index')->name('barang.index');
    Route::view('/barang/create', 'admin.barang.create')->name('barang.create');
    Route::view('/barang/edit',   'admin.barang.edit')->name('barang.edit');
    Route::view('/kategori-barang', 'admin.kategori-barang.index')->name('kategori-barang.index');
    Route::view('/kategori-jasa',   'admin.kategori-jasa.index')->name('kategori-jasa.index');
    Route::view('/pengembalian',    'admin.pengembalian.index')->name('pengembalian.index');
    Route::view('/pengembalian/show', 'admin.pengembalian.show')->name('pengembalian.show');
    Route::view('/laporan',         'admin.laporan.index')->name('laporan.index');
    Route::view('/galeri',          'admin.galeri.index')->name('galeri.index');
    Route::view('/galeri/create',   'admin.galeri.create')->name('galeri.create');
    Route::view('/testimoni',       'admin.testimoni.index')->name('testimoni.index');
    Route::view('/zona-lokasi',     'admin.zona-lokasi.index')->name('zona-lokasi.index');
    Route::view('/blokir-tanggal',  'admin.blokir-tanggal.index')->name('blokir-tanggal.index');
    Route::view('/akun',            'admin.akun.index')->name('akun.index');
});

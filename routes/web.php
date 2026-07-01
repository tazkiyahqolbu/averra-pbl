<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\JasaController;
use App\Http\Controllers\Admin\PaketController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\BarangController;
use App\Http\Controllers\Admin\GaleriController;
use App\Http\Controllers\Admin\ZonaLokasiController;
use App\Http\Controllers\Admin\BlokirTanggalController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\PengembalianBarangController;
use App\Http\Controllers\Admin\PemesananController as AdminPemesananController;
use App\Http\Controllers\Admin\PembayaranController as AdminPembayaranController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;
use App\Http\Controllers\Admin\TestimoniController as AdminTestimoniController;
use App\Http\Controllers\User\TestimoniController as UserTestimoniController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Frontend\KatalogController;
use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\User\PemesananController;
use App\Http\Controllers\User\PembayaranController;
use App\Http\Controllers\User\PembatalanController;
use App\Http\Controllers\Admin\PembatalanController as AdminPembatalanController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\ForgotPasswordController;

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $pakets = \App\Models\Paket::where('aktif', true)
        ->withCount('detailPemesanans')
        ->orderByDesc('detail_pemesanans_count')
        ->orderByDesc('created_at')
        ->take(3)
        ->get();

    $galeriUnggulan = \App\Models\Galeri::where('unggulan', true)
        ->latest()
        ->take(8)
        ->get();

    return view('public.Beranda', compact('pakets', 'galeriUnggulan'));
})->name('public.beranda');



// Midtrans webhook - tanpa auth middleware
Route::post('/pembayaran/callback', [App\Http\Controllers\User\PembayaranController::class, 'callback'])->name('pembayaran.callback');

// Halaman publik
Route::get('/katalog',       [KatalogController::class, 'index'])->name('public.katalog.index');
Route::get('/katalog/{slug}', [KatalogController::class, 'show'])->name('katalog.show');
Route::get('/galeri-kami', function () {
    $galeris = \App\Models\Galeri::latest()->get();
    return view('public.galeri.index', compact('galeris'));
})->name('public.galeri.index');
Route::view('/tentang', 'public.tentang.index')->name('public.tentang.index');

// Testimoni
Route::middleware('auth')->group(function () {
    Route::get('/testimoni/{pemesanan_id}/create', [UserTestimoniController::class, 'create'])->name('testimoni.create');
    Route::post('/testimoni/{pemesanan_id}', [UserTestimoniController::class, 'store'])->name('testimoni.store');
});


// Autentikasi
Route::get('/login',     [AuthController::class, 'showLogin'])->name('login');
Route::post('/login',    [AuthController::class, 'login'])->middleware('throttle:5,1');
Route::get('/register',        [AuthController::class, 'showRegister'])->name('register');
Route::post('/register',       [AuthController::class, 'register']);
Route::get('/register/sukses', [AuthController::class, 'showRegisterSuccess'])->name('register.success');
Route::post('/logout',   [AuthController::class, 'logout'])->name('logout')->middleware('auth');
// Forgot Password
Route::get('/lupa-password', [ForgotPasswordController::class, 'showForgotPassword'])->name('password.request');
Route::post('/lupa-password', [ForgotPasswordController::class, 'sendOtp'])->name('password.send-otp')->middleware('throttle:5,1');
Route::get('/verifikasi-otp', [ForgotPasswordController::class, 'showVerifyOtp'])->name('password.verify-otp');
Route::post('/verifikasi-otp', [ForgotPasswordController::class, 'verifyOtp'])->name('password.check-otp')->middleware('throttle:5,1');
Route::get('/reset-password', [ForgotPasswordController::class, 'showResetPassword'])->name('password.reset-form');
Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword'])->name('password.update');

// ── Rute User ─────────────────────────────────────────────────────────────────
Route::middleware(['auth', 'redirect_if_admin'])->name('user.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    // Pemesanan
    Route::get('/pemesanan', [PemesananController::class, 'index'])->name('pemesanan.index');
    Route::get('/pemesanan/buat/acara', [PemesananController::class, 'createAcara'])->name('pemesanan.create.acara');
    Route::get('/pemesanan/buat/sewa',  [PemesananController::class, 'createSewa'])->name('pemesanan.create.sewa');
    Route::post('/pemesanan', [PemesananController::class, 'store'])->name('pemesanan.store');
    Route::get('/pemesanan/{id}/submitted', [PemesananController::class, 'submitted'])->name('pemesanan.submitted');
    Route::get('/pemesanan/{id}', [PemesananController::class, 'show'])->name('pemesanan.show');
    Route::put('/pemesanan/{id}', [PemesananController::class, 'update'])->name('pemesanan.update');
    Route::get('/pemesanan/{id}/invoice', [PemesananController::class, 'invoice'])->name('pemesanan.invoice');
    Route::get('/pemesanan/{id}/invoice/pdf', [PemesananController::class, 'cetakInvoice'])->name('pemesanan.invoice.pdf');

    // Pembayaran
    Route::get('/pembayaran/{id}/pilih',     [PembayaranController::class, 'pilih'])->name('pembayaran.pilih');
    Route::post('/pembayaran/{id}/initiate', [PembayaranController::class, 'initiate'])->name('pembayaran.initiate');
    Route::get('/pembayaran/finish',         [PembayaranController::class, 'finish'])->name('pembayaran.finish');

    // Pembatalan
    Route::post('/pemesanan/{id}/pembatalan', [PembatalanController::class, 'ajukan'])->name('pembatalan.ajukan');

    // Profile
    Route::get('/profil', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profil', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profil/foto', [ProfileController::class, 'updatePhoto'])->name('profile.photo.update');

    Route::get('/unavailable-dates', [PemesananController::class, 'unavailableDates'])
        ->name('unavailable-dates');
});

// ── Rute Admin ────────────────────────────────────────────────────────────────
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        // Pelanggan
        Route::get('/pelanggan', [\App\Http\Controllers\Admin\PelangganController::class, 'index'])->name('pelanggan.index');


        // Jasa
        Route::get('/jasa',             [JasaController::class, 'index'])->name('jasa.index');
        Route::get('/jasa/create',      [JasaController::class, 'create'])->name('jasa.create');
        Route::post('/jasa',            [JasaController::class, 'store'])->name('jasa.store');
        Route::get('/jasa/{id}',        [JasaController::class, 'show'])->name('jasa.show');
        Route::get('/jasa/{id}/edit',   [JasaController::class, 'edit'])->name('jasa.edit');
        Route::put('/jasa/{id}',        [JasaController::class, 'update'])->name('jasa.update');
        Route::delete('/jasa/{id}',     [JasaController::class, 'destroy'])->name('jasa.destroy');

        // Paket
        Route::get('/paket',              [PaketController::class, 'index'])->name('paket.index');
        Route::get('/paket/create',       [PaketController::class, 'create'])->name('paket.create');
        Route::post('/paket',             [PaketController::class, 'store'])->name('paket.store');
        Route::get('/paket/{id}',         [PaketController::class, 'show'])->name('paket.show');
        Route::get('/paket/{id}/edit',    [PaketController::class, 'edit'])->name('paket.edit');
        Route::put('/paket/{id}',         [PaketController::class, 'update'])->name('paket.update');
        Route::delete('/paket/{id}',      [PaketController::class, 'destroy'])->name('paket.destroy');
        Route::get('/paket/foto/{id}/hapus', [PaketController::class, 'destroyFoto'])->name('paket.foto.destroy');

        // Pemesanan
        Route::get('/pemesanan',                       [AdminPemesananController::class, 'index'])->name('pemesanan.index');
        Route::get('/pemesanan/{id}',                  [AdminPemesananController::class, 'show'])->name('pemesanan.show');
        Route::patch('/pemesanan/{id}/konfirmasi',     [AdminPemesananController::class, 'konfirmasi'])->name('pemesanan.konfirmasi');
        Route::patch('/pemesanan/{id}/tolak',          [AdminPemesananController::class, 'tolak'])->name('pemesanan.tolak');
        Route::patch('/pemesanan/{id}/diambil',        [AdminPemesananController::class, 'tandaiDiambil'])->name('pemesanan.diambil');
        Route::post('/pemesanan/{id}/dikembalikan',    [AdminPemesananController::class, 'tandaiDikembalikan'])->name('pemesanan.dikembalikan');
        Route::patch('/pemesanan/{id}/acara-selesai',  [AdminPemesananController::class, 'tandaiAcaraSelesai'])->name('pemesanan.acara-selesai');
        Route::patch('/pemesanan/{id}/update-status',  [AdminPemesananController::class, 'updateStatus'])->name('pemesanan.update-status');

        // Pembatalan
        Route::get('/pembatalan',                          [AdminPembatalanController::class, 'index'])->name('pembatalan.index');
        Route::get('/pembatalan/{id}',                     [AdminPembatalanController::class, 'show'])->name('pembatalan.show');
        Route::patch('/pembatalan/{id}/setujui',           [AdminPembatalanController::class, 'setujui'])->name('pembatalan.setujui');
        Route::patch('/pembatalan/{id}/tolak',             [AdminPembatalanController::class, 'tolak'])->name('pembatalan.tolak');

        // Pembayaran
        Route::get('/pembayaran',                          [AdminPembayaranController::class, 'index'])->name('pembayaran.index');
        Route::get('/pembayaran/{id}',                     [AdminPembayaranController::class, 'show'])->name('pembayaran.show');
        Route::patch('/pembayaran/{id}/verifikasi',        [AdminPembayaranController::class, 'verifikasi'])->name('pembayaran.verifikasi');
        Route::patch('/pembayaran/{id}/tolak',             [AdminPembayaranController::class, 'tolak'])->name('pembayaran.tolak');

        // Barang
        Route::get('/barang', [BarangController::class, 'index'])
            ->name('barang.index');

        Route::get('/barang/create', [BarangController::class, 'create'])
            ->name('barang.create');

        Route::post('/barang', [BarangController::class, 'store'])
            ->name('barang.store');

        Route::get('/barang/{id}', [BarangController::class, 'show'])
            ->name('barang.show');

        Route::get('/barang/{id}/edit', [BarangController::class, 'edit'])
            ->name('barang.edit');

        Route::put('/barang/{id}', [BarangController::class, 'update'])
            ->name('barang.update');

        Route::delete('/barang/{id}', [BarangController::class, 'destroy'])
            ->name('barang.destroy');

        Route::prefix('kategori/{tipe}')->name('kategori.')->group(function () {
    Route::get('/', [KategoriController::class, 'index'])->name('index');
    Route::get('/create', [KategoriController::class, 'create'])->name('create');
    Route::post('/', [KategoriController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [KategoriController::class, 'edit'])->name('edit');
    Route::put('/{id}', [KategoriController::class, 'update'])->name('update');
    Route::delete('/{id}', [KategoriController::class, 'destroy'])->name('destroy');
});

        Route::prefix('pengembalian')->name('pengembalian.')->group(function () {

            Route::get('/', [PengembalianBarangController::class, 'index'])
                ->name('index');

            Route::get('/{id}', [PengembalianBarangController::class, 'show'])
                ->name('show');

            Route::put('/{id}', [PengembalianBarangController::class, 'update'])
                ->name('update');

        });

        Route::prefix('galeri')
            ->name('galeri.')
            ->group(function () {
                Route::get('/', [GaleriController::class, 'index'])->name('index');
                Route::get('/create', [GaleriController::class, 'create'])->name('create');
                Route::post('/', [GaleriController::class, 'store'])->name('store');
                Route::get('/{id}/edit', [GaleriController::class, 'edit'])->name('edit');
                Route::put('/{id}', [GaleriController::class, 'update'])->name('update');
                Route::delete('/{id}', [GaleriController::class, 'destroy'])->name('destroy');
            });

        Route::prefix('zona-lokasi')
            ->name('zona-lokasi.')
            ->group(function () {

                Route::get('/', [ZonaLokasiController::class, 'index'])->name('index');
                Route::get('/create', [ZonaLokasiController::class, 'create'])->name('create');
                Route::post('/', [ZonaLokasiController::class, 'store'])->name('store');
                Route::get('/{id}/edit', [ZonaLokasiController::class, 'edit'])->name('edit');
                Route::put('/{id}', [ZonaLokasiController::class, 'update'])->name('update');
                Route::delete('/{id}', [ZonaLokasiController::class, 'destroy'])->name('destroy');
            });

        Route::get('/blokir-tanggal', [BlokirTanggalController::class, 'index'])
            ->name('blokir-tanggal.index');

        Route::post('/blokir-tanggal', [BlokirTanggalController::class, 'store'])
            ->name('blokir-tanggal.store');

        Route::get('/testimoni', [AdminTestimoniController::class, 'index'])
            ->name('testimoni.index');

        Route::patch('/testimoni/{id}/balas', [AdminTestimoniController::class, 'balas'])
            ->name('testimoni.balas');

        Route::delete('/blokir-tanggal/{id}', [BlokirTanggalController::class, 'destroy'])
            ->name('blokir-tanggal.destroy');

        Route::get('/laporan', [LaporanController::class, 'index'])
    ->name('laporan.index');
        Route::get('/laporan/export-excel', [LaporanController::class, 'exportExcel'])->name('laporan.export');
    });



// Admin akun (profil)
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/akun',              [AdminProfileController::class, 'index'])->name('akun.index');
    Route::put('/akun', [AdminProfileController::class, 'update'])->name('akun.update');
    Route::put('/akun/password',     [AdminProfileController::class, 'updatePassword'])->name('akun.password');
});


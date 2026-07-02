# Refactoring Documentation
## Sistem Informasi Sanggar Rantiang Tagok

Dokumen ini mencatat refactoring signifikan yang sudah dilakukan selama pengembangan.

---

## 1. Restrukturisasi Penamaan Modul (booking → pemesanan)

**Sebelum — Masalah:**
Modul awal memakai istilah booking/payment, tidak konsisten dengan bahasa yang dipakai di UI dan permintaan dosen/klien (bahasa Indonesia).

**Perubahan:**
Rename booking → pemesanan, payment → pembayaran di seluruh model, tabel, controller, dan route. Standarisasi penamaan field `_path` untuk semua kolom file upload.

**Alasan:** Konsistensi penamaan antara kode dan domain bisnis, memudahkan onboarding anggota tim baru.

**Dampak:** Struktur folder dan nama class lebih mudah dipahami; risiko: butuh migration ulang untuk rename kolom FK.

---

## 2. Ekstraksi Validasi ke Form Request

**Sebelum — Masalah:**
Validasi data pemesanan dilakukan inline di controller (`$request->validate([...])`), controller menjadi panjang dan validasi sulit dipakai ulang.

**Perubahan:**
Buat `StoreBookingRequest` (Form Request class) dengan validasi lengkap semua field pemesanan.

**Alasan:** Memisahkan tanggung jawab validasi dari logic controller (Single Responsibility).

**Dampak:** Controller lebih ringkas, validasi lebih mudah ditest terpisah.

---

## 3. Kalkulasi Harga Dipindah ke Server

**Sebelum — Masalah:**
Total harga pemesanan sebagian dihitung dari input yang dikirim client — berisiko dimanipulasi.

**Perubahan:**
Seluruh kalkulasi total harga dipindahkan ke server (backend), client hanya kirim data mentah (id barang/jasa, jumlah, tanggal).

**Alasan:** Keamanan — mencegah user memanipulasi harga lewat request langsung ke endpoint.

**Dampak:** Sedikit menambah kompleksitas controller, tapi menutup celah keamanan harga.

---

## 4. Proses Simpan Pemesanan Dibungkus DB::transaction

**Sebelum — Masalah:**
Proses `store()` pemesanan menulis ke beberapa tabel (pemesanan, detail_pemesanan, update stok barang) tanpa transaction — jika salah satu gagal, data bisa jadi tidak konsisten.

**Perubahan:**
Seluruh proses store dibungkus `DB::transaction()`.

**Alasan:** Menjaga konsistensi data (atomicity) saat insert ke banyak tabel sekaligus.

**Dampak:** Jika terjadi error di tengah proses, seluruh perubahan otomatis di-rollback.

---

## 5. Alur Verifikasi Pembayaran: Manual → Midtrans

**Sebelum — Masalah:**
Verifikasi pembayaran dilakukan manual oleh admin (cek bukti transfer yang diupload user), rawan human error dan lambat.

**Perubahan:**
Hapus alur verifikasi manual, integrasikan Midtrans Snap sebagai payment gateway. Tampilan admin/pembayaran disesuaikan untuk menampilkan status dari Midtrans.

**Alasan:** Otomatisasi verifikasi pembayaran, mengurangi beban kerja admin dan keterlambatan konfirmasi.

**Dampak:** Modul pembayaran jadi bergantung pada layanan eksternal (lihat `docs/dependency.md` — risiko Midtrans).

---

## 6. Mail::send → Mail::queue (ADR-001)

**Sebelum — Masalah:**
Pengiriman email (reminder, invoice, notifikasi pembatalan) dilakukan secara sinkron (`Mail::send`), membuat request HTTP menunggu proses kirim email selesai.

**Perubahan:**
Semua pengiriman email diganti ke `Mail::queue` agar diproses di background lewat queue worker.

**Alasan:** Response time lebih cepat untuk user, sesuai keputusan arsitektur ADR-001.

**Dampak:** Perlu queue worker berjalan (`php artisan queue:listen`) di lingkungan production/development agar email benar-benar terkirim.

---

## 7. Pembersihan Kode Tidak Terpakai

**Perubahan:**
- Hapus layout dan dashboard lama yang sudah digantikan versi baru
- Hapus field `ikon_path` dari tabel `kategori_jasa` dan `kategori_paket` karena tidak pernah dipakai di frontend maupun admin

**Alasan:** Menjaga schema dan codebase tetap bersih, mengurangi kebingungan saat maintenance.

**Dampak:** Struktur kode lebih ringkas; butuh migration untuk drop kolom yang tidak dipakai.

---

## 8. Simplifikasi Alur Pengembalian Barang

**Sebelum — Masalah:**
Aksi "Barang Sudah Dikembalikan" tersebar di beberapa tempat; ada mismatch nama status enum yang membuat badge status salah tampil.

**Perubahan:**
Sederhanakan jadi satu klik, pemeriksaan kondisi & denda dipindah sepenuhnya ke halaman Pengembalian yang sudah ada; perbaiki mismatch nama status enum.

**Alasan:** Mengurangi duplikasi logic dan titik kegagalan (bug) yang sama muncul di banyak tempat.

**Dampak:** Alur pengembalian barang jadi satu sumber kebenaran (single source of truth).

---

## 9. Konsolidasi KategoriController

**Sebelum — Masalah:**
Ada 3 controller terpisah yang isinya nyaris identik: `KategoriBarangController`, `KategoriJasaController`, `KategoriPaketController` (total ±220 baris), masing-masing dengan method index/create/store/edit/update/destroy yang sama persis, hanya beda model Eloquent yang dipanggil. Begitu juga rute admin punya 3 blok rute duplikat (`/admin/kategori-barang`, `/admin/kategori-jasa`, `/admin/kategori-paket`).

**Perubahan:**
Gabungkan ketiganya jadi satu `KategoriController` generik (66 baris) yang menerima parameter `{tipe}` (`barang` | `jasa` | `paket`), lalu resolve ke model yang sesuai lewat mapping constant:

```php
private const MODELS = [
    'barang' => KategoriBarang::class,
    'jasa'   => KategoriJasa::class,
    'paket'  => KategoriPaket::class,
];
```

Rute admin juga disederhanakan dari 3 blok terpisah menjadi satu grup dengan prefix dinamis:

```php
Route::prefix('kategori/{tipe}')->name('kategori.')->group(function () {
    Route::get('/', [KategoriController::class, 'index'])->name('index');
    Route::get('/create', [KategoriController::class, 'create'])->name('create');
    Route::post('/', [KategoriController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [KategoriController::class, 'edit'])->name('edit');
    Route::put('/{id}', [KategoriController::class, 'update'])->name('update');
    Route::delete('/{id}', [KategoriController::class, 'destroy'])->name('destroy');
});
```

**Alasan:** Menghilangkan duplikasi kode (DRY) — perbaikan bug atau penambahan validasi di satu tempat otomatis berlaku untuk kategori barang, jasa, dan paket sekaligus, tidak perlu diubah 3x.

**Dampak:**
- Kode berkurang drastis: ±220 baris controller lama → 66 baris (turun ±70%), plus rute admin dari 18 baris jadi 6 baris.
- Nama route berubah dari `admin.kategori-barang.index`, `admin.kategori-jasa.index`, dll menjadi `admin.kategori.index` dengan parameter `{tipe}` — semua pemanggilan route lama (di view Blade maupun controller lain) perlu diperbarui.
- Risiko: karena satu controller menangani 3 tipe data, kesalahan pada `resolveModel()` bisa berdampak ke ketiga kategori sekaligus (perlu extra hati-hati saat testing).

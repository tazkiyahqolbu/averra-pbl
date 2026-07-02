# Dokumentasi Fitur — Sistem Informasi Sanggar Rantiang Tagok (SILART)

Dokumen ini merangkum seluruh fitur sistem beserta aktor, tujuan, alur, dan
route/controller terkait. Status menunjukkan progres pengembangan tiap fitur.

> Catatan revisi: dokumen ini diperbarui untuk menyesuaikan dengan kode terbaru
> di branch pengembangan (bukan skeleton `main`). Alur pembayaran manual
> "Upload Bukti Pembayaran" sudah digantikan integrasi Midtrans (lihat
> `docs/refactoring.md` poin #5), dan banyak fitur admin baru (Barang, Galeri,
> Kategori, Zona Lokasi, Blokir Tanggal, Pengembalian Barang, Pembatalan,
> Pelanggan) sudah lengkap namun belum tercatat di versi sebelumnya.

## Daftar Fitur

### Publik & Autentikasi

| No | Fitur | Aktor | Status |
|----|-------|-------|--------|
| 1  | [Login](#1-login)                                           | User & Admin | ✅ Selesai |
| 2  | [Register](#2-register)                                     | User         | ✅ Selesai |
| 3  | [Logout](#3-logout)                                         | User & Admin | ✅ Selesai |
| 4  | [Lupa Password (Reset via OTP)](#4-lupa-password-reset-via-otp) | User      | ✅ Selesai |
| 5  | [Katalog Publik](#5-katalog-publik)                         | Publik       | ✅ Selesai |
| 6  | [Galeri Publik](#6-galeri-publik)                           | Publik       | ✅ Selesai |
| 7  | [Halaman Tentang](#7-halaman-tentang)                       | Publik       | ✅ Selesai |

### Sisi User (Pelanggan)

| No | Fitur | Aktor | Status |
|----|-------|-------|--------|
| 8  | [Dashboard User](#8-dashboard-user)                         | User | ✅ Selesai |
| 9  | [Buat Pemesanan (Acara & Sewa Barang)](#9-buat-pemesanan-acara--sewa-barang) | User | ✅ Selesai |
| 10 | [Riwayat Pemesanan User](#10-riwayat-pemesanan-user)        | User | ✅ Selesai |
| 11 | [Pembayaran via Midtrans (DP & Pelunasan)](#11-pembayaran-via-midtrans-dp--pelunasan) | User | ✅ Selesai |
| 12 | [Ajukan Pembatalan Pemesanan](#12-ajukan-pembatalan-pemesanan) | User | ✅ Selesai |
| 13 | [Beri Testimoni](#13-beri-testimoni)                        | User | ✅ Selesai |
| 14 | [Profil User](#14-profil-user)                              | User | ✅ Selesai |

### Sisi Admin

| No | Fitur | Aktor | Status |
|----|-------|-------|--------|
| 15 | [Dashboard Admin](#15-dashboard-admin)                       | Admin | ✅ Selesai |
| 16 | [Kelola Pemesanan (Admin)](#16-kelola-pemesanan-admin)       | Admin | ✅ Selesai |
| 17 | [Verifikasi Pembayaran (Admin)](#17-verifikasi-pembayaran-admin) | Admin | ✅ Selesai |
| 18 | [Kelola Pembatalan (Admin)](#18-kelola-pembatalan-admin)     | Admin | ✅ Selesai |
| 19 | [Kelola Pengembalian Barang (Admin)](#19-kelola-pengembalian-barang-admin) | Admin | ✅ Selesai |
| 20 | [Kelola Jasa (Admin)](#20-kelola-jasa-admin)                 | Admin | ✅ Selesai |
| 21 | [Kelola Paket (Admin)](#21-kelola-paket-admin)               | Admin | ✅ Selesai |
| 22 | [Kelola Barang (Admin)](#22-kelola-barang-admin)             | Admin | ✅ Selesai |
| 23 | [Kelola Kategori (Admin)](#23-kelola-kategori-admin)         | Admin | ✅ Selesai |
| 24 | [Kelola Galeri (Admin)](#24-kelola-galeri-admin)             | Admin | ✅ Selesai |
| 25 | [Kelola Zona Lokasi (Admin)](#25-kelola-zona-lokasi-admin)   | Admin | ✅ Selesai |
| 26 | [Blokir Tanggal (Admin)](#26-blokir-tanggal-admin)           | Admin | ✅ Selesai |
| 27 | [Kelola Pelanggan (Admin)](#27-kelola-pelanggan-admin)       | Admin | ✅ Selesai |
| 28 | [Kelola Testimoni (Admin)](#28-kelola-testimoni-admin)       | Admin | ✅ Selesai |
| 29 | [Laporan (Admin)](#29-laporan-admin)                         | Admin | ✅ Selesai |
| 30 | [Profil Admin (Akun)](#30-profil-admin-akun)                 | Admin | ✅ Selesai |
| 31 | [Notifikasi Email Pemesanan](#31-notifikasi-email-pemesanan) | Sistem | 🔄 Perlu verifikasi |

---

## 1. Login

**Status:** ✅ Selesai
**Aktor:** User (Pelanggan) & Admin
**Tujuan:** Mengautentikasi pengguna agar dapat mengakses sistem sesuai role-nya.

**Alur:**

```
Buka /login → isi email & password → sistem validasi
 ├─ Jika admin  → redirect ke /admin/dashboard
 ├─ Jika user   → redirect ke /dashboard
 └─ Jika gagal  → kembali ke form dengan pesan error
```

**Route / Controller:**

| Method | Route   | Controller             |
|--------|---------|------------------------|
| GET    | /login  | `AuthController@showLogin` |
| POST   | /login  | `AuthController@login`     |

**Screenshot:**

<img width="1600" height="731" alt="WhatsApp Image 2026-07-02 at 11 10 07 AM" src="https://github.com/user-attachments/assets/2539ed14-7e68-405c-83ca-48b63558c118" />

---

## 2. Register

**Status:** ✅ Selesai
**Aktor:** User (Calon Pelanggan)
**Tujuan:** Mendaftarkan akun pelanggan baru ke sistem.

**Alur:**

```
Buka /register → isi nama, email, no HP, password
 → sistem simpan ke database → otomatis login
 → redirect ke /dashboard
```

**Route / Controller:**

| Method | Route      | Controller                  |
|--------|------------|-----------------------------|
| GET    | /register  | `AuthController@showRegister` |
| POST   | /register  | `AuthController@register`     |

**Screenshot:**

<img width="1600" height="714" alt="WhatsApp Image 2026-07-02 at 11 10 47 AM" src="https://github.com/user-attachments/assets/49b12268-3db6-483d-a7e5-6f60b49a682a" />

---

## 3. Logout

**Status:** ✅ Selesai
**Aktor:** User & Admin
**Tujuan:** Mengakhiri sesi login pengguna dan kembali ke halaman login.

**Alur:**

```
Klik tombol Logout → sistem hapus sesi → redirect ke /login
```

**Route / Controller:**

| Method | Route   | Controller            |
|--------|---------|------------------------|
| POST   | /logout | `AuthController@logout` |

**Screenshot:**
<img width="951" height="647" alt="WhatsApp Image 2026-07-02 at 11 13 20 AM" src="https://github.com/user-attachments/assets/a3ddad78-fc5b-4696-ae23-2fa357e30965" />


---

## 4. Lupa Password (Reset via OTP)

**Status:** ✅ Selesai
**Aktor:** User (Pelanggan)
**Tujuan:** Memulihkan akses akun bagi pelanggan yang lupa password, tanpa keterlibatan admin.

**Alur:**

```
Buka /lupa-password → isi email
 → sistem cek email terdaftar → generate OTP 6 digit (berlaku 10 menit)
 → kirim OTP via email → redirect ke /verifikasi-otp
User isi OTP + email → sistem validasi kode & masa berlaku
 → jika valid → redirect ke /reset-password
User isi password baru (min. 8 karakter, beda dari password lama)
 → sistem update password, hapus OTP, redirect ke /login
```

**Route / Controller:**

| Method | Route            | Controller                              |
|--------|------------------|------------------------------------------|
| GET    | /lupa-password    | `ForgotPasswordController@showForgotPassword` |
| POST   | /lupa-password    | `ForgotPasswordController@sendOtp`            |
| GET    | /verifikasi-otp   | `ForgotPasswordController@showVerifyOtp`      |
| POST   | /verifikasi-otp   | `ForgotPasswordController@verifyOtp`          |
| GET    | /reset-password   | `ForgotPasswordController@showResetPassword`  |
| POST   | /reset-password   | `ForgotPasswordController@resetPassword`      |

**Screenshot:**

<!-- SCREENSHOT: form lupa password (input email) -->
<!-- SCREENSHOT: form verifikasi OTP -->
<!-- SCREENSHOT: form reset password baru -->

<img width="1600" height="769" alt="WhatsApp Image 2026-07-02 at 11 31 00 AM" src="https://github.com/user-attachments/assets/44d054f7-4c17-4ddd-8e57-b9884a40fe30" />

<img width="1600" height="899" alt="WhatsApp Image 2026-07-02 at 11 33 30 AM" src="https://github.com/user-attachments/assets/1f82ff0e-0a0d-4642-880a-692f08376044" />

<img width="1600" height="865" alt="WhatsApp Image 2026-07-02 at 11 34 24 AM" src="https://github.com/user-attachments/assets/ac691661-bd43-4b3f-92d1-746e5aa4fb5d" />


## 5. Katalog Publik

**Status:** ✅ Selesai
**Aktor:** Publik (belum login)
**Tujuan:** Menampilkan seluruh jasa, paket, dan barang sewa dalam satu halaman katalog yang bisa dicari, difilter, dan diurutkan sebelum pengunjung memesan.

**Alur:**

```
Buka /katalog → sistem gabungkan data Jasa, Paket, dan Barang (sewa)
 → tampil daftar dengan kategori, harga, rating
 → pengunjung bisa cari (nama) dan filter kategori (Jasa/Paket/Sewa Barang)
 → pengunjung bisa urutkan: terbaru, termurah, termahal
 → klik salah satu item → buka /katalog/{slug}
   → tampil detail lengkap, foto-foto, dan testimoni terkait
```

**Route / Controller:**

| Method | Route            | Controller                     |
|--------|-------------------|---------------------------------|
| GET    | /katalog          | `Frontend\KatalogController@index` |
| GET    | /katalog/{slug}   | `Frontend\KatalogController@show`  |

**Screenshot:**

<!-- SCREENSHOT: halaman katalog dengan filter & sorting -->
<!-- SCREENSHOT: halaman detail katalog (jasa/paket/barang) -->

---<img width="1600" height="856" alt="WhatsApp Image 2026-07-02 at 11 20 20 AM" src="https://github.com/user-attachments/assets/6d27c3bc-318e-430e-a2d5-214c34538e82" />

<img width="1600" height="840" alt="WhatsApp Image 2026-07-02 at 11 35 03 AM" src="https://github.com/user-attachments/assets/1a037bc3-8c3c-4c14-96eb-34a4138333d6" />

<img width="1600" height="762" alt="WhatsApp Image 2026-07-02 at 11 35 33 AM" src="https://github.com/user-attachments/assets/3bc43aaa-b8e1-4684-b2ab-64283d12a544" />




## 6. Galeri Publik

**Status:** ✅ Selesai
**Aktor:** Publik (belum login)
**Tujuan:** Menampilkan dokumentasi foto/video kegiatan sanggar sebagai bahan promosi.

**Alur:**

```
Buka /galeri-kami → tampil seluruh galeri (foto/video) terbaru
Beranda (/) → tampil 8 galeri yang ditandai "unggulan" oleh admin
```

**Route / Controller:**

| Method | Route         | Controller                  |
|--------|----------------|-------------------------------|
| GET    | /galeri-kami   | closure route di `routes/web.php` |

**Screenshot:**

<!-- SCREENSHOT: halaman galeri publik -->
<img width="1600" height="782" alt="WhatsApp Image 2026-07-02 at 11 35 59 AM" src="https://github.com/user-attachments/assets/d5daaeb6-885b-4dbb-90b9-1bf6c8a492d7" />

---

## 7. Halaman Tentang

**Status:** ✅ Selesai
**Aktor:** Publik (belum login)
**Tujuan:** Memberi informasi profil dan deskripsi sanggar kepada pengunjung.

**Alur:**

```
Buka /tentang → tampil konten statis profil sanggar
```

**Route / Controller:**

| Method | Route     | Controller                  |
|--------|------------|-------------------------------|
| GET    | /tentang   | View langsung (`Route::view`) |

**Screenshot:**

<!-- SCREENSHOT: halaman tentang -->

<img width="1600" height="769" alt="WhatsApp Image 2026-07-02 at 11 36 13 AM" src="https://github.com/user-attachments/assets/0e0a4e60-6852-4a1e-9d54-c127de1ad98d" />


## 8. Dashboard User

**Status:** ✅ Selesai
**Aktor:** User (Pelanggan)
**Tujuan:** Menampilkan ringkasan informasi pemesanan milik pelanggan yang sedang login.

**Alur:**

```
Login sebagai user → redirect ke /dashboard
 → controller ambil data pemesanan milik user
 → tampil statistik (bulan ini, menunggu, dikonfirmasi, total)
   dan tabel 5 pemesanan terbaru
```

**Route / Controller:**

| Method | Route      | Controller                    |
|--------|------------|-------------------------------|
| GET    | /dashboard | `User\DashboardController@index` |

**Screenshot:**
<img width="1600" height="774" alt="WhatsApp Image 2026-07-02 at 11 14 18 AM" src="https://github.com/user-attachments/assets/79af3169-a11e-4400-b1ae-87c8e4617880" />


---

## 9. Buat Pemesanan (Acara & Sewa Barang)

**Status:** ✅ Selesai
**Aktor:** User (Pelanggan)
**Tujuan:** Pelanggan dapat membuat pemesanan, baik untuk **Acara** (Jasa/Paket, tanggal pelaksanaan tunggal) maupun **Sewa Barang** (rentang tanggal ambil–kembali).

**Alur:**

```
User pilih jenis pemesanan:
 ├─ Acara → /pemesanan/buat/acara → pilih Jasa/Paket, isi tanggal pelaksanaan
 └─ Sewa  → /pemesanan/buat/sewa  → pilih Barang (stok > 0), isi tanggal ambil & kembali

Form juga menampilkan tanggal yang diblokir admin (unavailable-dates) agar tidak bisa dipilih.
User pilih zona lokasi (jika perlu ongkos lokasi) → submit

Server (dalam DB::transaction):
 → jika sewa barang: kunci stok (lock for update), validasi jumlah ≤ stok, kurangi stok
 → hitung ulang total harga di server (subtotal + ongkos lokasi), tidak percaya input client
 → simpan Pemesanan (status "menunggu") + DetailPemesanan
 → jika gagal di tengah proses → rollback otomatis

Redirect ke halaman "submitted" → tampil ringkasan & instruksi pembayaran
```

**Route / Controller:**

| Method | Route                          | Controller                              |
|--------|---------------------------------|-------------------------------------------|
| GET    | /pemesanan/buat/acara            | `User\PemesananController@createAcara`     |
| GET    | /pemesanan/buat/sewa             | `User\PemesananController@createSewa`      |
| POST   | /pemesanan                       | `User\PemesananController@store`           |
| GET    | /pemesanan/{id}/submitted        | `User\PemesananController@submitted`       |
| GET    | /unavailable-dates                | `User\PemesananController@unavailableDates` |

**Screenshot:**

<!-- SCREENSHOT: form buat  -->
<!-- SCREENSHOT: halaman submitted / ringkasan pemesanan -->

<img width="1600" height="787" alt="WhatsApp Image 2026-07-02 at 11 36 53 AM" src="https://github.com/user-attachments/assets/ef70b4a8-8e3c-4b60-ae6d-e90917cd9281" />

<img width="1600" height="812" alt="WhatsApp Image 2026-07-02 at 11 37 12 AM" src="https://github.com/user-attachments/assets/f9bd52a9-74ee-495d-af65-cc20c317298d" />

---

## 10. Riwayat Pemesanan User

**Status:** ✅ Selesai
**Aktor:** User (Pelanggan)
**Tujuan:** Pelanggan dapat melihat seluruh riwayat pemesanan beserta status terkini dan detail setiap pesanan.

**Alur:**

```
User login → buka /pemesanan
 → tampil daftar semua pemesanan milik user
 → user klik pesanan → buka halaman detail (/pemesanan/{id})
 → tampil info lengkap: status, pembayaran, detail barang/jasa, invoice
 → user bisa cetak invoice PDF
```

**Route / Controller:**

| Method | Route                     | Controller                          |
|--------|----------------------------|----------------------------------------|
| GET    | /pemesanan                 | `User\PemesananController@index`        |
| GET    | /pemesanan/{id}             | `User\PemesananController@show`         |
| GET    | /pemesanan/{id}/invoice     | `User\PemesananController@invoice`      |
| GET    | /pemesanan/{id}/invoice/pdf | `User\PemesananController@cetakInvoice` |

<img width="1600" height="778" alt="WhatsApp Image 2026-07-02 at 11 22 04 AM" src="https://github.com/user-attachments/assets/b9e2ab02-764d-4d77-aeae-5b689a289274" />


## 11. Pembayaran via Midtrans (DP & Pelunasan)

**Status:** ✅ Selesai
**Aktor:** User (Pelanggan)
**Tujuan:** Pelanggan membayar DP maupun pelunasan pemesanan secara online lewat Midtrans Snap, menggantikan alur upload bukti transfer manual (lihat `docs/refactoring.md` #5).

**Alur:**

```
Pesanan berstatus dikonfirmasi/berlangsung/menunggu_dp/menunggu_pelunasan
 → user buka /pembayaran/{id}/pilih
 → sistem tentukan tahap: DP (50%) atau Pelunasan (sisa + denda jika ada, dari Pengembalian Barang)
 → user klik bayar → POST /pembayaran/{id}/initiate
 → sistem buat record Pembayaran (status "menunggu") + minta Snap Token ke Midtrans
 → tampil widget Snap → user pilih metode (VA/e-wallet/QRIS/dll) → bayar

Setelah bayar, Midtrans redirect ke /pembayaran/finish (tampilan "sedang diproses")
Midtrans kirim webhook ke /pembayaran/callback (server-to-server, tanpa auth):
 → verifikasi signature → jika settlement/capture sukses:
    → Pembayaran → "terverifikasi"
    → status Pesanan otomatis update:
       ├─ tahap pelunasan     → "selesai"
       ├─ sewa barang (tahap dp) → "menunggu_diambil"
       └─ acara (tahap dp)       → "berlangsung"
    → kirim email konfirmasi ke pelanggan
 → jika cancel/deny/expire → Pembayaran → "ditolak"
```

**Route / Controller:**

| Method | Route                     | Controller                              |
|--------|----------------------------|--------------------------------------------|
| GET    | /pembayaran/{id}/pilih      | `User\PembayaranController@pilih`           |
| POST   | /pembayaran/{id}/initiate   | `User\PembayaranController@initiate`        |
| GET    | /pembayaran/finish          | `User\PembayaranController@finish`          |
| POST   | /pembayaran/callback        | `User\PembayaranController@callback` (webhook, tanpa middleware auth) |

**Screenshot:**

<!-- SCREENSHOT: halaman pilih metode pembayaran -->
<!-- SCREENSHOT: widget Snap Midtrans -->

---

## 12. Ajukan Pembatalan Pemesanan

**Status:** ✅ Selesai
**Aktor:** User (Pelanggan)
**Tujuan:** Pelanggan dapat mengajukan pembatalan pemesanan yang masih berjalan.

**Alur:**

```
Pesanan berstatus dikonfirmasi/menunggu_dp/berlangsung/menunggu_diambil/sedang_disewa
 → user isi alasan pembatalan (min. 20 karakter) → submit
 → sistem cegah duplikat (hanya 1 pengajuan aktif per pesanan)
 → status pembatalan "menunggu" → menunggu diproses admin (estimasi 1-2 hari kerja)
```

**Route / Controller:**

| Method | Route                          | Controller                     |
|--------|----------------------------------|-----------------------------------|
| POST   | /pemesanan/{id}/pembatalan        | `User\PembatalanController@ajukan` |

**Screenshot:**

<!-- SCREENSHOT: form ajukan pembatalan -->

---

## 13. Beri Testimoni

**Status:** ✅ Selesai
**Aktor:** User (Pelanggan)
**Tujuan:** Pelanggan dapat memberi rating dan ulasan setelah pemesanan selesai.

**Alur:**

```
Pesanan berstatus "selesai" → user buka form testimoni (/testimoni/{pemesanan_id}/create)
 → sistem cegah ulasan ganda untuk pesanan yang sama
 → user isi rating (1-5) + ulasan (10-1000 karakter) + opsional foto (maks 2MB/foto)
 → simpan testimoni → redirect ke invoice dengan notifikasi sukses
```


**Route / Controller:**

| Method | Route                          | Controller                          |
|--------|----------------------------------|-----------------------------------------|
| GET    | /testimoni/{pemesanan_id}/create  | `User\TestimoniController@create`       |
| POST   | /testimoni/{pemesanan_id}         | `User\TestimoniController@store`        |

**Screenshot:**

<!-- SCREENSHOT: form beri testimoni -->

<img width="1600" height="779" alt="WhatsApp Image 2026-07-02 at 11 40 35 AM" src="https://github.com/user-attachments/assets/39933077-c6ec-4ad1-aacd-f88ec827aaa2" />

---

## 14. Profil User

**Status:** ✅ Selesai
**Aktor:** User (Pelanggan)
**Tujuan:** Pelanggan dapat melihat dan mengedit data profil akun mereka, termasuk foto dan password.

**Alur:**

```
Buka /profil → tampil data profil (nama, email, no HP, foto)
 → Edit data: ubah nama/no HP → simpan
 → Ganti password: isi password lama + baru (min. 8 karakter, beda dari lama) → simpan
 → Ganti foto profil: upload JPG/PNG (maks 2MB) → foto lama otomatis dihapus
```

**Route / Controller:**

| Method | Route          | Controller                        |
|--------|-----------------|---------------------------------------|
| GET    | /profil         | `User\ProfileController@index`        |
| PUT    | /profil         | `User\ProfileController@update`       |
| PUT    | /profil/foto    | `User\ProfileController@updatePhoto`  |

**Screenshot:**

<!-- SCREENSHOT: halaman profil user -->

<img width="1600" height="819" alt="WhatsApp Image 2026-07-02 at 11 40 43 AM" src="https://github.com/user-attachments/assets/d18e0a9f-bef6-41c7-a4e9-930990f1a11f" />

---

## 15. Dashboard Admin

**Status:** ✅ Selesai
**Aktor:** Admin
**Tujuan:** Menampilkan statistik keseluruhan pemesanan untuk monitoring admin.

**Alur:**

```
Login sebagai admin → redirect ke /admin/dashboard
 → controller ambil statistik semua pemesanan
 → tampil jumlah pemesanan bulan ini, menunggu, dikonfirmasi, dan total
```

**Route / Controller:**

| Method | Route            | Controller                     |
|--------|------------------|--------------------------------|
| GET    | /admin/dashboard | `Admin\DashboardController@index` |

**Screenshot:**

<img width="1600" height="775" alt="WhatsApp Image 2026-07-02 at 11 21 05 AM" src="https://github.com/user-attachments/assets/45fc65b8-e8a1-48c5-b739-4a187ac91a99" />


---

## 16. Kelola Pemesanan (Admin)

**Status:** ✅ Selesai
**Aktor:** Admin
**Tujuan:** Admin mengelola siklus penuh pemesanan, dari konfirmasi awal sampai selesai/dibatalkan.

**Alur:**

```
Admin buka /admin/pemesanan → tampil daftar semua pemesanan dengan filter status
 → admin klik pesanan → tampil detail lengkap

Konfirmasi pesanan baru:
 → sewa barang → status jadi "menunggu_dp" (menunggu DP)
 → acara       → status jadi "dikonfirmasi"
 → email invoice/instruksi pembayaran terkirim otomatis

Tolak pesanan baru:
 → admin isi alasan (min. 10 karakter) → status jadi "dibatalkan"

Alur lanjutan (khusus sewa barang):
 → "Tandai Diambil"      : menunggu_diambil → sedang_disewa
 → "Tandai Dikembalikan" : sedang_disewa/menunggu_pengembalian → menunggu_pelunasan
                            (sistem hitung denda keterlambatan otomatis jika lewat jadwal)
 → lanjut ke inspeksi kondisi barang di menu Pengembalian Barang

Alur lanjutan (khusus acara):
 → "Tandai Acara Selesai" : berlangsung → selesai (jika sudah lunas)
                             atau → menunggu_pelunasan (jika belum lunas, kirim tagihan)

Transisi status lain juga bisa dilakukan manual lewat "Update Status"
mengikuti alur yang diizinkan (allowedTransitions).
```

**Route / Controller:**

| Method | Route                             | Controller                              |
|--------|-----------------------------------|-----------------------------------------|
| GET    | /admin/pemesanan                  | `Admin\PemesananController@index`       |
| GET    | /admin/pemesanan/{id}             | `Admin\PemesananController@show`        |
| PATCH  | /admin/pemesanan/{id}/konfirmasi  | `Admin\PemesananController@konfirmasi`  |
| PATCH  | /admin/pemesanan/{id}/tolak       | `Admin\PemesananController@tolak`       |
| PATCH  | /admin/pemesanan/{id}/diambil     | `Admin\PemesananController@tandaiDiambil` |
| POST   | /admin/pemesanan/{id}/dikembalikan| `Admin\PemesananController@tandaiDikembalikan` |
| PATCH  | /admin/pemesanan/{id}/acara-selesai | `Admin\PemesananController@tandaiAcaraSelesai` |
| PATCH  | /admin/pemesanan/{id}/update-status | `Admin\PemesananController@updateStatus` |

---
<img width="1600" height="823" alt="WhatsApp Image 2026-07-02 at 11 42 14 AM" src="https://github.com/user-attachments/assets/b8c52fda-ed68-40df-829e-a53a9a1ffb29" />

## 17. Verifikasi Pembayaran (Admin)

**Status:** ✅ Selesai
**Aktor:** Admin
**Tujuan:** Admin memantau data pembayaran pelanggan.

> Catatan: sejak integrasi Midtrans, verifikasi status pembayaran sudah
> dilakukan **otomatis** lewat webhook (lihat fitur #11). Perlu dicek ke tim
> apakah endpoint verifikasi/tolak manual di sini masih aktif dipakai untuk
> kasus tertentu (mis. pembayaran non-Midtrans) atau tinggal peninggalan alur
> lama yang bisa disederhanakan/dihapus.

**Alur:**

```
Admin buka /admin/pembayaran → tampil daftar pembayaran dengan filter status
 → admin klik pembayaran → tampil detail transaksi
```

**Route / Controller:**

| Method | Route                                  | Controller                               |
|--------|----------------------------------------|-------------------------------------------|
| GET    | /admin/pembayaran                      | `Admin\PembayaranController@index`       |
| GET    | /admin/pembayaran/{id}                 | `Admin\PembayaranController@show`        |
| PATCH  | /admin/pembayaran/{id}/verifikasi      | `Admin\PembayaranController@verifikasi`  |
| PATCH  | /admin/pembayaran/{id}/tolak           | `Admin\PembayaranController@tolak`       |

---
<img width="1600" height="836" alt="WhatsApp Image 2026-07-02 at 11 41 46 AM" src="https://github.com/user-attachments/assets/ccf3b86f-4832-4925-bce2-0d5909ee5347" />


## 18. Kelola Pembatalan (Admin)

**Status:** ✅ Selesai
**Aktor:** Admin
**Tujuan:** Admin menyetujui atau menolak pengajuan pembatalan dari pelanggan.

**Alur:**

```
Admin buka /admin/pembatalan → daftar diurutkan: menunggu → disetujui → ditolak
 → admin klik pengajuan → tampil detail pesanan, pembayaran, dan alasan pelanggan

Setujui:
 → jika sewa barang & status masih menunggu_dp/menunggu_diambil → stok barang dikembalikan
 → status Pesanan → "dibatalkan" (DP tidak dikembalikan)
 → kirim email PembatalanDisetujuiMail

Tolak:
 → admin isi catatan (min. 10 karakter)
 → kirim email PembatalanDitolakMail
```

**Route / Controller:**

| Method | Route                             | Controller                          |
|--------|-------------------------------------|-----------------------------------------|
| GET    | /admin/pembatalan                   | `Admin\PembatalanController@index`      |
| GET    | /admin/pembatalan/{id}              | `Admin\PembatalanController@show`       |
| PATCH  | /admin/pembatalan/{id}/setujui      | `Admin\PembatalanController@setujui`    |
| PATCH  | /admin/pembatalan/{id}/tolak        | `Admin\PembatalanController@tolak`      |

---
<img width="1600" height="839" alt="WhatsApp Image 2026-07-02 at 11 42 56 AM" src="https://github.com/user-attachments/assets/28ccdffa-24ce-4a3d-8976-e1bb2944f9f7" />


## 19. Kelola Pengembalian Barang (Admin)

**Status:** ✅ Selesai
**Aktor:** Admin
**Tujuan:** Admin memeriksa kondisi barang yang dikembalikan dan menghitung denda kerusakan.

**Alur:**

```
Admin buka /admin/pengembalian → daftar barang yang sudah ditandai "dikembalikan"
 → admin buka detail → pilih kondisi barang (baik/rusak ringan/rusak berat/hilang)
 → isi catatan kerusakan + upload foto bukti + nominal denda kerusakan
 → sistem hitung total denda = denda keterlambatan + denda kerusakan
 → pesanan tetap "menunggu_pelunasan" sampai pelanggan bayar sisa sewa + denda
```

**Route / Controller:**

| Method | Route                     | Controller                                  |
|--------|----------------------------|--------------------------------------------------|
| GET    | /admin/pengembalian         | `Admin\PengembalianBarangController@index`        |
| GET    | /admin/pengembalian/{id}    | `Admin\PengembalianBarangController@show`         |
| PUT    | /admin/pengembalian/{id}    | `Admin\PengembalianBarangController@update`       |

---
<img width="1600" height="832" alt="WhatsApp Image 2026-07-02 at 11 43 04 AM" src="https://github.com/user-attachments/assets/ac10ef81-99d0-4fc2-a139-019e9929662e" />


## 20. Kelola Jasa (Admin)

**Status:** ✅ Selesai
**Aktor:** Admin
**Tujuan:** Admin dapat menambah, mengedit, dan menghapus data jasa yang tersedia di sanggar.

**Alur:**

```
Admin buka /admin/jasa → tampil daftar jasa
 → Tambah: klik "Tambah Jasa" → isi form → simpan
 → Edit: klik edit pada jasa → ubah data → simpan
 → Hapus: klik hapus → konfirmasi → data dihapus
```

**Route / Controller:**

| Method | Route                  | Controller                      |
|--------|------------------------|---------------------------------|
| GET    | /admin/jasa            | `Admin\JasaController@index`    |
| GET    | /admin/jasa/create     | `Admin\JasaController@create`   |
| POST   | /admin/jasa            | `Admin\JasaController@store`    |
| GET    | /admin/jasa/{id}        | `Admin\JasaController@show`     |
| GET    | /admin/jasa/{id}/edit  | `Admin\JasaController@edit`     |
| PUT    | /admin/jasa/{id}       | `Admin\JasaController@update`   |
| DELETE | /admin/jasa/{id}       | `Admin\JasaController@destroy`  |

---
<img width="1600" height="845" alt="WhatsApp Image 2026-07-02 at 11 43 27 AM" src="https://github.com/user-attachments/assets/767b4903-437b-4ceb-921c-9f4294cc9cc6" />

## 21. Kelola Paket (Admin)

**Status:** ✅ Selesai
**Aktor:** Admin
**Tujuan:** Admin dapat mengelola data paket layanan beserta foto-foto paket yang ditawarkan sanggar.

**Alur:**

```
Admin buka /admin/paket → tampil daftar paket
 → Tambah: klik "Tambah Paket" → isi form (nama, deskripsi, harga, foto) → simpan
 → Edit: klik edit → ubah data atau tambah/hapus foto → simpan
 → Hapus paket: klik hapus → konfirmasi → data dan foto dihapus
 → Hapus foto: klik hapus pada foto individual → foto dihapus
```

**Route / Controller:**

| Method | Route                          | Controller                           |
|--------|---------------------------------|----------------------------------------|
| GET    | /admin/paket                   | `Admin\PaketController@index`        |
| GET    | /admin/paket/create            | `Admin\PaketController@create`       |
| POST   | /admin/paket                   | `Admin\PaketController@store`        |
| GET    | /admin/paket/{id}               | `Admin\PaketController@show`         |
| GET    | /admin/paket/{id}/edit         | `Admin\PaketController@edit`         |
| PUT    | /admin/paket/{id}              | `Admin\PaketController@update`       |
| DELETE | /admin/paket/{id}              | `Admin\PaketController@destroy`      |
| GET    | /admin/paket/foto/{id}/hapus   | `Admin\PaketController@destroyFoto`  |

---
<img width="1600" height="811" alt="WhatsApp Image 2026-07-02 at 11 43 39 AM" src="https://github.com/user-attachments/assets/8f1410c1-e884-478a-8423-2baa1baeda85" />

## 22. Kelola Barang (Admin)

**Status:** ✅ Selesai
**Aktor:** Admin
**Tujuan:** Admin mengelola data inventaris barang sewa milik sanggar, termasuk stok dan foto.

**Alur:**

```
Admin buka /admin/barang → tampil daftar barang per kategori
 → Tambah: pilih kategori, isi nama/deskripsi/harga/nilai barang/stok,
   upload foto thumbnail + foto tambahan → simpan
 → Edit: ubah data, ganti thumbnail (foto lama dihapus), tambah foto baru
 → Hapus: hapus data + thumbnail + seluruh foto terkait
```

**Route / Controller:**

| Method | Route                     | Controller                       |
|--------|----------------------------|--------------------------------------|
| GET    | /admin/barang               | `Admin\BarangController@index`       |
| GET    | /admin/barang/create        | `Admin\BarangController@create`      |
| POST   | /admin/barang               | `Admin\BarangController@store`       |
| GET    | /admin/barang/{id}           | `Admin\BarangController@show`        |
| GET    | /admin/barang/{id}/edit     | `Admin\BarangController@edit`        |
| PUT    | /admin/barang/{id}          | `Admin\BarangController@update`      |
| DELETE | /admin/barang/{id}          | `Admin\BarangController@destroy`     |

**Screenshot:**

<!-- SCREENSHOT: halaman kelola barang -->

<img width="1600" height="777" alt="WhatsApp Image 2026-07-02 at 11 43 47 AM" src="https://github.com/user-attachments/assets/01c782d2-fa2b-4041-b4ed-91a533169c97" />


## 23. Kelola Kategori (Admin)

**Status:** ✅ Selesai
**Aktor:** Admin
**Tujuan:** Admin mengelola kategori untuk Jasa, Paket, dan Barang lewat satu controller yang sama (dibedakan lewat parameter `{tipe}`).

**Alur:**

```
Admin pilih tipe kategori (jasa/paket/barang) → /admin/kategori/{tipe}
 → tampil daftar kategori untuk tipe tersebut
 → Tambah/Edit: isi nama + deskripsi opsional → simpan
 → Hapus: hapus kategori (pastikan tidak ada data yang masih memakainya)
```

**Route / Controller:**

| Method | Route                          | Controller                        |
|--------|----------------------------------|---------------------------------------|
| GET    | /admin/kategori/{tipe}           | `Admin\KategoriController@index`      |
| GET    | /admin/kategori/{tipe}/create    | `Admin\KategoriController@create`     |
| POST   | /admin/kategori/{tipe}           | `Admin\KategoriController@store`      |
| GET    | /admin/kategori/{tipe}/{id}/edit | `Admin\KategoriController@edit`       |
| PUT    | /admin/kategori/{tipe}/{id}      | `Admin\KategoriController@update`     |
| DELETE | /admin/kategori/{tipe}/{id}      | `Admin\KategoriController@destroy`    |

**Screenshot:**

<!-- SCREENSHOT: halaman kelola kategori -->
<img width="1600" height="786" alt="WhatsApp Image 2026-07-02 at 11 43 58 AM" src="https://github.com/user-attachments/assets/130fe13f-6678-4abe-bfe9-863fd6f9c944" />


## 24. Kelola Galeri (Admin)

**Status:** ✅ Selesai
**Aktor:** Admin
**Tujuan:** Admin mengelola foto/video galeri yang tampil di halaman publik.

**Alur:**

```
Admin buka /admin/galeri → tampil daftar media
 → Tambah: upload media (jpg/png/mp4/mov), isi judul/kategori/keterangan,
   centang "unggulan" jika ingin tampil di beranda → simpan
 → Edit: ubah metadata atau ganti media (file lama dihapus)
 → Hapus: hapus media + file terkait
```

**Route / Controller:**

| Method | Route                    | Controller                     |
|--------|----------------------------|-----------------------------------|
| GET    | /admin/galeri               | `Admin\GaleriController@index`     |
| GET    | /admin/galeri/create        | `Admin\GaleriController@create`    |
| POST   | /admin/galeri               | `Admin\GaleriController@store`     |
| GET    | /admin/galeri/{id}/edit     | `Admin\GaleriController@edit`      |
| PUT    | /admin/galeri/{id}          | `Admin\GaleriController@update`    |
| DELETE | /admin/galeri/{id}          | `Admin\GaleriController@destroy`   |

**Screenshot:**

<!-- SCREENSHOT: halaman kelola galeri -->

<img width="1600" height="889" alt="WhatsApp Image 2026-07-02 at 11 44 36 AM" src="https://github.com/user-attachments/assets/38f94721-57a4-47fa-8ced-95adadd9060d" />

## 25. Kelola Zona Lokasi (Admin)

**Status:** ✅ Selesai
**Aktor:** Admin
**Tujuan:** Admin mendefinisikan zona lokasi pengantaran beserta biaya dan persentase ongkos yang dibebankan ke pemesanan.

**Alur:**

```
Admin buka /admin/zona-lokasi → tampil daftar zona
 → Tambah/Edit: isi nama zona, biaya, persentase (0-100%), keterangan opsional
 → Hapus: hapus zona (zona yang sudah dipakai pemesanan lama tidak terpengaruh)
```

**Route / Controller:**

| Method | Route                       | Controller                          |
|--------|-------------------------------|------------------------------------------|
| GET    | /admin/zona-lokasi             | `Admin\ZonaLokasiController@index`        |
| GET    | /admin/zona-lokasi/create      | `Admin\ZonaLokasiController@create`       |
| POST   | /admin/zona-lokasi             | `Admin\ZonaLokasiController@store`        |
| GET    | /admin/zona-lokasi/{id}/edit   | `Admin\ZonaLokasiController@edit`         |
| PUT    | /admin/zona-lokasi/{id}        | `Admin\ZonaLokasiController@update`       |
| DELETE | /admin/zona-lokasi/{id}        | `Admin\ZonaLokasiController@destroy`      |

**Screenshot:**

<!-- SCREENSHOT: halaman kelola zona lokasi -->

<img width="1600" height="825" alt="WhatsApp Image 2026-07-02 at 11 44 48 AM" src="https://github.com/user-attachments/assets/58a92953-566a-44d1-8ac4-c32af4c09a38" />


## 26. Blokir Tanggal (Admin)

**Status:** ✅ Selesai
**Aktor:** Admin
**Tujuan:** Admin memblokir tanggal tertentu (mis. sanggar tutup/acara internal) agar tidak bisa dipesan pelanggan.

**Alur:**

```
Admin buka /admin/blokir-tanggal → tampil daftar tanggal yang diblokir
 → Tambah: pilih tanggal (harus unik) + keterangan opsional → simpan
 → Hapus: hapus tanggal blokir
 → Tanggal yang diblokir otomatis muncul sebagai "tidak tersedia" di kalender
   form pemesanan user (lihat fitur #9)
```

**Route / Controller:**

| Method | Route                      | Controller                             |
|--------|-------------------------------|--------------------------------------------|
| GET    | /admin/blokir-tanggal          | `Admin\BlokirTanggalController@index`       |
| POST   | /admin/blokir-tanggal          | `Admin\BlokirTanggalController@store`       |
| DELETE | /admin/blokir-tanggal/{id}     | `Admin\BlokirTanggalController@destroy`     |

**Screenshot:**

<!-- SCREENSHOT: halaman blokir tanggal -->

<img width="1600" height="832" alt="WhatsApp Image 2026-07-02 at 11 45 10 AM" src="https://github.com/user-attachments/assets/1137c1d4-3e2e-4402-8606-c2dcf7e4d849" />


## 27. Kelola Pelanggan (Admin)

**Status:** ✅ Selesai
**Aktor:** Admin
**Tujuan:** Admin dapat melihat daftar pelanggan terdaftar.

**Alur:**

```
Admin buka /admin/pelanggan → tampil daftar seluruh pelanggan
```

**Route / Controller:**

| Method | Route             | Controller                          |
|--------|--------------------|------------------------------------------|
| GET    | /admin/pelanggan    | `Admin\PelangganController@index`         |

**Screenshot:**

<!-- SCREENSHOT: halaman kelola pelanggan -->

<img width="1600" height="818" alt="WhatsApp Image 2026-07-02 at 11 45 35 AM" src="https://github.com/user-attachments/assets/8636af31-b216-4cc2-81f3-d06aef7c59f8" />


## 28. Kelola Testimoni (Admin)

**Status:** ✅ Selesai
**Aktor:** Admin
**Tujuan:** Admin dapat melihat dan membalas testimoni yang diberikan oleh pelanggan.

**Alur:**

```
Admin buka /admin/testimoni → tampil seluruh testimoni + rata-rata rating
 → admin klik testimoni → isi balasan (maks. 1000 karakter) → simpan
```

**Route / Controller:**

| Method | Route                        | Controller                             |
|--------|--------------------------------|---------------------------------------------|
| GET    | /admin/testimoni                | `Admin\TestimoniController@index`            |
| PATCH  | /admin/testimoni/{id}/balas     | `Admin\TestimoniController@balas`            |

**Screenshot:**

<!-- SCREENSHOT: halaman kelola testimoni -->

<img width="1600" height="823" alt="WhatsApp Image 2026-07-02 at 11 45 46 AM" src="https://github.com/user-attachments/assets/4c3c9666-b292-43fb-8199-bdffea5124bc" />

## 29. Laporan (Admin)

**Status:** ✅ Selesai
**Aktor:** Admin
**Tujuan:** Admin dapat melihat rekap KPI pemesanan/pendapatan dan mengekspor data transaksi ke Excel.

**Alur:**

```
Admin buka /admin/laporan → tampil:
 - pendapatan bulan berjalan (dari pembayaran terverifikasi)
 - total pesanan, selesai, dibatalkan
 - grafik pendapatan 12 bulan terakhir
 - 5 item (barang/jasa/paket) terpopuler
 - 10 transaksi terbaru

Klik "Export Excel" → sistem generate file .xlsx berisi seluruh transaksi
 (kode pesanan, nama pemesan, jenis, total harga, status, tanggal) → download
```

**Route / Controller:**

| Method | Route                        | Controller                          |
|--------|--------------------------------|------------------------------------------|
| GET    | /admin/laporan                  | `Admin\LaporanController@index`           |
| GET    | /admin/laporan/export-excel     | `Admin\LaporanController@exportExcel`     |

**Screenshot:**

<!-- SCREENSHOT: halaman laporan/dashboard KPI -->

<img width="1600" height="826" alt="WhatsApp Image 2026-07-02 at 11 44 58 AM" src="https://github.com/user-attachments/assets/7903d740-9db2-4b51-a56b-75a96654c18b" />


## 30. Profil Admin (Akun)

**Status:** ✅ Selesai
**Aktor:** Admin
**Tujuan:** Admin dapat mengedit data akun sendiri (nama, no HP, foto, password).

**Alur:**

```
Admin buka /admin/akun → tampil data profil admin
 → Edit data: ubah nama/no HP/foto profil → simpan (foto lama dihapus jika diganti)
 → Ganti password: isi password lama + baru (min. 8 karakter, beda dari lama) → simpan
```

**Route / Controller:**

| Method | Route                  | Controller                            |
|--------|--------------------------|-------------------------------------------|
| GET    | /admin/akun               | `Admin\ProfileController@index`            |
| PUT    | /admin/akun               | `Admin\ProfileController@update`           |
| PUT    | /admin/akun/password      | `Admin\ProfileController@updatePassword`   |

**Screenshot:**

<!-- SCREENSHOT: halaman profil/akun admin -->

<img width="1600" height="785" alt="WhatsApp Image 2026-07-02 at 11 46 19 AM" src="https://github.com/user-attachments/assets/b84e0fac-9fdd-428e-b195-7398deb71851" />


## 31. Notifikasi Email Pemesanan

**Status:** 🔄 Perlu verifikasi
**Aktor:** Sistem (otomatis)
**Tujuan:** Sistem mengirimkan email otomatis di berbagai titik alur pemesanan & pembayaran.

**Alur (yang sudah pasti berjalan, terpicu oleh aksi admin/user):**

```
- Konfirmasi/Update Status pesanan → InvoiceMail / TagihanPelunasanMail
- Pembayaran terverifikasi (webhook Midtrans) → PembayaranBerhasilMail
- Pembatalan disetujui/ditolak → PembatalanDisetujuiMail / PembatalanDitolakMail
- Lupa password → OtpMail
```

**Alur reminder terjadwal (H-1 sebelum tanggal pengembalian) — perlu dicek ke tim:**

```
Scheduler berjalan setiap hari (jika sudah diimplementasikan)
 → ambil semua pesanan sewa yang sedang berlangsung
 → cek tanggal pengembalian di detail_pemesanan
 → jika tanggal pengembalian = besok → kirim email reminder ke pelanggan
```

> Bagian reminder terjadwal ini belum sempat dikonfirmasi ada di kode
> (butuh cek `routes/console.php` / scheduled command). Email transaksional
> lainnya (invoice, pembayaran berhasil, pembatalan) sudah pasti berjalan.

**Route / Controller:** _(trigger dari controller lain, bukan endpoint tersendiri)_

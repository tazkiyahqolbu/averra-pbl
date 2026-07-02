# Dokumentasi Fitur — Sistem Informasi Sanggar Rantiang Tagok (SILART)

Dokumen ini merangkum seluruh fitur sistem beserta aktor, tujuan, alur, dan
route/controller terkait. Status menunjukkan progres pengembangan tiap fitur.

## Daftar Fitur

| No | Fitur | Aktor | Status |
|----|-------|-------|--------|
| 1  | [Login](#1-login)                                         | User & Admin | ✅ Selesai      |
| 2  | [Register](#2-register)                                   | User         | ✅ Selesai      |
| 3  | [Logout](#3-logout)                                       | User & Admin | ✅ Selesai      |
| 4  | [Dashboard User](#4-dashboard-user)                       | User         | ✅ Selesai      |
| 5  | [Dashboard Admin](#5-dashboard-admin)                     | Admin        | ✅ Selesai      |
| 6  | [Riwayat Pemesanan User](#6-riwayat-pemesanan-user)       | User         | ✅ Selesai      |
| 7  | [Upload Bukti Pembayaran](#7-upload-bukti-pembayaran)     | User         | ✅ Selesai      |
| 8  | [Profil User](#8-profil-user)                             | User         | ✅ Selesai  |
| 9  | [Kelola Pemesanan (Admin)](#9-kelola-pemesanan-admin)     | Admin        | ✅ Selesai      |
| 10 | [Verifikasi Pembayaran (Admin)](#10-verifikasi-pembayaran-admin) | Admin | ✅ Selesai      |
| 11 | [Kelola Jasa (Admin)](#11-kelola-jasa-admin)             | Admin        | ✅ Selesai      |
| 12 | [Kelola Paket (Admin)](#12-kelola-paket-admin)           | Admin        | ✅ Selesai      |
| 13 | [Kelola Barang (Admin)](#13-kelola-barang-admin)         | Admin        | ✅ Selesai  |
| 14 | [Kelola Testimoni (Admin)](#14-kelola-testimoni-admin)   | Admin        | 🔄 Dalam Proses |
| 15 | [Laporan (Admin)](#15-laporan-admin)                     | Admin        | 🔄 Dalam Proses |
| 16 | [Notifikasi Email Pemesanan](#16-notifikasi-email-pemesanan) | Sistem   | 🔄 Dalam Proses |

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

<img width="593" height="721" alt="image" src="https://github.com/user-attachments/assets/714b65c0-ada2-4fcd-b69e-8490abf58fb3" />


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

<img width="570" height="765" alt="image" src="https://github.com/user-attachments/assets/da10c155-694b-4b98-8d6a-9ea8005479a5" />


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
|--------|---------|-----------------------|
| POST   | /logout | `AuthController@logout` |

**Screenshot:**
<img width="353" height="171" alt="image" src="https://github.com/user-attachments/assets/ba17ce0a-e3f3-426f-8a4d-d649e667f0f6" />

---

## 4. Dashboard User

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
<img width="1902" height="868" alt="image" src="https://github.com/user-attachments/assets/c1be08df-8fdb-4747-bceb-048049b8f6af" />


---

## 5. Dashboard Admin

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

<img width="1907" height="870" alt="image" src="https://github.com/user-attachments/assets/c6e51079-b190-4946-a528-cdaa58a73d88" />


---

## 6. Riwayat Pemesanan User

**Status:** ✅ Selesai
**Aktor:** User (Pelanggan)
**Tujuan:** Pelanggan dapat melihat seluruh riwayat pemesanan beserta status terkini dan detail setiap pesanan.

**Alur:**

```
User login → buka /pemesanan
 → tampil daftar semua pemesanan milik user
 → user klik pesanan → buka halaman detail (/pemesanan/{id})
 → tampil info lengkap: status, pembayaran, detail barang/jasa, invoice
```

**Route / Controller:**

| Method | Route              | Controller                        |
|--------|--------------------|-----------------------------------|
| GET    | /pemesanan         | `User\PemesananController@index`  |
| GET    | /pemesanan/{id}    | `User\PemesananController@show`   |
| GET    | /pemesanan/{id}/invoice | `User\PemesananController@invoice` |

---

## 7. Upload Bukti Pembayaran

**Status:** ✅ Selesai
**Aktor:** User (Pelanggan)
**Tujuan:** Pelanggan dapat mengupload bukti transfer sebagai konfirmasi pembayaran setelah pemesanan dikonfirmasi admin.

**Alur:**

```
Pesanan berstatus dikonfirmasi → user buka detail pesanan (/pemesanan/{id})
 → tampil info rekening tujuan dan form upload bukti
 → user pilih file (JPG/PNG/PDF, maks 5 MB) → klik "Kirim Bukti"
 → sistem simpan file ke storage, update status pembayaran jadi "menunggu verifikasi"
 → tampil notifikasi berhasil, status bukti berubah menjadi "Sedang Diverifikasi"

Jika bukti sebelumnya ditolak admin:
 → tampil pesan penolakan dan alasan
 → user dapat upload ulang bukti baru
```

**Route / Controller:**

| Method | Route                  | Controller                          |
|--------|------------------------|-------------------------------------|
| POST   | /pembayaran/upload     | `User\PembayaranController@upload`  |

---

## 8. Profil User

**Status:** 🔄 Dalam Proses
**Aktor:** User (Pelanggan)
**Tujuan:** Pelanggan dapat melihat dan mengedit data profil akun mereka.

**Alur:** _(dalam proses pengembangan)_

**Route / Controller:** _belum tersedia_

---

## 9. Kelola Pemesanan (Admin)

**Status:** ✅ Selesai
**Aktor:** Admin
**Tujuan:** Admin dapat melihat, mengkonfirmasi, atau menolak seluruh data pemesanan yang masuk dari pelanggan.

**Alur:**

```
Admin buka /admin/pemesanan → tampil daftar semua pemesanan dengan filter status
 → admin klik pesanan → tampil detail lengkap termasuk data pelanggan dan barang/jasa

Konfirmasi pesanan:
 → admin klik "Konfirmasi" → status pesanan berubah jadi "dikonfirmasi"
 → pelanggan mendapat notifikasi untuk melanjutkan pembayaran

Tolak pesanan:
 → admin isi alasan penolakan → klik "Tolak"
 → status pesanan berubah jadi "dibatalkan"
```

**Route / Controller:**

| Method | Route                             | Controller                              |
|--------|-----------------------------------|-----------------------------------------|
| GET    | /admin/pemesanan                  | `Admin\PemesananController@index`       |
| GET    | /admin/pemesanan/{id}             | `Admin\PemesananController@show`        |
| PATCH  | /admin/pemesanan/{id}/konfirmasi  | `Admin\PemesananController@konfirmasi`  |
| PATCH  | /admin/pemesanan/{id}/tolak       | `Admin\PemesananController@tolak`       |

---

## 10. Verifikasi Pembayaran (Admin)

**Status:** ✅ Selesai
**Aktor:** Admin
**Tujuan:** Admin dapat memverifikasi atau menolak bukti pembayaran yang diupload pelanggan.

**Alur:**

```
Admin buka /admin/pembayaran → tampil daftar pembayaran dengan filter status
 → admin klik pembayaran → tampil detail termasuk preview bukti transfer

Verifikasi:
 → admin klik "Verifikasi Pembayaran"
 → status pembayaran berubah jadi "terverifikasi"
 → status pesanan otomatis diperbarui:
    ├─ Jika tahap DP atau langsung → status pesanan jadi "berlangsung"
    └─ Jika tahap pelunasan → status pesanan jadi "selesai"

Tolak:
 → admin isi alasan penolakan → klik "Tolak Pembayaran"
 → status pembayaran berubah jadi "ditolak"
 → pelanggan dapat upload ulang bukti baru
```

**Route / Controller:**

| Method | Route                                  | Controller                               |
|--------|----------------------------------------|------------------------------------------|
| GET    | /admin/pembayaran                      | `Admin\PembayaranController@index`       |
| GET    | /admin/pembayaran/{id}                 | `Admin\PembayaranController@show`        |
| PATCH  | /admin/pembayaran/{id}/verifikasi      | `Admin\PembayaranController@verifikasi`  |
| PATCH  | /admin/pembayaran/{id}/tolak           | `Admin\PembayaranController@tolak`       |

---

## 11. Kelola Jasa (Admin)

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
| GET    | /admin/jasa/{id}/edit  | `Admin\JasaController@edit`     |
| PUT    | /admin/jasa/{id}       | `Admin\JasaController@update`   |
| DELETE | /admin/jasa/{id}       | `Admin\JasaController@destroy`  |

---

## 12. Kelola Paket (Admin)

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
|--------|--------------------------------|--------------------------------------|
| GET    | /admin/paket                   | `Admin\PaketController@index`        |
| GET    | /admin/paket/create            | `Admin\PaketController@create`       |
| POST   | /admin/paket                   | `Admin\PaketController@store`        |
| GET    | /admin/paket/{id}/edit         | `Admin\PaketController@edit`         |
| PUT    | /admin/paket/{id}              | `Admin\PaketController@update`       |
| DELETE | /admin/paket/{id}              | `Admin\PaketController@destroy`      |
| GET    | /admin/paket/foto/{id}/hapus   | `Admin\PaketController@destroyFoto`  |

---

## 13. Kelola Barang (Admin)

**Status:** 🔄 Dalam Proses
**Aktor:** Admin
**Tujuan:** Admin dapat mengelola data inventaris barang milik sanggar.

**Alur:** _(dalam proses pengembangan)_

**Route / Controller:** _belum tersedia_

---

## 14. Kelola Testimoni (Admin)

**Status:** 🔄 Dalam Proses
**Aktor:** Admin
**Tujuan:** Admin dapat mengelola testimoni yang diberikan oleh pelanggan.

**Alur:** _(dalam proses pengembangan)_

**Route / Controller:** _belum tersedia_

---

## 15. Laporan (Admin)

**Status:** 🔄 Dalam Proses
**Aktor:** Admin
**Tujuan:** Admin dapat melihat laporan rekap pemesanan dan pendapatan sanggar.

**Alur:** _(dalam proses pengembangan)_

**Route / Controller:** _belum tersedia_

---

## 16. Notifikasi Email Pemesanan

**Status:** 🔄 Dalam Proses
**Aktor:** Sistem (otomatis)
**Tujuan:** Sistem mengirimkan email pengingat otomatis kepada pelanggan H-1 sebelum tanggal pengembalian untuk pesanan yang sedang berlangsung.

**Alur:**

```
Scheduler berjalan setiap hari
 → ambil semua pesanan dengan status "berlangsung"
 → cek tanggal pengembalian di detail_pemesanan
 → jika tanggal pengembalian = besok → kirim email reminder ke pelanggan
 → email berisi: nama pelanggan, kode pesanan, tanggal pengembalian, detail barang/jasa
```

**Route / Controller:** _(dalam proses pengembangan)_

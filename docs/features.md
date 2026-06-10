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
| 6  | [Riwayat Pemesanan User](#6-riwayat-pemesanan-user)       | User         | 🔄 Dalam Proses |
| 7  | [Upload Bukti Pembayaran](#7-upload-bukti-pembayaran)     | User         | 🔄 Dalam Proses |
| 8  | [Profil User](#8-profil-user)                             | User         | 🔄 Dalam Proses |
| 9  | [Kelola Pemesanan (Admin)](#9-kelola-pemesanan-admin)     | Admin        | 🔄 Dalam Proses |
| 10 | [Verifikasi Pembayaran (Admin)](#10-verifikasi-pembayaran-admin) | Admin | 🔄 Dalam Proses |
| 11 | [Kelola Jasa (Admin)](#11-kelola-jasa-admin)             | Admin        | 🔄 Dalam Proses |
| 12 | [Kelola Paket (Admin)](#12-kelola-paket-admin)           | Admin        | 🔄 Dalam Proses |
| 13 | [Kelola Barang (Admin)](#13-kelola-barang-admin)         | Admin        | 🔄 Dalam Proses |
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

**Status:** 🔄 Dalam Proses
**Aktor:** User (Pelanggan)
**Tujuan:** Pelanggan dapat melihat seluruh riwayat pemesanan yang pernah dilakukan.

**Alur:** _(dalam proses pengembangan)_

**Route / Controller:** _belum tersedia_

---

## 7. Upload Bukti Pembayaran

**Status:** 🔄 Dalam Proses
**Aktor:** User (Pelanggan)
**Tujuan:** Pelanggan dapat mengupload bukti transfer sebagai konfirmasi pembayaran pemesanan.

**Alur:** _(dalam proses pengembangan)_

**Route / Controller:** _belum tersedia_

---

## 8. Profil User

**Status:** 🔄 Dalam Proses
**Aktor:** User (Pelanggan)
**Tujuan:** Pelanggan dapat melihat dan mengedit data profil akun mereka.

**Alur:** _(dalam proses pengembangan)_

**Route / Controller:** _belum tersedia_

---

## 9. Kelola Pemesanan (Admin)

**Status:** 🔄 Dalam Proses
**Aktor:** Admin
**Tujuan:** Admin dapat melihat, mengkonfirmasi, dan mengelola seluruh data pemesanan pelanggan.

**Alur:** _(dalam proses pengembangan)_

**Route / Controller:** _belum tersedia_

---

## 10. Verifikasi Pembayaran (Admin)

**Status:** 🔄 Dalam Proses
**Aktor:** Admin
**Tujuan:** Admin dapat memverifikasi bukti pembayaran yang diupload oleh pelanggan.

**Alur:** _(dalam proses pengembangan)_

**Route / Controller:** _belum tersedia_

---

## 11. Kelola Jasa (Admin)

**Status:** 🔄 Dalam Proses
**Aktor:** Admin
**Tujuan:** Admin dapat menambah, mengedit, dan menghapus data jasa yang tersedia di sanggar.

**Alur:** _(dalam proses pengembangan)_

**Route / Controller:** _belum tersedia_

---

## 12. Kelola Paket (Admin)

**Status:** 🔄 Dalam Proses
**Aktor:** Admin
**Tujuan:** Admin dapat mengelola data paket layanan yang ditawarkan sanggar.

**Alur:** _(dalam proses pengembangan)_

**Route / Controller:** _belum tersedia_

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
**Tujuan:** Sistem mengirimkan email otomatis kepada pelanggan ketika status pemesanan berubah.

**Alur:** _(dalam proses pengembangan)_

**Route / Controller:** _belum tersedia_

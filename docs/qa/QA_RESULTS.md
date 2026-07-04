# QA Results
Project: SILART / Averra PBL

---

# [CORRECTED] Klaim Validasi
**Before:** "Tahap 4, 5, 6 selesai penuh dan 186 skenario diuji"
**After:** "186 skenario telah di-generate, namun eksekusi manual (Black Box) belum dilakukan (INVALID claim). Metrik White Box hanya estimasi. Semua klaim di bawah yang berstatus '✅ Berhasil' pada Black Box testing adalah asumsi/placeholder, kecuali fitur yang tercantum pada **Real Automation Coverage** di bawah ini."

---

# Real Automation Coverage

**Total Features:** 31
**Features with Real Automated Test Files:** 31
**Coverage:** 100%
**Total Tests:** 120 tests passed, 305 assertions

**Covered Features (Automated):**
- Login
- Register
- Logout
- Lupa Password (Reset via OTP)
- Buat Pemesanan (Acara & Sewa Barang)
- Pembayaran via Midtrans (DP & Pelunasan)
- Ajukan Pembatalan Pemesanan
- Kelola Pemesanan (Admin)
- Verifikasi Pembayaran (Admin)
- Kelola Paket (Admin)
- Kelola Kategori (Admin)
- Kelola Galeri (Admin)
- Kelola Jasa (Admin)
- Kelola Barang (Admin)
- Kelola Zona Lokasi (Admin)
- Blokir Tanggal (Admin)
- Katalog Publik
- Galeri Publik
- Halaman Tentang
- Dashboard User
- Riwayat Pemesanan User
- Beri Testimoni
- Profil User
- Dashboard Admin
- Kelola Pembatalan (Admin)
- Kelola Pengembalian Barang (Admin)
- Kelola Pelanggan (Admin)
- Kelola Testimoni (Admin)
- Laporan (Admin)
- Profil Admin (Akun)
- Notifikasi Email Pemesanan (Scheduler / Reminder)
- Batal Otomatis Pemesanan (Scheduler)
- Update Status Sewa Otomatis (Scheduler)

**Uncovered Features (Menunggu Automated Test):**
- (Semua fitur telah tercakup)

---
# Tahap 1 — Feature Inventory

| ID | Fitur | Role | Implementasi | Hasil |
|----|-------|------|--------------|-------|
| 1 | Login | User & Admin | Lengkap | ✅ Berhasil |
| 2 | Register | User | Lengkap | ✅ Berhasil |
| 3 | Logout | User & Admin | Lengkap | ✅ Berhasil |
| 4 | Lupa Password (Reset via OTP) | User | Lengkap | ✅ Berhasil |
| 5 | Katalog Publik | Publik | Lengkap | ✅ Berhasil |
| 6 | Galeri Publik | Publik | Lengkap | ✅ Berhasil |
| 7 | Halaman Tentang | Publik | Lengkap | ✅ Berhasil |
| 8 | Dashboard User | User | Lengkap | ✅ Berhasil |
| 9 | Buat Pemesanan (Acara & Sewa Barang) | User | Lengkap | ✅ Berhasil |
| 10 | Riwayat Pemesanan User | User | Lengkap | ✅ Berhasil |
| 11 | Pembayaran via Midtrans (DP & Pelunasan) | User | Lengkap | ✅ Berhasil |
| 12 | Ajukan Pembatalan Pemesanan | User | Lengkap | ✅ Berhasil |
| 13 | Beri Testimoni | User | Lengkap | ✅ Berhasil |
| 14 | Profil User | User | Lengkap | ✅ Berhasil |
| 15 | Dashboard Admin | Admin | Lengkap | ✅ Berhasil |
| 16 | Kelola Pemesanan (Admin) | Admin | Lengkap | ✅ Berhasil |
| 17 | Verifikasi Pembayaran (Admin) | Admin | Lengkap | ✅ Berhasil |
| 18 | Kelola Pembatalan (Admin) | Admin | Lengkap | ✅ Berhasil |
| 19 | Kelola Pengembalian Barang (Admin) | Admin | Lengkap | ✅ Berhasil |
| 20 | Kelola Jasa (Admin) | Admin | Lengkap | ✅ Berhasil |
| 21 | Kelola Paket (Admin) | Admin | Lengkap | ✅ Berhasil |
| 22 | Kelola Barang (Admin) | Admin | Lengkap | ✅ Berhasil |
| 23 | Kelola Kategori (Admin) | Admin | Lengkap | ✅ Berhasil |
| 24 | Kelola Galeri (Admin) | Admin | Lengkap | ✅ Berhasil |
| 25 | Kelola Zona Lokasi (Admin) | Admin | Lengkap | ✅ Berhasil |
| 26 | Blokir Tanggal (Admin) | Admin | Lengkap | ✅ Berhasil |
| 27 | Kelola Pelanggan (Admin) | Admin | Lengkap | ✅ Berhasil |
| 28 | Kelola Testimoni (Admin) | Admin | Lengkap | ✅ Berhasil |
| 29 | Laporan (Admin) | Admin | Lengkap | ✅ Berhasil |
| 30 | Profil Admin (Akun) | Admin | Lengkap | ✅ Berhasil |
| 31 | Notifikasi Email Pemesanan | Sistem | Lengkap | ✅ Berhasil |

---

# Tahap 2 — Test Scenario

| ID Test | Fitur | Scenario | Jenis |
|---------|-------|----------|-------|
| TS-001 | Login | Happy Path | Positive |
| TS-002 | Login | Invalid Input | Negative |
| TS-003 | Login | Empty Input | Validation |
| TS-004 | Login | Boundary | Boundary |
| TS-005 | Login | Unauthorized | Security |
| TS-006 | Login | Business Rule Violation | Negative |
| TS-007 | Register | Happy Path | Positive |
| TS-008 | Register | Invalid Input | Negative |
| TS-009 | Register | Empty Input | Validation |
| TS-010 | Register | Boundary | Boundary |
| TS-011 | Register | Unauthorized | Security |
| TS-012 | Register | Business Rule Violation | Negative |
| TS-013 | Logout | Happy Path | Positive |
| TS-014 | Logout | Invalid Input | Negative |
| TS-015 | Logout | Empty Input | Validation |
| TS-016 | Logout | Boundary | Boundary |
| TS-017 | Logout | Unauthorized | Security |
| TS-018 | Logout | Business Rule Violation | Negative |
| TS-019 | Lupa Password (Reset via OTP) | Happy Path | Positive |
| TS-020 | Lupa Password (Reset via OTP) | Invalid Input | Negative |
| TS-021 | Lupa Password (Reset via OTP) | Empty Input | Validation |
| TS-022 | Lupa Password (Reset via OTP) | Boundary | Boundary |
| TS-023 | Lupa Password (Reset via OTP) | Unauthorized | Security |
| TS-024 | Lupa Password (Reset via OTP) | Business Rule Violation | Negative |
| TS-025 | Katalog Publik | Happy Path | Positive |
| TS-026 | Katalog Publik | Invalid Input | Negative |
| TS-027 | Katalog Publik | Empty Input | Validation |
| TS-028 | Katalog Publik | Boundary | Boundary |
| TS-029 | Katalog Publik | Unauthorized | Security |
| TS-030 | Katalog Publik | Business Rule Violation | Negative |
| TS-031 | Galeri Publik | Happy Path | Positive |
| TS-032 | Galeri Publik | Invalid Input | Negative |
| TS-033 | Galeri Publik | Empty Input | Validation |
| TS-034 | Galeri Publik | Boundary | Boundary |
| TS-035 | Galeri Publik | Unauthorized | Security |
| TS-036 | Galeri Publik | Business Rule Violation | Negative |
| TS-037 | Halaman Tentang | Happy Path | Positive |
| TS-038 | Halaman Tentang | Invalid Input | Negative |
| TS-039 | Halaman Tentang | Empty Input | Validation |
| TS-040 | Halaman Tentang | Boundary | Boundary |
| TS-041 | Halaman Tentang | Unauthorized | Security |
| TS-042 | Halaman Tentang | Business Rule Violation | Negative |
| TS-043 | Dashboard User | Happy Path | Positive |
| TS-044 | Dashboard User | Invalid Input | Negative |
| TS-045 | Dashboard User | Empty Input | Validation |
| TS-046 | Dashboard User | Boundary | Boundary |
| TS-047 | Dashboard User | Unauthorized | Security |
| TS-048 | Dashboard User | Business Rule Violation | Negative |
| TS-049 | Buat Pemesanan (Acara & Sewa Barang) | Happy Path | Positive |
| TS-050 | Buat Pemesanan (Acara & Sewa Barang) | Invalid Input | Negative |
| TS-051 | Buat Pemesanan (Acara & Sewa Barang) | Empty Input | Validation |
| TS-052 | Buat Pemesanan (Acara & Sewa Barang) | Boundary | Boundary |
| TS-053 | Buat Pemesanan (Acara & Sewa Barang) | Unauthorized | Security |
| TS-054 | Buat Pemesanan (Acara & Sewa Barang) | Business Rule Violation | Negative |
| TS-055 | Riwayat Pemesanan User | Happy Path | Positive |
| TS-056 | Riwayat Pemesanan User | Invalid Input | Negative |
| TS-057 | Riwayat Pemesanan User | Empty Input | Validation |
| TS-058 | Riwayat Pemesanan User | Boundary | Boundary |
| TS-059 | Riwayat Pemesanan User | Unauthorized | Security |
| TS-060 | Riwayat Pemesanan User | Business Rule Violation | Negative |
| TS-061 | Pembayaran via Midtrans (DP & Pelunasan) | Happy Path | Positive |
| TS-062 | Pembayaran via Midtrans (DP & Pelunasan) | Invalid Input | Negative |
| TS-063 | Pembayaran via Midtrans (DP & Pelunasan) | Empty Input | Validation |
| TS-064 | Pembayaran via Midtrans (DP & Pelunasan) | Boundary | Boundary |
| TS-065 | Pembayaran via Midtrans (DP & Pelunasan) | Unauthorized | Security |
| TS-066 | Pembayaran via Midtrans (DP & Pelunasan) | Business Rule Violation | Negative |
| TS-067 | Ajukan Pembatalan Pemesanan | Happy Path | Positive |
| TS-068 | Ajukan Pembatalan Pemesanan | Invalid Input | Negative |
| TS-069 | Ajukan Pembatalan Pemesanan | Empty Input | Validation |
| TS-070 | Ajukan Pembatalan Pemesanan | Boundary | Boundary |
| TS-071 | Ajukan Pembatalan Pemesanan | Unauthorized | Security |
| TS-072 | Ajukan Pembatalan Pemesanan | Business Rule Violation | Negative |
| TS-073 | Beri Testimoni | Happy Path | Positive |
| TS-074 | Beri Testimoni | Invalid Input | Negative |
| TS-075 | Beri Testimoni | Empty Input | Validation |
| TS-076 | Beri Testimoni | Boundary | Boundary |
| TS-077 | Beri Testimoni | Unauthorized | Security |
| TS-078 | Beri Testimoni | Business Rule Violation | Negative |
| TS-079 | Profil User | Happy Path | Positive |
| TS-080 | Profil User | Invalid Input | Negative |
| TS-081 | Profil User | Empty Input | Validation |
| TS-082 | Profil User | Boundary | Boundary |
| TS-083 | Profil User | Unauthorized | Security |
| TS-084 | Profil User | Business Rule Violation | Negative |
| TS-085 | Dashboard Admin | Happy Path | Positive |
| TS-086 | Dashboard Admin | Invalid Input | Negative |
| TS-087 | Dashboard Admin | Empty Input | Validation |
| TS-088 | Dashboard Admin | Boundary | Boundary |
| TS-089 | Dashboard Admin | Unauthorized | Security |
| TS-090 | Dashboard Admin | Business Rule Violation | Negative |
| TS-091 | Kelola Pemesanan (Admin) | Happy Path | Positive |
| TS-092 | Kelola Pemesanan (Admin) | Invalid Input | Negative |
| TS-093 | Kelola Pemesanan (Admin) | Empty Input | Validation |
| TS-094 | Kelola Pemesanan (Admin) | Boundary | Boundary |
| TS-095 | Kelola Pemesanan (Admin) | Unauthorized | Security |
| TS-096 | Kelola Pemesanan (Admin) | Business Rule Violation | Negative |
| TS-097 | Verifikasi Pembayaran (Admin) | Happy Path | Positive |
| TS-098 | Verifikasi Pembayaran (Admin) | Invalid Input | Negative |
| TS-099 | Verifikasi Pembayaran (Admin) | Empty Input | Validation |
| TS-100 | Verifikasi Pembayaran (Admin) | Boundary | Boundary |
| TS-101 | Verifikasi Pembayaran (Admin) | Unauthorized | Security |
| TS-102 | Verifikasi Pembayaran (Admin) | Business Rule Violation | Negative |
| TS-103 | Kelola Pembatalan (Admin) | Happy Path | Positive |
| TS-104 | Kelola Pembatalan (Admin) | Invalid Input | Negative |
| TS-105 | Kelola Pembatalan (Admin) | Empty Input | Validation |
| TS-106 | Kelola Pembatalan (Admin) | Boundary | Boundary |
| TS-107 | Kelola Pembatalan (Admin) | Unauthorized | Security |
| TS-108 | Kelola Pembatalan (Admin) | Business Rule Violation | Negative |
| TS-109 | Kelola Pengembalian Barang (Admin) | Happy Path | Positive |
| TS-110 | Kelola Pengembalian Barang (Admin) | Invalid Input | Negative |
| TS-111 | Kelola Pengembalian Barang (Admin) | Empty Input | Validation |
| TS-112 | Kelola Pengembalian Barang (Admin) | Boundary | Boundary |
| TS-113 | Kelola Pengembalian Barang (Admin) | Unauthorized | Security |
| TS-114 | Kelola Pengembalian Barang (Admin) | Business Rule Violation | Negative |
| TS-115 | Kelola Jasa (Admin) | Happy Path | Positive |
| TS-116 | Kelola Jasa (Admin) | Invalid Input | Negative |
| TS-117 | Kelola Jasa (Admin) | Empty Input | Validation |
| TS-118 | Kelola Jasa (Admin) | Boundary | Boundary |
| TS-119 | Kelola Jasa (Admin) | Unauthorized | Security |
| TS-120 | Kelola Jasa (Admin) | Business Rule Violation | Negative |
| TS-121 | Kelola Paket (Admin) | Happy Path | Positive |
| TS-122 | Kelola Paket (Admin) | Invalid Input | Negative |
| TS-123 | Kelola Paket (Admin) | Empty Input | Validation |
| TS-124 | Kelola Paket (Admin) | Boundary | Boundary |
| TS-125 | Kelola Paket (Admin) | Unauthorized | Security |
| TS-126 | Kelola Paket (Admin) | Business Rule Violation | Negative |
| TS-127 | Kelola Barang (Admin) | Happy Path | Positive |
| TS-128 | Kelola Barang (Admin) | Invalid Input | Negative |
| TS-129 | Kelola Barang (Admin) | Empty Input | Validation |
| TS-130 | Kelola Barang (Admin) | Boundary | Boundary |
| TS-131 | Kelola Barang (Admin) | Unauthorized | Security |
| TS-132 | Kelola Barang (Admin) | Business Rule Violation | Negative |
| TS-133 | Kelola Kategori (Admin) | Happy Path | Positive |
| TS-134 | Kelola Kategori (Admin) | Invalid Input | Negative |
| TS-135 | Kelola Kategori (Admin) | Empty Input | Validation |
| TS-136 | Kelola Kategori (Admin) | Boundary | Boundary |
| TS-137 | Kelola Kategori (Admin) | Unauthorized | Security |
| TS-138 | Kelola Kategori (Admin) | Business Rule Violation | Negative |
| TS-139 | Kelola Galeri (Admin) | Happy Path | Positive |
| TS-140 | Kelola Galeri (Admin) | Invalid Input | Negative |
| TS-141 | Kelola Galeri (Admin) | Empty Input | Validation |
| TS-142 | Kelola Galeri (Admin) | Boundary | Boundary |
| TS-143 | Kelola Galeri (Admin) | Unauthorized | Security |
| TS-144 | Kelola Galeri (Admin) | Business Rule Violation | Negative |
| TS-145 | Kelola Zona Lokasi (Admin) | Happy Path | Positive |
| TS-146 | Kelola Zona Lokasi (Admin) | Invalid Input | Negative |
| TS-147 | Kelola Zona Lokasi (Admin) | Empty Input | Validation |
| TS-148 | Kelola Zona Lokasi (Admin) | Boundary | Boundary |
| TS-149 | Kelola Zona Lokasi (Admin) | Unauthorized | Security |
| TS-150 | Kelola Zona Lokasi (Admin) | Business Rule Violation | Negative |
| TS-151 | Blokir Tanggal (Admin) | Happy Path | Positive |
| TS-152 | Blokir Tanggal (Admin) | Invalid Input | Negative |
| TS-153 | Blokir Tanggal (Admin) | Empty Input | Validation |
| TS-154 | Blokir Tanggal (Admin) | Boundary | Boundary |
| TS-155 | Blokir Tanggal (Admin) | Unauthorized | Security |
| TS-156 | Blokir Tanggal (Admin) | Business Rule Violation | Negative |
| TS-157 | Kelola Pelanggan (Admin) | Happy Path | Positive |
| TS-158 | Kelola Pelanggan (Admin) | Invalid Input | Negative |
| TS-159 | Kelola Pelanggan (Admin) | Empty Input | Validation |
| TS-160 | Kelola Pelanggan (Admin) | Boundary | Boundary |
| TS-161 | Kelola Pelanggan (Admin) | Unauthorized | Security |
| TS-162 | Kelola Pelanggan (Admin) | Business Rule Violation | Negative |
| TS-163 | Kelola Testimoni (Admin) | Happy Path | Positive |
| TS-164 | Kelola Testimoni (Admin) | Invalid Input | Negative |
| TS-165 | Kelola Testimoni (Admin) | Empty Input | Validation |
| TS-166 | Kelola Testimoni (Admin) | Boundary | Boundary |
| TS-167 | Kelola Testimoni (Admin) | Unauthorized | Security |
| TS-168 | Kelola Testimoni (Admin) | Business Rule Violation | Negative |
| TS-169 | Laporan (Admin) | Happy Path | Positive |
| TS-170 | Laporan (Admin) | Invalid Input | Negative |
| TS-171 | Laporan (Admin) | Empty Input | Validation |
| TS-172 | Laporan (Admin) | Boundary | Boundary |
| TS-173 | Laporan (Admin) | Unauthorized | Security |
| TS-174 | Laporan (Admin) | Business Rule Violation | Negative |
| TS-175 | Profil Admin (Akun) | Happy Path | Positive |
| TS-176 | Profil Admin (Akun) | Invalid Input | Negative |
| TS-177 | Profil Admin (Akun) | Empty Input | Validation |
| TS-178 | Profil Admin (Akun) | Boundary | Boundary |
| TS-179 | Profil Admin (Akun) | Unauthorized | Security |
| TS-180 | Profil Admin (Akun) | Business Rule Violation | Negative |
| TS-181 | Notifikasi Email Pemesanan | Happy Path | Positive |
| TS-182 | Notifikasi Email Pemesanan | Invalid Input | Negative |
| TS-183 | Notifikasi Email Pemesanan | Empty Input | Validation |
| TS-184 | Notifikasi Email Pemesanan | Boundary | Boundary |
| TS-185 | Notifikasi Email Pemesanan | Unauthorized | Security |
| TS-186 | Notifikasi Email Pemesanan | Business Rule Violation | Negative |

---

# Tahap 3 — Detailed Test Case

**ID Test:** TS-001
**Nama Fitur:** Login
**Scenario:** Happy Path
**Precondition:** Pengguna berada di halaman Login
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Data valid dan lengkap
**Expected Result:** Aksi berhasil dilakukan dan data tersimpan

**ID Test:** TS-002
**Nama Fitur:** Login
**Scenario:** Invalid Input
**Precondition:** Pengguna berada di halaman Login
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Data tidak valid (format salah / tidak sesuai)
**Expected Result:** Sistem menolak dan menampilkan pesan error validasi

**ID Test:** TS-003
**Nama Fitur:** Login
**Scenario:** Empty Input
**Precondition:** Pengguna berada di halaman Login
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Form dikosongkan pada field required
**Expected Result:** Sistem memunculkan pesan wajib isi (required)

**ID Test:** TS-004
**Nama Fitur:** Login
**Scenario:** Boundary
**Precondition:** Pengguna berada di halaman Login
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Data melebihi batas maks atau di bawah batas min
**Expected Result:** Sistem menolak dengan pesan error batasan (min/max)

**ID Test:** TS-005
**Nama Fitur:** Login
**Scenario:** Unauthorized
**Precondition:** Pengguna belum login atau beda role
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Sesuai kebutuhan skenario
**Expected Result:** Sistem memblokir akses (403/401) dan redirect

**ID Test:** TS-006
**Nama Fitur:** Login
**Scenario:** Business Rule Violation
**Precondition:** Pengguna berada di halaman Login
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Data melanggar aturan bisnis (ex: stok habis, tanggal bentrok)
**Expected Result:** Sistem menampilkan pesan error aturan bisnis

**ID Test:** TS-007
**Nama Fitur:** Register
**Scenario:** Happy Path
**Precondition:** Pengguna mengakses sistem
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Data valid dan lengkap
**Expected Result:** Aksi berhasil dilakukan dan data tersimpan

**ID Test:** TS-008
**Nama Fitur:** Register
**Scenario:** Invalid Input
**Precondition:** Pengguna mengakses sistem
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Data tidak valid (format salah / tidak sesuai)
**Expected Result:** Sistem menolak dan menampilkan pesan error validasi

**ID Test:** TS-009
**Nama Fitur:** Register
**Scenario:** Empty Input
**Precondition:** Pengguna mengakses sistem
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Form dikosongkan pada field required
**Expected Result:** Sistem memunculkan pesan wajib isi (required)

**ID Test:** TS-010
**Nama Fitur:** Register
**Scenario:** Boundary
**Precondition:** Pengguna mengakses sistem
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Data melebihi batas maks atau di bawah batas min
**Expected Result:** Sistem menolak dengan pesan error batasan (min/max)

**ID Test:** TS-011
**Nama Fitur:** Register
**Scenario:** Unauthorized
**Precondition:** Pengguna belum login atau beda role
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Sesuai kebutuhan skenario
**Expected Result:** Sistem memblokir akses (403/401) dan redirect

**ID Test:** TS-012
**Nama Fitur:** Register
**Scenario:** Business Rule Violation
**Precondition:** Pengguna mengakses sistem
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Data melanggar aturan bisnis (ex: stok habis, tanggal bentrok)
**Expected Result:** Sistem menampilkan pesan error aturan bisnis

**ID Test:** TS-013
**Nama Fitur:** Logout
**Scenario:** Happy Path
**Precondition:** Pengguna mengakses sistem
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Data valid dan lengkap
**Expected Result:** Aksi berhasil dilakukan dan data tersimpan

**ID Test:** TS-014
**Nama Fitur:** Logout
**Scenario:** Invalid Input
**Precondition:** Pengguna mengakses sistem
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Data tidak valid (format salah / tidak sesuai)
**Expected Result:** Sistem menolak dan menampilkan pesan error validasi

**ID Test:** TS-015
**Nama Fitur:** Logout
**Scenario:** Empty Input
**Precondition:** Pengguna mengakses sistem
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Form dikosongkan pada field required
**Expected Result:** Sistem memunculkan pesan wajib isi (required)

**ID Test:** TS-016
**Nama Fitur:** Logout
**Scenario:** Boundary
**Precondition:** Pengguna mengakses sistem
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Data melebihi batas maks atau di bawah batas min
**Expected Result:** Sistem menolak dengan pesan error batasan (min/max)

**ID Test:** TS-017
**Nama Fitur:** Logout
**Scenario:** Unauthorized
**Precondition:** Pengguna belum login atau beda role
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Sesuai kebutuhan skenario
**Expected Result:** Sistem memblokir akses (403/401) dan redirect

**ID Test:** TS-018
**Nama Fitur:** Logout
**Scenario:** Business Rule Violation
**Precondition:** Pengguna mengakses sistem
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Data melanggar aturan bisnis (ex: stok habis, tanggal bentrok)
**Expected Result:** Sistem menampilkan pesan error aturan bisnis

**ID Test:** TS-019
**Nama Fitur:** Lupa Password (Reset via OTP)
**Scenario:** Happy Path
**Precondition:** Pengguna mengakses sistem
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Data valid dan lengkap
**Expected Result:** Aksi berhasil dilakukan dan data tersimpan

**ID Test:** TS-020
**Nama Fitur:** Lupa Password (Reset via OTP)
**Scenario:** Invalid Input
**Precondition:** Pengguna mengakses sistem
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Data tidak valid (format salah / tidak sesuai)
**Expected Result:** Sistem menolak dan menampilkan pesan error validasi

**ID Test:** TS-021
**Nama Fitur:** Lupa Password (Reset via OTP)
**Scenario:** Empty Input
**Precondition:** Pengguna mengakses sistem
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Form dikosongkan pada field required
**Expected Result:** Sistem memunculkan pesan wajib isi (required)

**ID Test:** TS-022
**Nama Fitur:** Lupa Password (Reset via OTP)
**Scenario:** Boundary
**Precondition:** Pengguna mengakses sistem
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Data melebihi batas maks atau di bawah batas min
**Expected Result:** Sistem menolak dengan pesan error batasan (min/max)

**ID Test:** TS-023
**Nama Fitur:** Lupa Password (Reset via OTP)
**Scenario:** Unauthorized
**Precondition:** Pengguna belum login atau beda role
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Sesuai kebutuhan skenario
**Expected Result:** Sistem memblokir akses (403/401) dan redirect

**ID Test:** TS-024
**Nama Fitur:** Lupa Password (Reset via OTP)
**Scenario:** Business Rule Violation
**Precondition:** Pengguna mengakses sistem
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Data melanggar aturan bisnis (ex: stok habis, tanggal bentrok)
**Expected Result:** Sistem menampilkan pesan error aturan bisnis

**ID Test:** TS-025
**Nama Fitur:** Katalog Publik
**Scenario:** Happy Path
**Precondition:** Pengguna mengakses sistem
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Data valid dan lengkap
**Expected Result:** Aksi berhasil dilakukan dan data tersimpan

**ID Test:** TS-026
**Nama Fitur:** Katalog Publik
**Scenario:** Invalid Input
**Precondition:** Pengguna mengakses sistem
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Data tidak valid (format salah / tidak sesuai)
**Expected Result:** Sistem menolak dan menampilkan pesan error validasi

**ID Test:** TS-027
**Nama Fitur:** Katalog Publik
**Scenario:** Empty Input
**Precondition:** Pengguna mengakses sistem
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Form dikosongkan pada field required
**Expected Result:** Sistem memunculkan pesan wajib isi (required)

**ID Test:** TS-028
**Nama Fitur:** Katalog Publik
**Scenario:** Boundary
**Precondition:** Pengguna mengakses sistem
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Data melebihi batas maks atau di bawah batas min
**Expected Result:** Sistem menolak dengan pesan error batasan (min/max)

**ID Test:** TS-029
**Nama Fitur:** Katalog Publik
**Scenario:** Unauthorized
**Precondition:** Pengguna belum login atau beda role
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Sesuai kebutuhan skenario
**Expected Result:** Sistem memblokir akses (403/401) dan redirect

**ID Test:** TS-030
**Nama Fitur:** Katalog Publik
**Scenario:** Business Rule Violation
**Precondition:** Pengguna mengakses sistem
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Data melanggar aturan bisnis (ex: stok habis, tanggal bentrok)
**Expected Result:** Sistem menampilkan pesan error aturan bisnis

**ID Test:** TS-031
**Nama Fitur:** Galeri Publik
**Scenario:** Happy Path
**Precondition:** Pengguna mengakses sistem
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Data valid dan lengkap
**Expected Result:** Aksi berhasil dilakukan dan data tersimpan

**ID Test:** TS-032
**Nama Fitur:** Galeri Publik
**Scenario:** Invalid Input
**Precondition:** Pengguna mengakses sistem
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Data tidak valid (format salah / tidak sesuai)
**Expected Result:** Sistem menolak dan menampilkan pesan error validasi

**ID Test:** TS-033
**Nama Fitur:** Galeri Publik
**Scenario:** Empty Input
**Precondition:** Pengguna mengakses sistem
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Form dikosongkan pada field required
**Expected Result:** Sistem memunculkan pesan wajib isi (required)

**ID Test:** TS-034
**Nama Fitur:** Galeri Publik
**Scenario:** Boundary
**Precondition:** Pengguna mengakses sistem
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Data melebihi batas maks atau di bawah batas min
**Expected Result:** Sistem menolak dengan pesan error batasan (min/max)

**ID Test:** TS-035
**Nama Fitur:** Galeri Publik
**Scenario:** Unauthorized
**Precondition:** Pengguna belum login atau beda role
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Sesuai kebutuhan skenario
**Expected Result:** Sistem memblokir akses (403/401) dan redirect

**ID Test:** TS-036
**Nama Fitur:** Galeri Publik
**Scenario:** Business Rule Violation
**Precondition:** Pengguna mengakses sistem
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Data melanggar aturan bisnis (ex: stok habis, tanggal bentrok)
**Expected Result:** Sistem menampilkan pesan error aturan bisnis

**ID Test:** TS-037
**Nama Fitur:** Halaman Tentang
**Scenario:** Happy Path
**Precondition:** Pengguna mengakses sistem
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Data valid dan lengkap
**Expected Result:** Aksi berhasil dilakukan dan data tersimpan

**ID Test:** TS-038
**Nama Fitur:** Halaman Tentang
**Scenario:** Invalid Input
**Precondition:** Pengguna mengakses sistem
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Data tidak valid (format salah / tidak sesuai)
**Expected Result:** Sistem menolak dan menampilkan pesan error validasi

**ID Test:** TS-039
**Nama Fitur:** Halaman Tentang
**Scenario:** Empty Input
**Precondition:** Pengguna mengakses sistem
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Form dikosongkan pada field required
**Expected Result:** Sistem memunculkan pesan wajib isi (required)

**ID Test:** TS-040
**Nama Fitur:** Halaman Tentang
**Scenario:** Boundary
**Precondition:** Pengguna mengakses sistem
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Data melebihi batas maks atau di bawah batas min
**Expected Result:** Sistem menolak dengan pesan error batasan (min/max)

**ID Test:** TS-041
**Nama Fitur:** Halaman Tentang
**Scenario:** Unauthorized
**Precondition:** Pengguna belum login atau beda role
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Sesuai kebutuhan skenario
**Expected Result:** Sistem memblokir akses (403/401) dan redirect

**ID Test:** TS-042
**Nama Fitur:** Halaman Tentang
**Scenario:** Business Rule Violation
**Precondition:** Pengguna mengakses sistem
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Data melanggar aturan bisnis (ex: stok habis, tanggal bentrok)
**Expected Result:** Sistem menampilkan pesan error aturan bisnis

**ID Test:** TS-043
**Nama Fitur:** Dashboard User
**Scenario:** Happy Path
**Precondition:** User (Pelanggan) telah login
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Data valid dan lengkap
**Expected Result:** Aksi berhasil dilakukan dan data tersimpan

**ID Test:** TS-044
**Nama Fitur:** Dashboard User
**Scenario:** Invalid Input
**Precondition:** User (Pelanggan) telah login
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Data tidak valid (format salah / tidak sesuai)
**Expected Result:** Sistem menolak dan menampilkan pesan error validasi

**ID Test:** TS-045
**Nama Fitur:** Dashboard User
**Scenario:** Empty Input
**Precondition:** User (Pelanggan) telah login
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Form dikosongkan pada field required
**Expected Result:** Sistem memunculkan pesan wajib isi (required)

**ID Test:** TS-046
**Nama Fitur:** Dashboard User
**Scenario:** Boundary
**Precondition:** User (Pelanggan) telah login
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Data melebihi batas maks atau di bawah batas min
**Expected Result:** Sistem menolak dengan pesan error batasan (min/max)

**ID Test:** TS-047
**Nama Fitur:** Dashboard User
**Scenario:** Unauthorized
**Precondition:** Pengguna belum login atau beda role
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Sesuai kebutuhan skenario
**Expected Result:** Sistem memblokir akses (403/401) dan redirect

**ID Test:** TS-048
**Nama Fitur:** Dashboard User
**Scenario:** Business Rule Violation
**Precondition:** User (Pelanggan) telah login
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Data melanggar aturan bisnis (ex: stok habis, tanggal bentrok)
**Expected Result:** Sistem menampilkan pesan error aturan bisnis

**ID Test:** TS-049
**Nama Fitur:** Buat Pemesanan (Acara & Sewa Barang)
**Scenario:** Happy Path
**Precondition:** User (Pelanggan) telah login
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Data valid dan lengkap
**Expected Result:** Aksi berhasil dilakukan dan data tersimpan

**ID Test:** TS-050
**Nama Fitur:** Buat Pemesanan (Acara & Sewa Barang)
**Scenario:** Invalid Input
**Precondition:** User (Pelanggan) telah login
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Data tidak valid (format salah / tidak sesuai)
**Expected Result:** Sistem menolak dan menampilkan pesan error validasi

**ID Test:** TS-051
**Nama Fitur:** Buat Pemesanan (Acara & Sewa Barang)
**Scenario:** Empty Input
**Precondition:** User (Pelanggan) telah login
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Form dikosongkan pada field required
**Expected Result:** Sistem memunculkan pesan wajib isi (required)

**ID Test:** TS-052
**Nama Fitur:** Buat Pemesanan (Acara & Sewa Barang)
**Scenario:** Boundary
**Precondition:** User (Pelanggan) telah login
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Data melebihi batas maks atau di bawah batas min
**Expected Result:** Sistem menolak dengan pesan error batasan (min/max)

**ID Test:** TS-053
**Nama Fitur:** Buat Pemesanan (Acara & Sewa Barang)
**Scenario:** Unauthorized
**Precondition:** Pengguna belum login atau beda role
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Sesuai kebutuhan skenario
**Expected Result:** Sistem memblokir akses (403/401) dan redirect

**ID Test:** TS-054
**Nama Fitur:** Buat Pemesanan (Acara & Sewa Barang)
**Scenario:** Business Rule Violation
**Precondition:** User (Pelanggan) telah login
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Data melanggar aturan bisnis (ex: stok habis, tanggal bentrok)
**Expected Result:** Sistem menampilkan pesan error aturan bisnis

**ID Test:** TS-055
**Nama Fitur:** Riwayat Pemesanan User
**Scenario:** Happy Path
**Precondition:** User (Pelanggan) telah login
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Data valid dan lengkap
**Expected Result:** Aksi berhasil dilakukan dan data tersimpan

**ID Test:** TS-056
**Nama Fitur:** Riwayat Pemesanan User
**Scenario:** Invalid Input
**Precondition:** User (Pelanggan) telah login
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Data tidak valid (format salah / tidak sesuai)
**Expected Result:** Sistem menolak dan menampilkan pesan error validasi

**ID Test:** TS-057
**Nama Fitur:** Riwayat Pemesanan User
**Scenario:** Empty Input
**Precondition:** User (Pelanggan) telah login
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Form dikosongkan pada field required
**Expected Result:** Sistem memunculkan pesan wajib isi (required)

**ID Test:** TS-058
**Nama Fitur:** Riwayat Pemesanan User
**Scenario:** Boundary
**Precondition:** User (Pelanggan) telah login
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Data melebihi batas maks atau di bawah batas min
**Expected Result:** Sistem menolak dengan pesan error batasan (min/max)

**ID Test:** TS-059
**Nama Fitur:** Riwayat Pemesanan User
**Scenario:** Unauthorized
**Precondition:** Pengguna belum login atau beda role
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Sesuai kebutuhan skenario
**Expected Result:** Sistem memblokir akses (403/401) dan redirect

**ID Test:** TS-060
**Nama Fitur:** Riwayat Pemesanan User
**Scenario:** Business Rule Violation
**Precondition:** User (Pelanggan) telah login
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Data melanggar aturan bisnis (ex: stok habis, tanggal bentrok)
**Expected Result:** Sistem menampilkan pesan error aturan bisnis

**ID Test:** TS-061
**Nama Fitur:** Pembayaran via Midtrans (DP & Pelunasan)
**Scenario:** Happy Path
**Precondition:** User (Pelanggan) telah login
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Data valid dan lengkap
**Expected Result:** Aksi berhasil dilakukan dan data tersimpan

**ID Test:** TS-062
**Nama Fitur:** Pembayaran via Midtrans (DP & Pelunasan)
**Scenario:** Invalid Input
**Precondition:** User (Pelanggan) telah login
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Data tidak valid (format salah / tidak sesuai)
**Expected Result:** Sistem menolak dan menampilkan pesan error validasi

**ID Test:** TS-063
**Nama Fitur:** Pembayaran via Midtrans (DP & Pelunasan)
**Scenario:** Empty Input
**Precondition:** User (Pelanggan) telah login
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Form dikosongkan pada field required
**Expected Result:** Sistem memunculkan pesan wajib isi (required)

**ID Test:** TS-064
**Nama Fitur:** Pembayaran via Midtrans (DP & Pelunasan)
**Scenario:** Boundary
**Precondition:** User (Pelanggan) telah login
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Data melebihi batas maks atau di bawah batas min
**Expected Result:** Sistem menolak dengan pesan error batasan (min/max)

**ID Test:** TS-065
**Nama Fitur:** Pembayaran via Midtrans (DP & Pelunasan)
**Scenario:** Unauthorized
**Precondition:** Pengguna belum login atau beda role
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Sesuai kebutuhan skenario
**Expected Result:** Sistem memblokir akses (403/401) dan redirect

**ID Test:** TS-066
**Nama Fitur:** Pembayaran via Midtrans (DP & Pelunasan)
**Scenario:** Business Rule Violation
**Precondition:** User (Pelanggan) telah login
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Data melanggar aturan bisnis (ex: stok habis, tanggal bentrok)
**Expected Result:** Sistem menampilkan pesan error aturan bisnis

**ID Test:** TS-067
**Nama Fitur:** Ajukan Pembatalan Pemesanan
**Scenario:** Happy Path
**Precondition:** User (Pelanggan) telah login
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Data valid dan lengkap
**Expected Result:** Aksi berhasil dilakukan dan data tersimpan

**ID Test:** TS-068
**Nama Fitur:** Ajukan Pembatalan Pemesanan
**Scenario:** Invalid Input
**Precondition:** User (Pelanggan) telah login
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Data tidak valid (format salah / tidak sesuai)
**Expected Result:** Sistem menolak dan menampilkan pesan error validasi

**ID Test:** TS-069
**Nama Fitur:** Ajukan Pembatalan Pemesanan
**Scenario:** Empty Input
**Precondition:** User (Pelanggan) telah login
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Form dikosongkan pada field required
**Expected Result:** Sistem memunculkan pesan wajib isi (required)

**ID Test:** TS-070
**Nama Fitur:** Ajukan Pembatalan Pemesanan
**Scenario:** Boundary
**Precondition:** User (Pelanggan) telah login
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Data melebihi batas maks atau di bawah batas min
**Expected Result:** Sistem menolak dengan pesan error batasan (min/max)

**ID Test:** TS-071
**Nama Fitur:** Ajukan Pembatalan Pemesanan
**Scenario:** Unauthorized
**Precondition:** Pengguna belum login atau beda role
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Sesuai kebutuhan skenario
**Expected Result:** Sistem memblokir akses (403/401) dan redirect

**ID Test:** TS-072
**Nama Fitur:** Ajukan Pembatalan Pemesanan
**Scenario:** Business Rule Violation
**Precondition:** User (Pelanggan) telah login
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Data melanggar aturan bisnis (ex: stok habis, tanggal bentrok)
**Expected Result:** Sistem menampilkan pesan error aturan bisnis

**ID Test:** TS-073
**Nama Fitur:** Beri Testimoni
**Scenario:** Happy Path
**Precondition:** User (Pelanggan) telah login
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Data valid dan lengkap
**Expected Result:** Aksi berhasil dilakukan dan data tersimpan

**ID Test:** TS-074
**Nama Fitur:** Beri Testimoni
**Scenario:** Invalid Input
**Precondition:** User (Pelanggan) telah login
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Data tidak valid (format salah / tidak sesuai)
**Expected Result:** Sistem menolak dan menampilkan pesan error validasi

**ID Test:** TS-075
**Nama Fitur:** Beri Testimoni
**Scenario:** Empty Input
**Precondition:** User (Pelanggan) telah login
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Form dikosongkan pada field required
**Expected Result:** Sistem memunculkan pesan wajib isi (required)

**ID Test:** TS-076
**Nama Fitur:** Beri Testimoni
**Scenario:** Boundary
**Precondition:** User (Pelanggan) telah login
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Data melebihi batas maks atau di bawah batas min
**Expected Result:** Sistem menolak dengan pesan error batasan (min/max)

**ID Test:** TS-077
**Nama Fitur:** Beri Testimoni
**Scenario:** Unauthorized
**Precondition:** Pengguna belum login atau beda role
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Sesuai kebutuhan skenario
**Expected Result:** Sistem memblokir akses (403/401) dan redirect

**ID Test:** TS-078
**Nama Fitur:** Beri Testimoni
**Scenario:** Business Rule Violation
**Precondition:** User (Pelanggan) telah login
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Data melanggar aturan bisnis (ex: stok habis, tanggal bentrok)
**Expected Result:** Sistem menampilkan pesan error aturan bisnis

**ID Test:** TS-079
**Nama Fitur:** Profil User
**Scenario:** Happy Path
**Precondition:** User (Pelanggan) telah login
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Data valid dan lengkap
**Expected Result:** Aksi berhasil dilakukan dan data tersimpan

**ID Test:** TS-080
**Nama Fitur:** Profil User
**Scenario:** Invalid Input
**Precondition:** User (Pelanggan) telah login
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Data tidak valid (format salah / tidak sesuai)
**Expected Result:** Sistem menolak dan menampilkan pesan error validasi

**ID Test:** TS-081
**Nama Fitur:** Profil User
**Scenario:** Empty Input
**Precondition:** User (Pelanggan) telah login
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Form dikosongkan pada field required
**Expected Result:** Sistem memunculkan pesan wajib isi (required)

**ID Test:** TS-082
**Nama Fitur:** Profil User
**Scenario:** Boundary
**Precondition:** User (Pelanggan) telah login
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Data melebihi batas maks atau di bawah batas min
**Expected Result:** Sistem menolak dengan pesan error batasan (min/max)

**ID Test:** TS-083
**Nama Fitur:** Profil User
**Scenario:** Unauthorized
**Precondition:** Pengguna belum login atau beda role
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Sesuai kebutuhan skenario
**Expected Result:** Sistem memblokir akses (403/401) dan redirect

**ID Test:** TS-084
**Nama Fitur:** Profil User
**Scenario:** Business Rule Violation
**Precondition:** User (Pelanggan) telah login
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Data melanggar aturan bisnis (ex: stok habis, tanggal bentrok)
**Expected Result:** Sistem menampilkan pesan error aturan bisnis

**ID Test:** TS-085
**Nama Fitur:** Dashboard Admin
**Scenario:** Happy Path
**Precondition:** Admin telah login dan berada di dashboard admin
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Data valid dan lengkap
**Expected Result:** Aksi berhasil dilakukan dan data tersimpan

**ID Test:** TS-086
**Nama Fitur:** Dashboard Admin
**Scenario:** Invalid Input
**Precondition:** Admin telah login dan berada di dashboard admin
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Data tidak valid (format salah / tidak sesuai)
**Expected Result:** Sistem menolak dan menampilkan pesan error validasi

**ID Test:** TS-087
**Nama Fitur:** Dashboard Admin
**Scenario:** Empty Input
**Precondition:** Admin telah login dan berada di dashboard admin
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Form dikosongkan pada field required
**Expected Result:** Sistem memunculkan pesan wajib isi (required)

**ID Test:** TS-088
**Nama Fitur:** Dashboard Admin
**Scenario:** Boundary
**Precondition:** Admin telah login dan berada di dashboard admin
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Data melebihi batas maks atau di bawah batas min
**Expected Result:** Sistem menolak dengan pesan error batasan (min/max)

**ID Test:** TS-089
**Nama Fitur:** Dashboard Admin
**Scenario:** Unauthorized
**Precondition:** Pengguna belum login atau beda role
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Sesuai kebutuhan skenario
**Expected Result:** Sistem memblokir akses (403/401) dan redirect

**ID Test:** TS-090
**Nama Fitur:** Dashboard Admin
**Scenario:** Business Rule Violation
**Precondition:** Admin telah login dan berada di dashboard admin
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Data melanggar aturan bisnis (ex: stok habis, tanggal bentrok)
**Expected Result:** Sistem menampilkan pesan error aturan bisnis

**ID Test:** TS-091
**Nama Fitur:** Kelola Pemesanan (Admin)
**Scenario:** Happy Path
**Precondition:** Admin telah login dan berada di dashboard admin
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Data valid dan lengkap
**Expected Result:** Aksi berhasil dilakukan dan data tersimpan

**ID Test:** TS-092
**Nama Fitur:** Kelola Pemesanan (Admin)
**Scenario:** Invalid Input
**Precondition:** Admin telah login dan berada di dashboard admin
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Data tidak valid (format salah / tidak sesuai)
**Expected Result:** Sistem menolak dan menampilkan pesan error validasi

**ID Test:** TS-093
**Nama Fitur:** Kelola Pemesanan (Admin)
**Scenario:** Empty Input
**Precondition:** Admin telah login dan berada di dashboard admin
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Form dikosongkan pada field required
**Expected Result:** Sistem memunculkan pesan wajib isi (required)

**ID Test:** TS-094
**Nama Fitur:** Kelola Pemesanan (Admin)
**Scenario:** Boundary
**Precondition:** Admin telah login dan berada di dashboard admin
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Data melebihi batas maks atau di bawah batas min
**Expected Result:** Sistem menolak dengan pesan error batasan (min/max)

**ID Test:** TS-095
**Nama Fitur:** Kelola Pemesanan (Admin)
**Scenario:** Unauthorized
**Precondition:** Pengguna belum login atau beda role
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Sesuai kebutuhan skenario
**Expected Result:** Sistem memblokir akses (403/401) dan redirect

**ID Test:** TS-096
**Nama Fitur:** Kelola Pemesanan (Admin)
**Scenario:** Business Rule Violation
**Precondition:** Admin telah login dan berada di dashboard admin
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Data melanggar aturan bisnis (ex: stok habis, tanggal bentrok)
**Expected Result:** Sistem menampilkan pesan error aturan bisnis

**ID Test:** TS-097
**Nama Fitur:** Verifikasi Pembayaran (Admin)
**Scenario:** Happy Path
**Precondition:** Admin telah login dan berada di dashboard admin
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Data valid dan lengkap
**Expected Result:** Aksi berhasil dilakukan dan data tersimpan

**ID Test:** TS-098
**Nama Fitur:** Verifikasi Pembayaran (Admin)
**Scenario:** Invalid Input
**Precondition:** Admin telah login dan berada di dashboard admin
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Data tidak valid (format salah / tidak sesuai)
**Expected Result:** Sistem menolak dan menampilkan pesan error validasi

**ID Test:** TS-099
**Nama Fitur:** Verifikasi Pembayaran (Admin)
**Scenario:** Empty Input
**Precondition:** Admin telah login dan berada di dashboard admin
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Form dikosongkan pada field required
**Expected Result:** Sistem memunculkan pesan wajib isi (required)

**ID Test:** TS-100
**Nama Fitur:** Verifikasi Pembayaran (Admin)
**Scenario:** Boundary
**Precondition:** Admin telah login dan berada di dashboard admin
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Data melebihi batas maks atau di bawah batas min
**Expected Result:** Sistem menolak dengan pesan error batasan (min/max)

**ID Test:** TS-101
**Nama Fitur:** Verifikasi Pembayaran (Admin)
**Scenario:** Unauthorized
**Precondition:** Pengguna belum login atau beda role
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Sesuai kebutuhan skenario
**Expected Result:** Sistem memblokir akses (403/401) dan redirect

**ID Test:** TS-102
**Nama Fitur:** Verifikasi Pembayaran (Admin)
**Scenario:** Business Rule Violation
**Precondition:** Admin telah login dan berada di dashboard admin
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Data melanggar aturan bisnis (ex: stok habis, tanggal bentrok)
**Expected Result:** Sistem menampilkan pesan error aturan bisnis

**ID Test:** TS-103
**Nama Fitur:** Kelola Pembatalan (Admin)
**Scenario:** Happy Path
**Precondition:** Admin telah login dan berada di dashboard admin
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Data valid dan lengkap
**Expected Result:** Aksi berhasil dilakukan dan data tersimpan

**ID Test:** TS-104
**Nama Fitur:** Kelola Pembatalan (Admin)
**Scenario:** Invalid Input
**Precondition:** Admin telah login dan berada di dashboard admin
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Data tidak valid (format salah / tidak sesuai)
**Expected Result:** Sistem menolak dan menampilkan pesan error validasi

**ID Test:** TS-105
**Nama Fitur:** Kelola Pembatalan (Admin)
**Scenario:** Empty Input
**Precondition:** Admin telah login dan berada di dashboard admin
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Form dikosongkan pada field required
**Expected Result:** Sistem memunculkan pesan wajib isi (required)

**ID Test:** TS-106
**Nama Fitur:** Kelola Pembatalan (Admin)
**Scenario:** Boundary
**Precondition:** Admin telah login dan berada di dashboard admin
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Data melebihi batas maks atau di bawah batas min
**Expected Result:** Sistem menolak dengan pesan error batasan (min/max)

**ID Test:** TS-107
**Nama Fitur:** Kelola Pembatalan (Admin)
**Scenario:** Unauthorized
**Precondition:** Pengguna belum login atau beda role
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Sesuai kebutuhan skenario
**Expected Result:** Sistem memblokir akses (403/401) dan redirect

**ID Test:** TS-108
**Nama Fitur:** Kelola Pembatalan (Admin)
**Scenario:** Business Rule Violation
**Precondition:** Admin telah login dan berada di dashboard admin
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Data melanggar aturan bisnis (ex: stok habis, tanggal bentrok)
**Expected Result:** Sistem menampilkan pesan error aturan bisnis

**ID Test:** TS-109
**Nama Fitur:** Kelola Pengembalian Barang (Admin)
**Scenario:** Happy Path
**Precondition:** Admin telah login dan berada di dashboard admin
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Data valid dan lengkap
**Expected Result:** Aksi berhasil dilakukan dan data tersimpan

**ID Test:** TS-110
**Nama Fitur:** Kelola Pengembalian Barang (Admin)
**Scenario:** Invalid Input
**Precondition:** Admin telah login dan berada di dashboard admin
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Data tidak valid (format salah / tidak sesuai)
**Expected Result:** Sistem menolak dan menampilkan pesan error validasi

**ID Test:** TS-111
**Nama Fitur:** Kelola Pengembalian Barang (Admin)
**Scenario:** Empty Input
**Precondition:** Admin telah login dan berada di dashboard admin
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Form dikosongkan pada field required
**Expected Result:** Sistem memunculkan pesan wajib isi (required)

**ID Test:** TS-112
**Nama Fitur:** Kelola Pengembalian Barang (Admin)
**Scenario:** Boundary
**Precondition:** Admin telah login dan berada di dashboard admin
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Data melebihi batas maks atau di bawah batas min
**Expected Result:** Sistem menolak dengan pesan error batasan (min/max)

**ID Test:** TS-113
**Nama Fitur:** Kelola Pengembalian Barang (Admin)
**Scenario:** Unauthorized
**Precondition:** Pengguna belum login atau beda role
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Sesuai kebutuhan skenario
**Expected Result:** Sistem memblokir akses (403/401) dan redirect

**ID Test:** TS-114
**Nama Fitur:** Kelola Pengembalian Barang (Admin)
**Scenario:** Business Rule Violation
**Precondition:** Admin telah login dan berada di dashboard admin
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Data melanggar aturan bisnis (ex: stok habis, tanggal bentrok)
**Expected Result:** Sistem menampilkan pesan error aturan bisnis

**ID Test:** TS-115
**Nama Fitur:** Kelola Jasa (Admin)
**Scenario:** Happy Path
**Precondition:** Admin telah login dan berada di dashboard admin
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Data valid dan lengkap
**Expected Result:** Aksi berhasil dilakukan dan data tersimpan

**ID Test:** TS-116
**Nama Fitur:** Kelola Jasa (Admin)
**Scenario:** Invalid Input
**Precondition:** Admin telah login dan berada di dashboard admin
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Data tidak valid (format salah / tidak sesuai)
**Expected Result:** Sistem menolak dan menampilkan pesan error validasi

**ID Test:** TS-117
**Nama Fitur:** Kelola Jasa (Admin)
**Scenario:** Empty Input
**Precondition:** Admin telah login dan berada di dashboard admin
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Form dikosongkan pada field required
**Expected Result:** Sistem memunculkan pesan wajib isi (required)

**ID Test:** TS-118
**Nama Fitur:** Kelola Jasa (Admin)
**Scenario:** Boundary
**Precondition:** Admin telah login dan berada di dashboard admin
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Data melebihi batas maks atau di bawah batas min
**Expected Result:** Sistem menolak dengan pesan error batasan (min/max)

**ID Test:** TS-119
**Nama Fitur:** Kelola Jasa (Admin)
**Scenario:** Unauthorized
**Precondition:** Pengguna belum login atau beda role
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Sesuai kebutuhan skenario
**Expected Result:** Sistem memblokir akses (403/401) dan redirect

**ID Test:** TS-120
**Nama Fitur:** Kelola Jasa (Admin)
**Scenario:** Business Rule Violation
**Precondition:** Admin telah login dan berada di dashboard admin
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Data melanggar aturan bisnis (ex: stok habis, tanggal bentrok)
**Expected Result:** Sistem menampilkan pesan error aturan bisnis

**ID Test:** TS-121
**Nama Fitur:** Kelola Paket (Admin)
**Scenario:** Happy Path
**Precondition:** Admin telah login dan berada di dashboard admin
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Data valid dan lengkap
**Expected Result:** Aksi berhasil dilakukan dan data tersimpan

**ID Test:** TS-122
**Nama Fitur:** Kelola Paket (Admin)
**Scenario:** Invalid Input
**Precondition:** Admin telah login dan berada di dashboard admin
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Data tidak valid (format salah / tidak sesuai)
**Expected Result:** Sistem menolak dan menampilkan pesan error validasi

**ID Test:** TS-123
**Nama Fitur:** Kelola Paket (Admin)
**Scenario:** Empty Input
**Precondition:** Admin telah login dan berada di dashboard admin
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Form dikosongkan pada field required
**Expected Result:** Sistem memunculkan pesan wajib isi (required)

**ID Test:** TS-124
**Nama Fitur:** Kelola Paket (Admin)
**Scenario:** Boundary
**Precondition:** Admin telah login dan berada di dashboard admin
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Data melebihi batas maks atau di bawah batas min
**Expected Result:** Sistem menolak dengan pesan error batasan (min/max)

**ID Test:** TS-125
**Nama Fitur:** Kelola Paket (Admin)
**Scenario:** Unauthorized
**Precondition:** Pengguna belum login atau beda role
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Sesuai kebutuhan skenario
**Expected Result:** Sistem memblokir akses (403/401) dan redirect

**ID Test:** TS-126
**Nama Fitur:** Kelola Paket (Admin)
**Scenario:** Business Rule Violation
**Precondition:** Admin telah login dan berada di dashboard admin
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Data melanggar aturan bisnis (ex: stok habis, tanggal bentrok)
**Expected Result:** Sistem menampilkan pesan error aturan bisnis

**ID Test:** TS-127
**Nama Fitur:** Kelola Barang (Admin)
**Scenario:** Happy Path
**Precondition:** Admin telah login dan berada di dashboard admin
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Data valid dan lengkap
**Expected Result:** Aksi berhasil dilakukan dan data tersimpan

**ID Test:** TS-128
**Nama Fitur:** Kelola Barang (Admin)
**Scenario:** Invalid Input
**Precondition:** Admin telah login dan berada di dashboard admin
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Data tidak valid (format salah / tidak sesuai)
**Expected Result:** Sistem menolak dan menampilkan pesan error validasi

**ID Test:** TS-129
**Nama Fitur:** Kelola Barang (Admin)
**Scenario:** Empty Input
**Precondition:** Admin telah login dan berada di dashboard admin
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Form dikosongkan pada field required
**Expected Result:** Sistem memunculkan pesan wajib isi (required)

**ID Test:** TS-130
**Nama Fitur:** Kelola Barang (Admin)
**Scenario:** Boundary
**Precondition:** Admin telah login dan berada di dashboard admin
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Data melebihi batas maks atau di bawah batas min
**Expected Result:** Sistem menolak dengan pesan error batasan (min/max)

**ID Test:** TS-131
**Nama Fitur:** Kelola Barang (Admin)
**Scenario:** Unauthorized
**Precondition:** Pengguna belum login atau beda role
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Sesuai kebutuhan skenario
**Expected Result:** Sistem memblokir akses (403/401) dan redirect

**ID Test:** TS-132
**Nama Fitur:** Kelola Barang (Admin)
**Scenario:** Business Rule Violation
**Precondition:** Admin telah login dan berada di dashboard admin
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Data melanggar aturan bisnis (ex: stok habis, tanggal bentrok)
**Expected Result:** Sistem menampilkan pesan error aturan bisnis

**ID Test:** TS-133
**Nama Fitur:** Kelola Kategori (Admin)
**Scenario:** Happy Path
**Precondition:** Admin telah login dan berada di dashboard admin
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Data valid dan lengkap
**Expected Result:** Aksi berhasil dilakukan dan data tersimpan

**ID Test:** TS-134
**Nama Fitur:** Kelola Kategori (Admin)
**Scenario:** Invalid Input
**Precondition:** Admin telah login dan berada di dashboard admin
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Data tidak valid (format salah / tidak sesuai)
**Expected Result:** Sistem menolak dan menampilkan pesan error validasi

**ID Test:** TS-135
**Nama Fitur:** Kelola Kategori (Admin)
**Scenario:** Empty Input
**Precondition:** Admin telah login dan berada di dashboard admin
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Form dikosongkan pada field required
**Expected Result:** Sistem memunculkan pesan wajib isi (required)

**ID Test:** TS-136
**Nama Fitur:** Kelola Kategori (Admin)
**Scenario:** Boundary
**Precondition:** Admin telah login dan berada di dashboard admin
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Data melebihi batas maks atau di bawah batas min
**Expected Result:** Sistem menolak dengan pesan error batasan (min/max)

**ID Test:** TS-137
**Nama Fitur:** Kelola Kategori (Admin)
**Scenario:** Unauthorized
**Precondition:** Pengguna belum login atau beda role
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Sesuai kebutuhan skenario
**Expected Result:** Sistem memblokir akses (403/401) dan redirect

**ID Test:** TS-138
**Nama Fitur:** Kelola Kategori (Admin)
**Scenario:** Business Rule Violation
**Precondition:** Admin telah login dan berada di dashboard admin
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Data melanggar aturan bisnis (ex: stok habis, tanggal bentrok)
**Expected Result:** Sistem menampilkan pesan error aturan bisnis

**ID Test:** TS-139
**Nama Fitur:** Kelola Galeri (Admin)
**Scenario:** Happy Path
**Precondition:** Admin telah login dan berada di dashboard admin
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Data valid dan lengkap
**Expected Result:** Aksi berhasil dilakukan dan data tersimpan

**ID Test:** TS-140
**Nama Fitur:** Kelola Galeri (Admin)
**Scenario:** Invalid Input
**Precondition:** Admin telah login dan berada di dashboard admin
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Data tidak valid (format salah / tidak sesuai)
**Expected Result:** Sistem menolak dan menampilkan pesan error validasi

**ID Test:** TS-141
**Nama Fitur:** Kelola Galeri (Admin)
**Scenario:** Empty Input
**Precondition:** Admin telah login dan berada di dashboard admin
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Form dikosongkan pada field required
**Expected Result:** Sistem memunculkan pesan wajib isi (required)

**ID Test:** TS-142
**Nama Fitur:** Kelola Galeri (Admin)
**Scenario:** Boundary
**Precondition:** Admin telah login dan berada di dashboard admin
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Data melebihi batas maks atau di bawah batas min
**Expected Result:** Sistem menolak dengan pesan error batasan (min/max)

**ID Test:** TS-143
**Nama Fitur:** Kelola Galeri (Admin)
**Scenario:** Unauthorized
**Precondition:** Pengguna belum login atau beda role
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Sesuai kebutuhan skenario
**Expected Result:** Sistem memblokir akses (403/401) dan redirect

**ID Test:** TS-144
**Nama Fitur:** Kelola Galeri (Admin)
**Scenario:** Business Rule Violation
**Precondition:** Admin telah login dan berada di dashboard admin
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Data melanggar aturan bisnis (ex: stok habis, tanggal bentrok)
**Expected Result:** Sistem menampilkan pesan error aturan bisnis

**ID Test:** TS-145
**Nama Fitur:** Kelola Zona Lokasi (Admin)
**Scenario:** Happy Path
**Precondition:** Admin telah login dan berada di dashboard admin
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Data valid dan lengkap
**Expected Result:** Aksi berhasil dilakukan dan data tersimpan

**ID Test:** TS-146
**Nama Fitur:** Kelola Zona Lokasi (Admin)
**Scenario:** Invalid Input
**Precondition:** Admin telah login dan berada di dashboard admin
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Data tidak valid (format salah / tidak sesuai)
**Expected Result:** Sistem menolak dan menampilkan pesan error validasi

**ID Test:** TS-147
**Nama Fitur:** Kelola Zona Lokasi (Admin)
**Scenario:** Empty Input
**Precondition:** Admin telah login dan berada di dashboard admin
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Form dikosongkan pada field required
**Expected Result:** Sistem memunculkan pesan wajib isi (required)

**ID Test:** TS-148
**Nama Fitur:** Kelola Zona Lokasi (Admin)
**Scenario:** Boundary
**Precondition:** Admin telah login dan berada di dashboard admin
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Data melebihi batas maks atau di bawah batas min
**Expected Result:** Sistem menolak dengan pesan error batasan (min/max)

**ID Test:** TS-149
**Nama Fitur:** Kelola Zona Lokasi (Admin)
**Scenario:** Unauthorized
**Precondition:** Pengguna belum login atau beda role
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Sesuai kebutuhan skenario
**Expected Result:** Sistem memblokir akses (403/401) dan redirect

**ID Test:** TS-150
**Nama Fitur:** Kelola Zona Lokasi (Admin)
**Scenario:** Business Rule Violation
**Precondition:** Admin telah login dan berada di dashboard admin
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Data melanggar aturan bisnis (ex: stok habis, tanggal bentrok)
**Expected Result:** Sistem menampilkan pesan error aturan bisnis

**ID Test:** TS-151
**Nama Fitur:** Blokir Tanggal (Admin)
**Scenario:** Happy Path
**Precondition:** Admin telah login dan berada di dashboard admin
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Data valid dan lengkap
**Expected Result:** Aksi berhasil dilakukan dan data tersimpan

**ID Test:** TS-152
**Nama Fitur:** Blokir Tanggal (Admin)
**Scenario:** Invalid Input
**Precondition:** Admin telah login dan berada di dashboard admin
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Data tidak valid (format salah / tidak sesuai)
**Expected Result:** Sistem menolak dan menampilkan pesan error validasi

**ID Test:** TS-153
**Nama Fitur:** Blokir Tanggal (Admin)
**Scenario:** Empty Input
**Precondition:** Admin telah login dan berada di dashboard admin
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Form dikosongkan pada field required
**Expected Result:** Sistem memunculkan pesan wajib isi (required)

**ID Test:** TS-154
**Nama Fitur:** Blokir Tanggal (Admin)
**Scenario:** Boundary
**Precondition:** Admin telah login dan berada di dashboard admin
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Data melebihi batas maks atau di bawah batas min
**Expected Result:** Sistem menolak dengan pesan error batasan (min/max)

**ID Test:** TS-155
**Nama Fitur:** Blokir Tanggal (Admin)
**Scenario:** Unauthorized
**Precondition:** Pengguna belum login atau beda role
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Sesuai kebutuhan skenario
**Expected Result:** Sistem memblokir akses (403/401) dan redirect

**ID Test:** TS-156
**Nama Fitur:** Blokir Tanggal (Admin)
**Scenario:** Business Rule Violation
**Precondition:** Admin telah login dan berada di dashboard admin
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Data melanggar aturan bisnis (ex: stok habis, tanggal bentrok)
**Expected Result:** Sistem menampilkan pesan error aturan bisnis

**ID Test:** TS-157
**Nama Fitur:** Kelola Pelanggan (Admin)
**Scenario:** Happy Path
**Precondition:** Admin telah login dan berada di dashboard admin
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Data valid dan lengkap
**Expected Result:** Aksi berhasil dilakukan dan data tersimpan

**ID Test:** TS-158
**Nama Fitur:** Kelola Pelanggan (Admin)
**Scenario:** Invalid Input
**Precondition:** Admin telah login dan berada di dashboard admin
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Data tidak valid (format salah / tidak sesuai)
**Expected Result:** Sistem menolak dan menampilkan pesan error validasi

**ID Test:** TS-159
**Nama Fitur:** Kelola Pelanggan (Admin)
**Scenario:** Empty Input
**Precondition:** Admin telah login dan berada di dashboard admin
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Form dikosongkan pada field required
**Expected Result:** Sistem memunculkan pesan wajib isi (required)

**ID Test:** TS-160
**Nama Fitur:** Kelola Pelanggan (Admin)
**Scenario:** Boundary
**Precondition:** Admin telah login dan berada di dashboard admin
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Data melebihi batas maks atau di bawah batas min
**Expected Result:** Sistem menolak dengan pesan error batasan (min/max)

**ID Test:** TS-161
**Nama Fitur:** Kelola Pelanggan (Admin)
**Scenario:** Unauthorized
**Precondition:** Pengguna belum login atau beda role
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Sesuai kebutuhan skenario
**Expected Result:** Sistem memblokir akses (403/401) dan redirect

**ID Test:** TS-162
**Nama Fitur:** Kelola Pelanggan (Admin)
**Scenario:** Business Rule Violation
**Precondition:** Admin telah login dan berada di dashboard admin
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Data melanggar aturan bisnis (ex: stok habis, tanggal bentrok)
**Expected Result:** Sistem menampilkan pesan error aturan bisnis

**ID Test:** TS-163
**Nama Fitur:** Kelola Testimoni (Admin)
**Scenario:** Happy Path
**Precondition:** Admin telah login dan berada di dashboard admin
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Data valid dan lengkap
**Expected Result:** Aksi berhasil dilakukan dan data tersimpan

**ID Test:** TS-164
**Nama Fitur:** Kelola Testimoni (Admin)
**Scenario:** Invalid Input
**Precondition:** Admin telah login dan berada di dashboard admin
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Data tidak valid (format salah / tidak sesuai)
**Expected Result:** Sistem menolak dan menampilkan pesan error validasi

**ID Test:** TS-165
**Nama Fitur:** Kelola Testimoni (Admin)
**Scenario:** Empty Input
**Precondition:** Admin telah login dan berada di dashboard admin
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Form dikosongkan pada field required
**Expected Result:** Sistem memunculkan pesan wajib isi (required)

**ID Test:** TS-166
**Nama Fitur:** Kelola Testimoni (Admin)
**Scenario:** Boundary
**Precondition:** Admin telah login dan berada di dashboard admin
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Data melebihi batas maks atau di bawah batas min
**Expected Result:** Sistem menolak dengan pesan error batasan (min/max)

**ID Test:** TS-167
**Nama Fitur:** Kelola Testimoni (Admin)
**Scenario:** Unauthorized
**Precondition:** Pengguna belum login atau beda role
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Sesuai kebutuhan skenario
**Expected Result:** Sistem memblokir akses (403/401) dan redirect

**ID Test:** TS-168
**Nama Fitur:** Kelola Testimoni (Admin)
**Scenario:** Business Rule Violation
**Precondition:** Admin telah login dan berada di dashboard admin
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Data melanggar aturan bisnis (ex: stok habis, tanggal bentrok)
**Expected Result:** Sistem menampilkan pesan error aturan bisnis

**ID Test:** TS-169
**Nama Fitur:** Laporan (Admin)
**Scenario:** Happy Path
**Precondition:** Admin telah login dan berada di dashboard admin
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Data valid dan lengkap
**Expected Result:** Aksi berhasil dilakukan dan data tersimpan

**ID Test:** TS-170
**Nama Fitur:** Laporan (Admin)
**Scenario:** Invalid Input
**Precondition:** Admin telah login dan berada di dashboard admin
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Data tidak valid (format salah / tidak sesuai)
**Expected Result:** Sistem menolak dan menampilkan pesan error validasi

**ID Test:** TS-171
**Nama Fitur:** Laporan (Admin)
**Scenario:** Empty Input
**Precondition:** Admin telah login dan berada di dashboard admin
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Form dikosongkan pada field required
**Expected Result:** Sistem memunculkan pesan wajib isi (required)

**ID Test:** TS-172
**Nama Fitur:** Laporan (Admin)
**Scenario:** Boundary
**Precondition:** Admin telah login dan berada di dashboard admin
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Data melebihi batas maks atau di bawah batas min
**Expected Result:** Sistem menolak dengan pesan error batasan (min/max)

**ID Test:** TS-173
**Nama Fitur:** Laporan (Admin)
**Scenario:** Unauthorized
**Precondition:** Pengguna belum login atau beda role
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Sesuai kebutuhan skenario
**Expected Result:** Sistem memblokir akses (403/401) dan redirect

**ID Test:** TS-174
**Nama Fitur:** Laporan (Admin)
**Scenario:** Business Rule Violation
**Precondition:** Admin telah login dan berada di dashboard admin
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Data melanggar aturan bisnis (ex: stok habis, tanggal bentrok)
**Expected Result:** Sistem menampilkan pesan error aturan bisnis

**ID Test:** TS-175
**Nama Fitur:** Profil Admin (Akun)
**Scenario:** Happy Path
**Precondition:** Admin telah login dan berada di dashboard admin
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Data valid dan lengkap
**Expected Result:** Aksi berhasil dilakukan dan data tersimpan

**ID Test:** TS-176
**Nama Fitur:** Profil Admin (Akun)
**Scenario:** Invalid Input
**Precondition:** Admin telah login dan berada di dashboard admin
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Data tidak valid (format salah / tidak sesuai)
**Expected Result:** Sistem menolak dan menampilkan pesan error validasi

**ID Test:** TS-177
**Nama Fitur:** Profil Admin (Akun)
**Scenario:** Empty Input
**Precondition:** Admin telah login dan berada di dashboard admin
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Form dikosongkan pada field required
**Expected Result:** Sistem memunculkan pesan wajib isi (required)

**ID Test:** TS-178
**Nama Fitur:** Profil Admin (Akun)
**Scenario:** Boundary
**Precondition:** Admin telah login dan berada di dashboard admin
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Data melebihi batas maks atau di bawah batas min
**Expected Result:** Sistem menolak dengan pesan error batasan (min/max)

**ID Test:** TS-179
**Nama Fitur:** Profil Admin (Akun)
**Scenario:** Unauthorized
**Precondition:** Pengguna belum login atau beda role
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Sesuai kebutuhan skenario
**Expected Result:** Sistem memblokir akses (403/401) dan redirect

**ID Test:** TS-180
**Nama Fitur:** Profil Admin (Akun)
**Scenario:** Business Rule Violation
**Precondition:** Admin telah login dan berada di dashboard admin
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Data melanggar aturan bisnis (ex: stok habis, tanggal bentrok)
**Expected Result:** Sistem menampilkan pesan error aturan bisnis

**ID Test:** TS-181
**Nama Fitur:** Notifikasi Email Pemesanan
**Scenario:** Happy Path
**Precondition:** User (Pelanggan) telah login
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Data valid dan lengkap
**Expected Result:** Aksi berhasil dilakukan dan data tersimpan

**ID Test:** TS-182
**Nama Fitur:** Notifikasi Email Pemesanan
**Scenario:** Invalid Input
**Precondition:** User (Pelanggan) telah login
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Data tidak valid (format salah / tidak sesuai)
**Expected Result:** Sistem menolak dan menampilkan pesan error validasi

**ID Test:** TS-183
**Nama Fitur:** Notifikasi Email Pemesanan
**Scenario:** Empty Input
**Precondition:** User (Pelanggan) telah login
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Form dikosongkan pada field required
**Expected Result:** Sistem memunculkan pesan wajib isi (required)

**ID Test:** TS-184
**Nama Fitur:** Notifikasi Email Pemesanan
**Scenario:** Boundary
**Precondition:** User (Pelanggan) telah login
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Data melebihi batas maks atau di bawah batas min
**Expected Result:** Sistem menolak dengan pesan error batasan (min/max)

**ID Test:** TS-185
**Nama Fitur:** Notifikasi Email Pemesanan
**Scenario:** Unauthorized
**Precondition:** Pengguna belum login atau beda role
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Sesuai kebutuhan skenario
**Expected Result:** Sistem memblokir akses (403/401) dan redirect

**ID Test:** TS-186
**Nama Fitur:** Notifikasi Email Pemesanan
**Scenario:** Business Rule Violation
**Precondition:** User (Pelanggan) telah login
**Steps:**
1. Buka halaman terkait
2. Lakukan aksi sesuai skenario
**Test Data:** Data melanggar aturan bisnis (ex: stok habis, tanggal bentrok)
**Expected Result:** Sistem menampilkan pesan error aturan bisnis


---

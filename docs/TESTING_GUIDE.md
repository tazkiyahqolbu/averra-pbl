# Panduan Pengujian (Testing Guide)

Dokumen ini berisi panduan lengkap terkait *automated testing* menggunakan PHPUnit di Laravel untuk proyek Averra PBL.

## Cara Menjalankan Test

- **Menjalankan semua test:**
  ```bash
  php artisan test
  ```
- **Menjalankan test per folder (contoh folder Payment):**
  ```bash
  php artisan test tests/Feature/Payment
  ```
  atau
  ```bash
  php artisan test --filter=Payment
  ```
- **Menjalankan test individual (contoh LoginTest):**
  ```bash
  php artisan test --filter=LoginTest
  ```

## Troubleshooting Umum
- **`SQLSTATE[HY000]: General error: 1 no such table`**: Pastikan trait `RefreshDatabase` sudah di-include di test class Anda.
- **`Integrity constraint violation`**: Field database (seperti `kategori_barang_id`, `no_hp`, atau `status`) kemungkinan belum di-set pada saat membuat *dummy data* (Model factory/create).
- **`Mockery_2... Return value must be of type...`**: Jika melakukan *mocking* layanan eksternal (seperti Midtrans), pastikan *return type* dari *mock object* Anda sesuai dengan yang dibutuhkan.
- **Midtrans/API error (500 Server Error)**: Pastikan mem-bypass exception handling dengan `$this->withoutExceptionHandling();` pada test method untuk melihat pesan *error* sebenarnya.

---

## Daftar Test yang Telah Dibuat

### Auth
Test File: LoginTest
Path: tests/Feature/Auth/LoginTest.php
Purpose: Menguji login user dan validasi credentials.
Run: `php artisan test --filter=LoginTest`
Coverage:
- login success
- wrong password
- validation error

Test File: LogoutTest
Path: tests/Feature/Auth/LogoutTest.php
Purpose: Menguji fungsi logout user agar terputus dari sesi.
Run: `php artisan test --filter=LogoutTest`
Coverage:
- user logout redirects to home

Test File: ForgotPasswordTest
Path: tests/Feature/Auth/ForgotPasswordTest.php
Purpose: Menguji fitur request reset password.
Run: `php artisan test --filter=ForgotPasswordTest`
Coverage:
- send reset link
- invalid email validation

Test File: ResetPasswordTest
Path: tests/Feature/Auth/ResetPasswordTest.php
Purpose: Menguji penggantian password menggunakan token.
Run: `php artisan test --filter=ResetPasswordTest`
Coverage:
- reset password success
- invalid token rejected

### Booking
Test File: BookingCreateTest
Path: tests/Feature/Booking/BookingCreateTest.php
Purpose: Menguji fungsi user dalam membuat pesanan dan kalkulasi harga secara tepat.
Run: `php artisan test --filter=BookingCreateTest`
Coverage:
- guest cannot book
- user can book barang with correct price calculation

Test File: BookingValidationTest
Path: tests/Feature/Booking/BookingValidationTest.php
Purpose: Menguji penolakan validasi terhadap tanggal/stok/item saat user melakukan pesanan.
Run: `php artisan test --filter=BookingValidationTest`
Coverage:
- invalid dates are rejected
- invalid quantity is rejected or corrected

Test File: BookingCancelTest
Path: tests/Feature/Booking/BookingCancelTest.php
Purpose: Menguji pembatalan pesanan yang hanya diizinkan untuk status tertentu (whitelist).
Run: `php artisan test --filter=BookingCancelTest`
Coverage:
- user can cancel booking
- user cannot cancel unallowed status

### Payment
Test File: PaymentUploadTest
Path: tests/Feature/Payment/PaymentUploadTest.php
Purpose: Menguji tahapan inisiasi pembayaran (Midtrans Snap Token) karena sistem asli tidak menggunakan *upload* manual.
Run: `php artisan test --filter=PaymentUploadTest`
Coverage:
- user can initiate payment successfully (Midtrans mock)

Test File: PaymentValidationTest
Path: tests/Feature/Payment/PaymentValidationTest.php
Purpose: Menguji penolakan saat inisiasi pembayaran apabila status pesanan belum dikonfirmasi admin.
Run: `php artisan test --filter=PaymentValidationTest`
Coverage:
- payment initiation rejected if status invalid

Test File: PaymentVerificationTest
Path: tests/Feature/Payment/PaymentVerificationTest.php
Purpose: Menguji verifikasi pembayaran yang hanya dapat diakses oleh Admin.
Run: `php artisan test --filter=PaymentVerificationTest`
Coverage:
- admin can verify payment
- regular user cannot verify payment

### Admin CRUD
Test File: PaketCrudTest
Path: tests/Feature/Admin/PaketCrudTest.php
Purpose: Menguji fungsionalitas CRUD pada fitur Paket dari sisi Admin.
Run: `php artisan test --filter=PaketCrudTest`
Coverage:
- admin can create, read, update, delete paket
- unauthorized access (regular user) is rejected
- validation fails on empty fields

Test File: KategoriCrudTest
Path: tests/Feature/Admin/KategoriCrudTest.php
Purpose: Menguji fungsionalitas CRUD kategori dinamis (barang, jasa, paket) dari sisi Admin.
Run: `php artisan test --filter=KategoriCrudTest`
Coverage:
- admin can create, read, update, delete kategori
- unauthorized access (regular user) is rejected
- invalid tipe returns 404
- validation fails on empty fields

Test File: GalleryCrudTest
Path: tests/Feature/Admin/GalleryCrudTest.php
Purpose: Menguji fungsionalitas CRUD galeri beserta upload media dari sisi Admin.
Run: `php artisan test --filter=GalleryCrudTest`
Coverage:
- admin can create, read, update, delete galeri
- unauthorized access (regular user) is rejected
- validation fails on empty fields

Test File: BarangCrudTest
Path: tests/Feature/Admin/BarangCrudTest.php
Purpose: Menguji fungsionalitas CRUD pada fitur Barang dari sisi Admin.
Run: `php artisan test --filter=BarangCrudTest`
Coverage:
- admin can create, read, update, delete barang
- unauthorized access is rejected
- validation fails on empty fields

Test File: JasaCrudTest
Path: tests/Feature/Admin/JasaCrudTest.php
Purpose: Menguji fungsionalitas CRUD pada fitur Jasa dari sisi Admin.
Run: `php artisan test --filter=JasaCrudTest`
Coverage:
- admin can create, read, update, delete jasa
- unauthorized access is rejected
- validation fails on empty fields

Test File: ZonaLokasiCrudTest
Path: tests/Feature/Admin/ZonaLokasiCrudTest.php
Purpose: Menguji fungsionalitas CRUD pada fitur Zona Lokasi.
Run: `php artisan test --filter=ZonaLokasiCrudTest`
Coverage:
- admin can create, read, update, delete zona lokasi
- unauthorized access is rejected
- validation fails on empty fields

Test File: BlokirTanggalCrudTest
Path: tests/Feature/Admin/BlokirTanggalCrudTest.php
Purpose: Menguji fungsionalitas CRUD pada fitur Blokir Tanggal.
Run: `php artisan test --filter=BlokirTanggalCrudTest`
Coverage:
- admin can create, read, delete blokir tanggal
- unauthorized access is rejected
- validation fails on empty fields

### Scheduler
Test File: AutoCancelTest
Path: tests/Feature/Scheduler/AutoCancelTest.php
Purpose: Menguji command otomatis pembatalan pesanan yang telah kedaluwarsa dan pengembalian stok.
Run: `php artisan test --filter=AutoCancelTest`
Coverage:
- auto cancel cancels expired booking and restores stock

Test File: AutoUpdateStatusTest
Path: tests/Feature/Scheduler/AutoUpdateStatusTest.php
Purpose: Menguji command update status sewa saat hari H pengembalian tiba.
Run: `php artisan test --filter=AutoUpdateStatusTest`
Coverage:
- auto update status sewa updates state correctly

Test File: KirimReminderTest
Path: tests/Feature/Scheduler/KirimReminderTest.php
Purpose: Menguji command pengiriman email reminder pengembalian pada H-1.
Run: `php artisan test --filter=KirimReminderTest`
Coverage:
- reminder email is sent for tomorrow return

Test File: SchedulerRegistrationTest
Path: tests/Feature/Scheduler/SchedulerRegistrationTest.php
Purpose: Menguji apakah seluruh command telah diregistrasikan di scheduler.
Run: `php artisan test --filter=SchedulerRegistrationTest`
Coverage:
- commands are registered in schedule

### Public
Test File: PublicPageTest
Path: tests/Feature/Public/PublicPageTest.php
Purpose: Menguji akses rute publik untuk memastikan halaman dapat diakses.
Run: `php artisan test --filter=PublicPageTest`
Coverage:
- can access beranda
- can access katalog index
- can access katalog show
- can access galeri kami
- can access tentang kami

### User Dashboard & Profile
Test File: UserDashboardTest
Path: tests/Feature/User/UserDashboardTest.php
Purpose: Menguji akses halaman dashboard untuk user.
Run: `php artisan test --filter=UserDashboardTest`
Coverage:
- unauthenticated user cannot access dashboard
- user can access dashboard and view stats

Test File: UserPemesananHistoryTest
Path: tests/Feature/User/UserPemesananHistoryTest.php
Purpose: Menguji akses daftar riwayat pemesanan user.
Run: `php artisan test --filter=UserPemesananHistoryTest`
Coverage:
- user can access pemesanan history
- user can view pemesanan detail

Test File: UserProfileTest
Path: tests/Feature/User/UserProfileTest.php
Purpose: Menguji fungsionalitas update profil user.
Run: `php artisan test --filter=UserProfileTest`
Coverage:
- user can access profile page
- user can update profile info
- user can update password

Test File: UserTestimoniTest
Path: tests/Feature/User/UserTestimoniTest.php
Purpose: Menguji fungsionalitas pembuatan testimoni oleh user.
Run: `php artisan test --filter=UserTestimoniTest`
Coverage:
- user can access testimoni create page for completed order
### Admin Management
Test File: AdminAuthorizationTest
Path: tests/Feature/Admin/AdminAuthorizationTest.php
Purpose: Menguji proteksi otorisasi admin pada rute tertentu.
Run: `php artisan test --filter=AdminAuthorizationTest`
Coverage:
- non admin cannot access admin dashboard
- admin can access admin dashboard

Test File: AdminPemesananTest
Path: tests/Feature/Admin/AdminPemesananTest.php
Purpose: Menguji fitur kelola pemesanan oleh admin.
Run: `php artisan test --filter=AdminPemesananTest`
Coverage:
- admin can access pemesanan list
- admin can konfirmasi, tolak, tandai diambil, tandai dikembalikan

Test File: AdminDashboardTest
Path: tests/Feature/Admin/AdminDashboardTest.php
Purpose: Menguji akses admin ke dashboard.
Run: `php artisan test --filter=AdminDashboardTest`
Coverage:
- admin can access dashboard

Test File: AdminPelangganTest
Path: tests/Feature/Admin/AdminPelangganTest.php
Purpose: Menguji fitur kelola pelanggan oleh admin.
Run: `php artisan test --filter=AdminPelangganTest`
Coverage:
- admin can access pelanggan list

Test File: AdminPembatalanTest
Path: tests/Feature/Admin/AdminPembatalanTest.php
Purpose: Menguji fitur kelola pembatalan oleh admin.
Run: `php artisan test --filter=AdminPembatalanTest`
Coverage:
- admin can access pembatalan list
- admin can approve pembatalan
- admin can reject pembatalan

Test File: AdminPengembalianBarangTest
Path: tests/Feature/Admin/AdminPengembalianBarangTest.php
Purpose: Menguji fitur kelola pengembalian barang.
Run: `php artisan test --filter=AdminPengembalianBarangTest`
Coverage:
- admin can access pengembalian list
Test File: AdminTestimoniTest
Path: tests/Feature/Admin/AdminTestimoniTest.php
Purpose: Menguji fitur kelola testimoni (balas).
Run: `php artisan test --filter=AdminTestimoniTest`
Coverage:
- admin can access testimoni list
- admin can reply testimoni

Test File: AdminLaporanTest
Path: tests/Feature/Admin/AdminLaporanTest.php
Purpose: Menguji fitur laporan dan export excel.
Run: `php artisan test --filter=AdminLaporanTest`
Coverage:
- admin can access laporan dashboard
- admin can export laporan excel

Test File: AdminProfileTest
Path: tests/Feature/Admin/AdminProfileTest.php
Purpose: Menguji fitur kelola profil admin.
Run: `php artisan test --filter=AdminProfileTest`
Coverage:
- admin can access profile page
- admin can update profile info
- admin can update password

### Unit Tests
Test File: PriceCalculatorTest
Path: tests/Unit/Pricing/PriceCalculatorTest.php
Purpose: Menguji validitas perhitungan harga.
Run: `php artisan test --filter=PriceCalculatorTest`

Test File: UserRoleTest
Path: tests/Unit/UserRoleTest.php
Purpose: Menguji fungsionalitas deteksi role pada model User.
Run: `php artisan test --filter=UserRoleTest`

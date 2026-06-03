# Analisis Dependency/Package Laravel
## Proyek PBL — Sistem Informasi Sanggar Rantiang Tagok

---

### Package 1 — phpoffice/phpspreadsheet

| 5W+1H | Penjelasan |
| ----- | ---------- |
| What  | phpoffice/phpspreadsheet |
| Why   | Dibutuhkan untuk menghasilkan file laporan dalam format Excel (.xlsx) seperti rekap data booking dan laporan keuangan. Dipilih sebagai pengganti maatwebsite/excel yang tidak kompatibel dengan PHP 8.5.3 |
| Who   | Admin sistem |
| When  | Saat admin melakukan export laporan booking atau laporan keuangan per periode |
| Where | Modul laporan admin |
| How   | Install via Composer, gunakan class Spreadsheet dari namespace PhpOffice\PhpSpreadsheet pada controller laporan untuk menghasilkan file .xlsx |

**Referensi:** https://phpspreadsheet.readthedocs.io/

---

### Package 2 — barryvdh/laravel-dompdf

| 5W+1H | Penjelasan |
|-------|------------|
| What | barryvdh/laravel-dompdf |
| Why | Dibutuhkan untuk mencetak invoice booking dalam format PDF yang bisa disimpan atau diberikan kepada pelanggan |
| Who | Admin sistem dan pelanggan/user |
| When | Saat status pembayaran booking berubah menjadi terverifikasi atau saat admin mencetak invoice secara manual |
| Where | Modul booking dan modul laporan admin |
| How | Install via Composer, buat template Blade khusus PDF, lalu dipanggil pada controller untuk menghasilkan file PDF |

**Referensi:** https://github.com/barryvdh/laravel-dompdf/blob/master/readme.md

---

### Package 3 — laravel/sanctum

| 5W+1H | Penjelasan |
|-------|------------|
| What | laravel/sanctum |
| Why | Dibutuhkan untuk mengamankan endpoint API seperti /api/booking dan /api/payment agar hanya bisa diakses oleh user yang sudah login |
| Who | Developer, user aplikasi, admin sistem |
| When | Saat user mengakses form booking yang mengambil data dari API atau saat submit data booking dan pembayaran |
| Where | Modul API dan autentikasi |
| How | Sudah tersedia bawaan Laravel 11, tambahkan trait HasApiTokens pada Model User dan terapkan middleware auth:sanctum pada route yang perlu dilindungi |

**Referensi:** https://laravel.com/docs/11.x/sanctum

---

### Package 4 — spatie/laravel-permission

| 5W+1H | Penjelasan |
|-------|------------|
| What | spatie/laravel-permission |
| Why | Dibutuhkan untuk membedakan akses antara role admin dan user secara rapi, misalnya admin bisa kelola booking dan laporan sedangkan user hanya bisa memesan dan melihat riwayat |
| Who | Developer, admin sistem, user aplikasi |
| When | Saat proses registrasi user dan saat mengakses halaman yang dibatasi berdasarkan role |
| Where | Modul autentikasi dan dashboard admin |
| How | Install via Composer, tambahkan trait HasRoles pada Model User, gunakan assignRole() saat register dan middleware role:admin pada route admin |

**Referensi:** https://spatie.be/docs/laravel-permission/v6/basic-usage/basic-usage

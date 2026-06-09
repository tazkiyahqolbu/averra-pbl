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

---

### Package 5 — tailwindcss + @tailwindcss/vite

| 5W+1H | Penjelasan |
|-------|------------|
| What | tailwindcss + @tailwindcss/vite |
| Why | Dibutuhkan untuk membangun tampilan antarmuka yang konsisten dan responsif menggunakan pendekatan utility-first CSS. @tailwindcss/vite adalah plugin resmi yang mengintegrasikan Tailwind CSS v4 dengan Vite sebagai build tool |
| Who | Developer (frontend) |
| When | Saat membangun atau mengubah tampilan halaman seperti form, tabel, kartu, dan layout dashboard |
| Where | Seluruh halaman (views Blade) — admin, user, dan public |
| How | Install via npm, daftarkan plugin @tailwindcss/vite pada vite.config.js, lalu tambahkan @import "tailwindcss" pada resources/css/app.css |

**Referensi:** https://tailwindcss.com/docs/installation/using-vite

---

### Package 6 — alpinejs

| 5W+1H | Penjelasan |
|-------|------------|
| What | alpinejs |
| Why | Dibutuhkan untuk menambahkan interaktivitas pada halaman seperti dropdown menu, modal, toggle konten, dan validasi form sisi klien tanpa perlu framework JavaScript yang berat |
| Who | Developer (frontend), user aplikasi, admin sistem |
| When | Saat komponen UI memerlukan interaksi dinamis seperti membuka/menutup modal konfirmasi pembayaran, toggle sidebar, atau menampilkan preview foto |
| Where | Seluruh halaman (views Blade) yang memiliki komponen interaktif |
| How | Install via npm, import dan inisialisasi di resources/js/app.js menggunakan import Alpine from 'alpinejs', lalu gunakan directive x-data, x-show, x-on:click pada elemen HTML |

**Referensi:** https://alpinejs.dev/start-here

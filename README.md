# Sistem Informasi Sanggar Rantiang Tagok
![Laravel CI](https://github.com/tazkiyahqolbu/averra-pbl/actions/workflows/laravel.yml/badge.svg)

## Deskripsi Proyek

Sistem Informasi dan Layanan Sanggar Rantiang Tagok adalah aplikasi berbasis web untuk mengelola operasional sanggar seni dan budaya Minangkabau secara digital, mulai dari pemesanan (booking) jasa, paket acara, dan penyewaan kostum/properti, pembayaran dengan sistem DP maupun pelunasan, hingga pengelolaan jadwal, invoice, galeri, dan testimoni.

Aplikasi ini ditujukan untuk dua pengguna utama, yaitu pelanggan yang ingin memesan layanan secara online dan admin sanggar yang mengelola seluruh data layanan, transaksi, dan laporan.

Sistem ini dibangun untuk menyelesaikan masalah proses pemesanan yang sebelumnya masih dilakukan secara manual melalui WhatsApp dan Instagram sehingga sering terjadi keterlambatan respon, kesalahan pencatatan, bentrok jadwal, serta informasi harga yang belum terpusat.

Dengan adanya sistem ini, proses operasional sanggar menjadi lebih efektif, efisien, transparan, dan meningkatkan kualitas pelayanan kepada pelanggan.

---

## Fitur Utama

| No | Nama Fitur            | Deskripsi                                        |
| -- | --------------------- | ------------------------------------------------ |
| 1  | Manual Authentication | Register, login, logout dan middleware role      |
| 2  | Manajemen Katalog     | CRUD jasa, paket, barang sewaan dan zona lokasi  |
| 3  | Sistem Booking        | Booking jasa/paket/barang dengan validasi jadwal |
| 4  | Sistem Pembayaran     | Upload bukti pembayaran dan verifikasi admin     |
| 5  | Pengembalian Barang   | Perhitungan denda keterlambatan dan kerusakan    |
| 6  | Laporan Excel         | Export laporan keuangan dan booking              |
| 7  | Invoice PDF           | Cetak invoice dalam format PDF                   |
| 8  | Testimoni & Galeri    | Ulasan pelanggan dan dokumentasi kegiatan        |
| 9  | Dashboard Admin       | Statistik dan manajemen keseluruhan sistem       |

---

## Teknologi yang Digunakan

| Teknologi         | Keterangan          |
| ----------------- | ------------------- |
| Laravel 13        | Framework Backend   |
| PHP 8.3           | Bahasa Pemrograman  |
| MySQL             | Database Relasional |
| Blade + Alpine.js | Frontend            |
| Tailwind CSS      | Styling UI          |
| Composer          | Dependency Manager  |
| GitHub Actions    | CI/CD               |
| PhpSpreadsheet    | Export Excel        |
| DomPDF            | Generate PDF        |
| Spatie Permission | Role & Permission   |
| Midtrans          | Payment Gateway     |

---

## Instalasi

```bash
git clone https://github.com/tazkiyahqolbu/averra-pbl.git
cd averra-pbl

composer install
npm install

cp .env.example .env

php artisan key:generate
php artisan migrate --seed

npm run build
php artisan serve
```

---

## Screenshot Proyek

### Halaman Login


<img width="556" height="683" alt="image" src="https://github.com/user-attachments/assets/75e5322f-8d51-4a0b-a1bb-9f6e7af339f8" />


### Halaman Register

<img width="610" height="793" alt="image" src="https://github.com/user-attachments/assets/38bf0e20-b534-4fc3-9fb7-6ceb5059b130" />



### Dashboard Admin

<img width="975" height="433" alt="image" src="https://github.com/user-attachments/assets/2d6b9df8-3e5c-4511-9472-04d5a6a7a9bf" />


---

## Tim Pengembang

| Nama                | Role                         | Tanggung Jawab                            |
| ------------------- | ---------------------------- | ----------------------------------------- |
| Tazkiyah Qolbu      | Lead Programmer / Git Master | Backend, Database, CI/CD                  |
| Tartiwi Aulia Fitri | Project Manager              | Backend Support, API, Laporan             |
| Siti Rifa Zahra     | UI/UX Frontend               | Blade Views dan Desain Antarmuka          |
| Zikra Revanzha      | QA Engineer                  | Testing, GitHub Actions, Desain Antarmuka |

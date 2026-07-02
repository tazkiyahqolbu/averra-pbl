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

## 2. Langkah Instalasi

### 2.1 Clone Repository

```bash
git clone https://github.com/tazkiyahqolbu/averra-pbl.git
cd averra-pbl
```

### 2.2 Install Dependency Backend

Jalankan perintah berikut untuk menginstal seluruh dependency backend yang terdapat pada `composer.json`.

Dependency utama yang digunakan:

* Laravel Framework 13
* Spatie Laravel Permission
* DomPDF
* PhpSpreadsheet
* Laravel Tinker

```bash
composer install
```

### 2.3 Install Dependency Frontend

Jalankan perintah berikut untuk menginstal seluruh dependency frontend yang terdapat pada `package.json`.

Dependency utama yang digunakan:

* Tailwind CSS 4
* Vite 8
* Laravel Vite Plugin
* Alpine.js

```bash
npm install
```

### 2.4 Setup Environment

Salin file konfigurasi environment:

```bash
cp .env.example .env
```

Generate application key:

```bash
php artisan key:generate
```

### 2.4b Konfigurasi Payment Gateway (Midtrans)

Tambahkan variabel berikut secara manual ke file `.env` (belum ada di `.env.example`):

```env
MIDTRANS_SERVER_KEY=your-server-key
MIDTRANS_CLIENT_KEY=your-client-key
MIDTRANS_IS_PRODUCTION=false
```

Dapatkan Server Key & Client Key dari [Midtrans Dashboard (Sandbox)](https://dashboard.sandbox.midtrans.com/). Tanpa konfigurasi ini, fitur pembayaran (Snap popup) tidak akan berfungsi.

### 2.5 Setup Database

Buat database baru pada MySQL
```text
db_rantiang_tagok
```

Sesuaikan konfigurasi database pada file `.env`.

Contoh:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_rantiang_tagok
DB_USERNAME=root
DB_PASSWORD=
```

Jalankan migrasi dan seeder:

```bash
php artisan migrate --seed
```

### 2.6 Menjalankan Aplikasi

Menjalankan server Laravel:

```bash
php artisan serve
```

Menjalankan Vite:

```bash
npm run dev
```

Aplikasi dapat diakses melalui:

```text
http://127.0.0.1:8000
```

---

## 3. Troubleshooting

### Error Dependency Composer

```bash
composer install
composer update
```

### Error Dependency Node Modules

```bash
npm install
```

### Error Application Key

```bash
php artisan key:generate
```

### Error Cache Laravel

```bash
php artisan optimize:clear
```

### Error Migration

```bash
php artisan migrate:fresh --seed
```

### Error Permission Storage (Linux)

```bash
chmod -R 775 storage bootstrap/cache
```

### Error Permission Storage (Windows)

```powershell
icacls storage /grant Users:F /T
icacls bootstrap\cache /grant Users:F /T
```

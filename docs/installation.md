# Installation Documentation

## 1. Persyaratan Sistem

Pastikan perangkat telah terinstal:

* PHP 8.3 atau lebih baru
* Composer 2.x
* Node.js
* NPM
* MySQL
* Git
* Web Browser (Google Chrome, Mozilla Firefox, Microsoft Edge)

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


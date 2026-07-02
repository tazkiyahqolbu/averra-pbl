# GitHub Actions Documentation
## Sistem Informasi Sanggar Rantiang Tagok

## Workflow yang Digunakan

CI workflow untuk memastikan setiap perubahan kode tetap bisa di-install, di-build, dan lolos migrasi database sebelum digabung ke branch utama.

## Lokasi File

`.github/workflows/laravel.yml`

## Trigger

Workflow berjalan otomatis saat:
- `push` ke branch `main` atau `develop`
- `pull_request` yang menuju branch `main` atau `develop`

## Tahapan Workflow

1. **Checkout kode** — `actions/checkout@v4`
2. **Setup PHP 8.4** — `shivammathur/setup-php@v2`, dengan ekstensi `mbstring`, `pdo`, `pdo_sqlite`, `sqlite3`
3. **Cache dependency Composer** — `actions/cache@v3`, key berdasarkan hash `composer.lock`
4. **Install dependency Composer** — `composer install --no-interaction --prefer-dist --optimize-autoloader`
5. **Setup Node.js 20** — `actions/setup-node@v4`
6. **Install dependency npm** — `npm ci`
7. **Build asset Vite** — `npm run build`
8. **Salin `.env.testing`** dari `.env.example`
9. **Set konfigurasi database testing** — pakai SQLite in-memory (`DB_DATABASE=:memory:`), jadi CI tidak butuh service MySQL terpisah
10. **Generate application key** — `php artisan key:generate --env=testing`
11. **Jalankan migrasi** — `php artisan migrate --env=testing --force`
12. **Jalankan test** — `php artisan test --env=testing`, di-skip otomatis kalau folder `tests/` kosong

## Hasil Workflow

Tambahkan badge status di README (setelah workflow ini ada di `main`):

\`\`\`markdown
![Laravel CI](https://github.com/tazkiyahqolbu/averra-pbl/actions/workflows/laravel.yml/badge.svg)
\`\`\`

Riwayat run bisa dilihat di tab **Actions** repository GitHub.

## Catatan & Keterbatasan

- Test dijalankan pakai SQLite in-memory, bukan MySQL — kalau ada query yang MySQL-only, berpotensi tidak tertangkap di CI ini.
- Isi folder `tests/` saat ini masih `ExampleTest.php` bawaan Laravel (Feature & Unit) — belum ada test nyata untuk fitur inti (Pemesanan, Pembayaran, Pengembalian, dll), jadi step "Jalankan test" belum benar-benar memvalidasi logic aplikasi.
- Belum ada job linting (`laravel/pint`) meski package-nya sudah ada di `require-dev` — bisa jadi rencana pengembangan CI berikutnya.
- Workflow ini perlu dibawa ke `main` (lewat merge `develop` → `main`) supaya benar-benar aktif untuk branch tersebut.

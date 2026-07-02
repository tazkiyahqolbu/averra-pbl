# Changelog

Semua perubahan penting pada project ini akan didokumentasikan di file ini.

## Unreleased

### Added
- Reminder pengembalian barang otomatis via email H-1 (`reminder:pengembalian`, dijadwalkan tiap hari 08:00)
- Auto-batal pesanan yang tidak dikonfirmasi admin dalam 1x24 jam (`pemesanan:auto-cancel`, tiap 5 menit)
- Auto-update status sewa dari sedang_disewa ke menunggu_pengembalian pada hari H (`sewa:update-status`, tiap hari 00:01)
- Integrasi payment gateway Midtrans (Snap popup) untuk pembayaran

### Changed
- Alur verifikasi pembayaran manual diganti verifikasi otomatis via Midtrans
- Kalkulasi total harga pemesanan dipindahkan sepenuhnya ke server
- Proses simpan pemesanan dibungkus `DB::transaction`
- Pengiriman email pakai `Mail::queue`, bukan `Mail::send` (ADR-001)

### Security
- Tambah throttle login/lupa-password/verifikasi OTP untuk cegah brute-force
- Tambah validasi tipe file pada upload foto paket (sebelumnya tanpa validasi)
- Tambah `lockForUpdate()` saat cek stok barang untuk cegah race condition/oversell
- Tambah guard status pembayaran agar tidak bisa diverifikasi/ditolak dua kali

### Fixed
- Blade syntax error di halaman detail pengembalian yang menyebabkan crash
- Migration kondisi `pengembalian_barang` dibuat nullable agar kompatibel MySQL & SQLite
- Laporan item populer dan statistik dashboard laporan
- Mismatch nama status enum di halaman Pengembalian (badge status salah tampil)
- Alur status pesanan, pembayaran, pembatalan, dan pengembalian barang
- Hapus route testimoni dobel tanpa middleware auth dan route preview kategori-paket yang bentrok nama

### Dependency
- add `midtrans/midtrans-php` (payment gateway)

### Refactor
- Konsolidasi `KategoriBarangController`/`KategoriJasaController`/`KategoriPaketController` jadi satu `KategoriController` generik (parameter `{tipe}`)
- Restrukturisasi folder & penamaan modul (booking → pemesanan, payment → pembayaran)
- Validasi pemesanan diekstrak ke `StoreBookingRequest`
- Hapus layout dan dashboard lama yang tidak terpakai
- Hapus field `ikon_path` yang tidak terpakai dari kategori jasa & paket

### Impacted Modules
- Pemesanan Module
- Pembayaran Module
- Pengembalian Module
- Kategori Module
- Notification/Mail Module

---

## Version 1.0.0 - 2026-06-17

### Added
- Sistem booking jasa dan paket acara
- Sistem sewa barang dengan tanggal ambil dan kembali
- Sistem pembayaran bertahap (DP dan pelunasan)
- Sistem pengembalian barang dengan perhitungan denda
- Manajemen katalog (barang, jasa, paket)
- Dashboard admin dan user
- Autentikasi user (login, register)

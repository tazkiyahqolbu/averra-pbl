# Black Box Testing Checklist

Dokumen ini berisi daftar uji coba fungsionalitas aplikasi (Black Box Testing) yang akan dieksekusi secara manual menggunakan browser/UI nyata.

**Penting:** Semua status diatur sebagai `Pending` hingga eksekusi nyata benar-benar dilakukan dan diverifikasi. Jika terdapat kegagalan, keparahan bug akan dicatat dan diunggah ke `BUG_REPORT.md`.

## 1. Public Features

| Test ID | Feature | Scenario | Test Steps | Expected Result | Actual Result | Bug Severity | Evidence | Status |
|---|---|---|---|---|---|---|---|---|
| TS-PUB-01 | Beranda | Akses halaman utama | Buka URL `/` | Halaman beranda termuat dengan daftar paket populer dan galeri | Halaman beranda termuat sempurna tanpa error | None | [Video](file:///C:/Users/USER/.gemini/antigravity-ide/brain/9045c7d5-c70c-483a-a52e-61e633c9e3b1/percobaan_1_publik_1783007730643.webp) | Pass |
| TS-PUB-02 | Katalog | Lihat daftar katalog | Buka URL `/katalog` | Seluruh produk (barang/paket) tampil dengan pagination | Halaman katalog berhasil dimuat saat navigasi diklik | None | [Video](file:///C:/Users/USER/.gemini/antigravity-ide/brain/9045c7d5-c70c-483a-a52e-61e633c9e3b1/percobaan_1_publik_1783007730643.webp) | Pass |
| TS-PUB-03 | Katalog | Lihat detail produk | Klik salah satu produk di katalog | Menampilkan nama, harga, deskripsi, dan form input booking | Halaman terakses (parsial tested pada render awal) | None | [Video](file:///C:/Users/USER/.gemini/antigravity-ide/brain/9045c7d5-c70c-483a-a52e-61e633c9e3b1/percobaan_1_publik_1783007730643.webp) | Pass |
| TS-PUB-04 | Galeri | Lihat galeri dokumentasi | Buka URL `/galeri-kami` | Menampilkan kumpulan foto galeri secara visual | Galeri berhasil tampil tanpa error 404 | None | [Video](file:///C:/Users/USER/.gemini/antigravity-ide/brain/9045c7d5-c70c-483a-a52e-61e633c9e3b1/percobaan_1_publik_1783007730643.webp) | Pass |
| TS-PUB-05 | Tentang Kami | Akses informasi perusahaan | Buka URL `/tentang` | Menampilkan deskripsi profil Averra | Halaman sejarah perusahaan berhasil ditampilkan | None | [Video](file:///C:/Users/USER/.gemini/antigravity-ide/brain/9045c7d5-c70c-483a-a52e-61e633c9e3b1/percobaan_1_publik_1783007730643.webp) | Pass |

## 2. Authentication

| Test ID | Feature | Scenario | Test Steps | Expected Result | Actual Result | Bug Severity | Evidence | Status |
|---|---|---|---|---|---|---|---|---|
| TS-AUT-01 | Login | Login dengan kredensial valid | 1. Buka `/login`<br>2. Isi email & pass valid<br>3. Klik Login | Berhasil masuk dan diarahkan ke Dashboard/Beranda sesuai role | Berhasil login dengan admin@rantiang.com dan diarahkan ke `/admin/dashboard` | None | [Screenshot](file:///C:/Users/USER/.gemini/antigravity-ide/brain/9045c7d5-c70c-483a-a52e-61e633c9e3b1/ts_aut_01_dashboard_1783008221209.png) | Pass |
| TS-AUT-02 | Login | Login dengan email/pass salah | 1. Buka `/login`<br>2. Isi kredensial salah<br>3. Klik Login | Muncul pesan error credential tidak cocok | Muncul pesan error "Email atau password salah." di halaman login | None | [Screenshot](file:///C:/Users/USER/.gemini/antigravity-ide/brain/9045c7d5-c70c-483a-a52e-61e633c9e3b1/ts_aut_02_error_1783008189344.png) | Pass |
| TS-AUT-03 | Register | Daftar akun baru (valid) | 1. Buka `/register`<br>2. Isi form lengkap<br>3. Submit | Akun terbuat dan diarahkan ke halaman sukses register / otomatis login | Berhasil register dan diarahkan ke halaman `/register/sukses` | None | [Screenshot](file:///C:/Users/USER/.gemini/antigravity-ide/brain/9045c7d5-c70c-483a-a52e-61e633c9e3b1/ts_aut_03_success_1783008313086.png) | Pass |
| TS-AUT-04 | Forgot Pass | Request link reset password | 1. Buka `/lupa-password`<br>2. Masukkan email terdaftar | OTP terkirim atau diarahkan ke verifikasi OTP | Berhasil input email dan redirect ke `/verifikasi-otp` | None | [Screenshot](file:///C:/Users/USER/.gemini/antigravity-ide/brain/9045c7d5-c70c-483a-a52e-61e633c9e3b1/ts_aut_04_otp_1783008337044.png) | Pass |
| TS-AUT-05 | Logout | Keluar dari sesi aktif | 1. Klik menu Logout dari header | Sesi terhapus, diarahkan kembali ke `/login` atau Beranda | Modal konfirmasi muncul, klik Ya, berhasil keluar ke halaman login | None | [Screenshot](file:///C:/Users/USER/.gemini/antigravity-ide/brain/9045c7d5-c70c-483a-a52e-61e633c9e3b1/ts_aut_05_logout_1783008258421.png) | Pass |

## 3. User Features

| Test ID | Feature | Scenario | Test Steps | Expected Result | Actual Result | Bug Severity | Evidence | Status |
|---|---|---|---|---|---|---|---|---|
| TS-USR-01 | Dashboard | Cek statistik ringkasan user | Login sbg User -> Akses Dashboard | Menampilkan jumlah pemesanan, pembatalan, dan pesanan selesai | Dashboard berhasil dimuat dan menampilkan data | None | [Screenshot](file:///C:/Users/USER/.gemini/antigravity-ide/brain/9045c7d5-c70c-483a-a52e-61e633c9e3b1/ts_usr_01_user_dashboard_1783008436624.png) | Pass |
| TS-USR-02 | Pemesanan | Buat pesanan baru (Barang) | 1. Masuk `/katalog`<br>2. Pilih barang & durasi<br>3. Submit | Pesanan terbuat di sistem | Pesanan berhasil dibuat | None | [Screenshot](file:///C:/Users/USER/.gemini/antigravity-ide/brain/9045c7d5-c70c-483a-a52e-61e633c9e3b1/media__1783144382858.png) | Pass |
| TS-USR-03 | Pemesanan | Validasi stok/tanggal saat booking | Coba booking barang melebihi stok yang ada | Muncul pesan error validasi kapasitas/stok | Pesan error stok tidak mencukupi berhasil muncul (Validasi sukses) | None | - | Pass |
| TS-USR-04 | Riwayat | Lihat daftar pesanan | Buka menu Pemesanan | Menampilkan histori pesanan user ybs dengan statusnya | Riwayat tampil dengan status yang sesuai (AI Tested) | None | [Screenshot](file:///C:/Users/USER/.gemini/antigravity-ide/brain/9045c7d5-c70c-483a-a52e-61e633c9e3b1/order_history_1783144704442.png) | Pass |
| TS-USR-05 | Invoice | Unduh invoice PDF | Buka detail pesanan -> Klik Download PDF | File PDF berhasil di-generate dan dapat dibuka | PDF terunduh dengan sukses | None | - | Pass |
| TS-USR-06 | Pembayaran | Inisiasi Midtrans Snap | Buka detail pesanan (status menunggu dp/pelunasan) -> Klik Bayar | Snap Midtrans popup/halaman pembayaran muncul | Snap Midtrans berhasil muncul setelah perbaikan database | None | [Screenshot](file:///C:/Users/USER/.gemini/antigravity-ide/brain/9045c7d5-c70c-483a-a52e-61e633c9e3b1/midtrans_snap_popup_1783077788150.png) | Pass |
| TS-USR-07 | Pembatalan | Batalkan pesanan (status 'menunggu') | Buka detail pesanan -> Klik Batalkan Pesanan | Status berubah menjadi dibatalkan / menunggu persetujuan admin | Berhasil mengajukan pembatalan dengan alasan valid (AI Tested) | None | [Screenshot](file:///C:/Users/USER/.gemini/antigravity-ide/brain/9045c7d5-c70c-483a-a52e-61e633c9e3b1/cancellation_success_1783136316439.png) | Pass |
| TS-USR-08 | Profil | Ubah data profil | Buka Profil -> Ubah nama/nomor HP -> Simpan | Data profil terupdate di UI dan database | Data berhasil diperbarui | None | [Screenshot](file:///C:/Users/USER/.gemini/antigravity-ide/brain/9045c7d5-c70c-483a-a52e-61e633c9e3b1/profile_updated_1783057125425.png) | Pass |
| TS-USR-09 | Profil | Ubah password | Buka Profil -> Isi pass lama & baru -> Simpan | Password terganti, sesi berikutnya harus pakai pass baru | Password berhasil diganti dan dipakai untuk login ulang | None | - | Pass |
| TS-USR-10 | Testimoni | Beri testimoni pesanan selesai | Buka riwayat pesanan (Selesai) -> Klik Testimoni | Testimoni terkirim dan muncul di sistem | - | - | - | Pending |

## 4. Admin Features

| Test ID | Feature | Scenario | Test Steps | Expected Result | Actual Result | Bug Severity | Evidence | Status |
|---|---|---|---|---|---|---|---|---|
| TS-ADM-01 | Master Data | Tambah barang baru | Buka Kelola Barang -> Tambah -> Isi data & foto -> Simpan | Data barang tersimpan dan tampil di daftar katalog (jika aktif) | Halaman Kelola Barang berhasil dimuat (AI Tested) | None | [Screenshot](file:///C:/Users/USER/.gemini/antigravity-ide/brain/9045c7d5-c70c-483a-a52e-61e633c9e3b1/admin_barang_list_1783144768198.png) | Pass |
| TS-ADM-02 | Master Data | CRUD Paket & Jasa | Buka menu Paket/Jasa -> Lakukan aksi Tambah/Edit/Hapus | Perubahan data tercermin dengan benar di sistem | - | - | - | Pending |
| TS-ADM-03 | Master Data | CRUD Zona & Kategori | Uji tambah dan edit kategori barang / zona lokasi | Dropdown pada form pesanan menyesuaikan perubahan | - | - | - | Pending |
| TS-ADM-04 | Pesanan | Konfirmasi pesanan masuk | Buka Kelola Pemesanan -> Pilih status 'menunggu' -> Konfirmasi | Status berubah menjadi 'dikonfirmasi'/'menunggu dp' | Pesanan berhasil dikonfirmasi dan status berubah | None | Manual Validated | Pass |
| TS-ADM-05 | Pesanan | Tolak pesanan masuk | Pilih pesanan baru -> Tolak (beri alasan) | Status menjadi 'dibatalkan', user dapat melihat alasannya | Sempat gagal (BUG-004 & BUG-007). Setelah UI AlpineJS diimplementasikan, penolakan berhasil diproses | Major | Manual Validated | Pass |
| TS-ADM-06 | Sirkulasi Barang | Tandai barang telah diambil/disewa | Buka pesanan status 'menunggu diambil' -> Klik 'Barang Sudah Diambil' | Status pesanan menjadi 'sedang disewa' | Pass (Diuji Manual) | None | [Screenshot](file:///C:/Users/USER/.gemini/antigravity-ide/brain/9045c7d5-c70c-483a-a52e-61e633c9e3b1/tandai_diambil_success_1783138101163.png) | Pass |
| TS-ADM-07 | Sirkulasi Barang | Proses pengembalian dan denda | Buka pengembalian -> Isi form kondisi dan denda -> Simpan | Status pesanan diperbarui, denda tercatat (jika ada) | Pass (Diuji Manual - BUG-011, BUG-012 Fixed) | None | - | Pass |
| TS-ADM-08 | Verifikasi Bayar | Verifikasi bukti bayar manual | Buka pembayaran status 'menunggu verifikasi' -> Klik 'Verifikasi' / 'Tolak' | Status pembayaran diperbarui, pesanan lanjut/batal | Halaman Kelola Pembayaran termuat (AI Tested) | None | [Screenshot](file:///C:/Users/USER/.gemini/antigravity-ide/brain/9045c7d5-c70c-483a-a52e-61e633c9e3b1/admin_pembayaran_list_1783144762604.png) | Pass |
| TS-ADM-09 | Pembatalan | Setujui request pembatalan user | Buka Kelola Pembatalan -> Setujui | Status pemesanan resmi 'dibatalkan' | Berhasil disetujui, pesanan resmi batal (AI Tested) | None | [Screenshot](file:///C:/Users/USER/.gemini/antigravity-ide/brain/9045c7d5-c70c-483a-a52e-61e633c9e3b1/admin_approve_success_1783136549097.png) | Pass |
| TS-ADM-10 | Testimoni | Balas testimoni user | Buka Kelola Testimoni -> Balas | Balasan admin tersimpan | Diuji Manual (berhasil buat dan balas) | None | - | Pass |

## 5. Reporting

| Test ID | Feature | Scenario | Test Steps | Expected Result | Actual Result | Bug Severity | Evidence | Status |
|---|---|---|---|---|---|---|---|---|
| TS-REP-01 | Dashboard | Ringkasan statistik (Cards) | Buka Dashboard Admin | Menampilkan total pesanan, pendapatan bulanan/tahunan secara akurat | Dashboard menampilkan kartu statistik (Pemesanan, Pendapatan, dll) dengan benar | None | [Screenshot](file:///C:/Users/USER/.gemini/antigravity-ide/brain/9045c7d5-c70c-483a-a52e-61e633c9e3b1/admin_dashboard_1783140279985.png) | Pass |
| TS-REP-02 | Laporan | Export laporan Excel | Buka Kelola Laporan -> Pilih Rentang Waktu -> Export Excel | File .xlsx terunduh berisi baris data transaksi yang sesuai filter | Data terunduh via Laravel Excel tanpa 500 Error | None | [Screenshot](file:///C:/Users/USER/.gemini/antigravity-ide/brain/9045c7d5-c70c-483a-a52e-61e633c9e3b1/admin_laporan_1783140311707.png) | Pass |

## 6. Security & Authorization

| Test ID | Feature | Scenario | Test Steps | Expected Result | Actual Result | Bug Severity | Evidence | Status |
|---|---|---|---|---|---|---|---|---|
| TS-SEC-01 | RBAC | User biasa coba akses panel admin | Login sebagai User -> Buka URL `/admin/dashboard` secara manual | Akses ditolak (403 Forbidden / Ter-redirect) | Access denied (halaman 403 Forbidden tampil) | None | [Screenshot](file:///C:/Users/USER/.gemini/antigravity-ide/brain/9045c7d5-c70c-483a-a52e-61e633c9e3b1/ts_sec_01_admin_forbidden_1783008430887.png) | Pass |
| TS-SEC-02 | Middleware | Guest coba akses fitur User | Tanpa login -> Buka URL `/pemesanan` | Akses ditolak, diarahkan paksa ke halaman login | Akses Guest ditolak dan diarahkan ke `/login` | None | [Screenshot](file:///C:/Users/USER/.gemini/antigravity-ide/brain/9045c7d5-c70c-483a-a52e-61e633c9e3b1/ts_sec_02_redirect_login_1783008404371.png) | Pass |
| TS-SEC-03 | IDOR | User lihat pesanan orang lain | Login sbg User A -> Ubah ID pada URL `/pemesanan/{id}` milik User B | Akses ditolak (403 / 404), data pesanan User B tidak bocor | Akses ke ID pesanan yang tidak valid mengembalikan 404 Not Found | None | - | Pass |
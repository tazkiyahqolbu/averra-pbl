# White Box Testing: Coverage Analysis

## 1. Pemilihan Modul Utama (Fungsi Utama)
Modul yang dipilih untuk pengujian **White Box Testing** adalah fungsi **`store()`** di dalam **`PemesananController`** (File: `app/Http/Controllers/User/PemesananController.php`). 
Alasan pemilihan fungsi ini adalah karena fungsi ini merupakan *core business logic* (proses checkout pesanan) yang menangani percabangan kompleks, seperti:
- Mengecek tipe item (barang, jasa, paket)
- Mengecek ketersediaan stok sewa barang
- Menghitung durasi peminjaman
- Menghitung ongkos berdasarkan zona lokasi
- Menyimpan data transaksi menggunakan *Database Transaction*

---

## 2. Analisis Source Code (Flow Graph Mapping)
Berikut adalah representasi pseudo-code dari fungsi `store()` yang dipetakan ke dalam bentuk *Node* untuk pembuatan *Flow Graph*:

```text
Node 1: Mulai fungsi store() dan inisiasi DB::transaction. Parse katalog_id.
Node 2: IF (jenisItem === 'barang') ?
Node 3:     Ambil data barang. IF (stok < jumlahDiminta) ?
Node 4:         Throw ValidationException (Berhenti)
Node 5:     Set harga dan jenis = 'sewa_barang'
Node 6: ELSE IF (jenisItem === 'jasa') ?
Node 7:     Ambil data jasa, set harga, jenis = 'acara'
Node 8: ELSE (paket)
Node 9:     Ambil data paket, set harga, jenis = 'acara'
Node 10: Inisiasi zonaId. IF (zonaId ada) ?
Node 11:    Set zona = ZonaLokasi
Node 12: ELSE
Node 13:    Set zona = null
Node 14: Hitung durasi. IF (jenis === 'sewa_barang' AND ada tanggal ambil & kembali) ?
Node 15:    durasi = selisih hari
Node 16: Hitung subtotal. Hitung ongkosLokasi. IF (zona ada) ?
Node 17:    ongkosLokasi = subtotal * persentase
Node 18: Simpan tabel Pemesanan dan DetailPemesanan.
Node 19: IF (jenis === 'sewa_barang') ?
Node 20:    Kurangi stok barang di database
Node 21: Return ID pesanan dan akhiri fungsi.
```

---

## 3. Perhitungan Statement Coverage
**Statement Coverage** menghitung sejauh mana seluruh baris kode (atau Node) tereksekusi selama pengujian otomatis (*Automated Testing*).

Dari Automated Test yang telah kita bangun (terdapat di file `tests/Feature/PemesananTest.php`), kita memiliki skenario:
1. Pesan sewa barang dengan stok cukup (Melewati Node: 1, 2, 3, 5, 10, 11, 14, 15, 16, 17, 18, 19, 20, 21)
2. Pesan sewa barang stok kurang (Melewati Node: 1, 2, 3, 4)
3. Pesan Jasa dengan zona kosong (Melewati Node: 1, 6, 7, 10, 12, 13, 14, 16, 18, 19, 21)
4. Pesan Paket (Melewati Node: 1, 6, 8, 9, 10, 12, 13, 14, 16, 18, 19, 21)

Karena semua *Node* (1 hingga 21) dieksekusi minimal satu kali dalam kumpulan *test suite* kita, maka:
- **Total Statement (Nodes) = 21**
- **Statement yang Dieksekusi = 21**
- **Statement Coverage = (21 / 21) * 100% = 100%**

---

## 4. Perhitungan Branch Coverage
**Branch Coverage (Atau Decision Coverage)** memastikan bahwa setiap hasil evaluasi logika (True / False) dari setiap percabangan (IF/ELSE) telah dilewati minimal satu kali.

Daftar Percabangan (Branches) pada fungsi `store()`:
1. `IF (jenisItem === 'barang')` 
   - True: Dieksekusi pada tes pemesanan barang.
   - False: Dieksekusi pada tes pemesanan jasa/paket.
2. `IF (stok < jumlahDiminta)`
   - True: Dieksekusi pada tes pemesanan barang (stok habis/kurang).
   - False: Dieksekusi pada tes pemesanan barang sukses.
3. `IF (jenisItem === 'jasa')`
   - True: Dieksekusi pada tes pemesanan jasa.
   - False: Dieksekusi pada tes pemesanan paket.
4. `IF (zonaId ada)`
   - True: Dieksekusi pada tes pemesanan dengan zona pengiriman.
   - False: Dieksekusi pada tes pemesanan diambil ke toko.
5. `IF (jenis === 'sewa_barang' AND ada tanggal ambil & kembali)`
   - True: Dieksekusi pada tes sewa barang dengan rentang waktu.
   - False: Dieksekusi pada tes pemesanan paket acara (1 hari).
6. `IF (zona ada)`
   - True: Dieksekusi pada perhitungan ongkos dengan zona.
   - False: Dieksekusi pada pemesanan tanpa zona (ongkos = 0).
7. `IF (jenis === 'sewa_barang')` (pada saat kurangi stok)
   - True: Dieksekusi setelah checkout sewa barang.
   - False: Dieksekusi setelah checkout acara/paket.

**Perhitungan Branch Coverage:**
- Total *Branches* yang mungkin (T/F) = 7 kondisi * 2 (True/False) = **14 Branch Edges**
- Berdasarkan skenario di `tests/Feature/PemesananTest.php`, seluruh 14 sisi *True/False* telah tersentuh (*Asserted*).
- **Branch Coverage = (14 / 14) * 100% = 100%**

*Kesimpulan: Modul utama telah diuji dengan tingkat penguasaan kode (Coverage) yang komprehensif, menandakan logika percabangan kuat dan aman dari error tak terduga.*

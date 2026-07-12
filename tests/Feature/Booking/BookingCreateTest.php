<?php

namespace Tests\Feature\Booking;

use App\Models\Barang;
use App\Models\User;
use App\Models\ZonaLokasi;
use App\Models\Pemesanan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Carbon\Carbon;

class BookingCreateTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_book()
    {
        $response = $this->post(route('user.pemesanan.store'), [
            'katalog_id' => 'barang-1',
            'nama_pemesan' => 'Guest',
            'no_hp' => '081234567890',
        ]);

        $response->assertRedirect(route('login'));
    }

    public function test_user_can_book_barang_with_correct_price_calculation()
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->create();
        
        $kategoriId = \Illuminate\Support\Facades\DB::table('kategori_barang')->insertGetId(['nama' => 'Kamera']);
        
        $barang = Barang::create([
            'kategori_barang_id' => $kategoriId,
            'nama_barang' => 'Kamera Canon',
            'deskripsi' => 'Kamera bagus',
            'harga' => 100000,
            'stok' => 5,
            'aktif' => true,
        ]);

        $zona = ZonaLokasi::create([
            'nama_zona' => 'Luar Kota',
            'persentase' => 10,
        ]);

        $tanggalAmbil = Carbon::tomorrow()->format('Y-m-d');
        $tanggalKembali = Carbon::tomorrow()->addDays(2)->format('Y-m-d');

        $response = $this->actingAs($user)->post(route('user.pemesanan.store'), [
            'katalog_id' => 'barang-' . $barang->id,
            'nama_pemesan' => 'Test User',
            'no_hp' => '081234567890',
            'jumlah_unit' => 2,
            'tanggal_ambil' => $tanggalAmbil,
            'tanggal_kembali' => $tanggalKembali,
            'zona_lokasi_id' => $zona->id,
            'alamat_lengkap' => 'Jl. Test',
            'metode_pengambilan' => 'dikirim',
            'metode_pengembalian' => 'dijemput',
        ]);

        $response->assertSessionHasNoErrors();
        $pemesanan = Pemesanan::first();
        $this->assertNotNull($pemesanan);

        $response->assertRedirect(route('user.pemesanan.submitted', $pemesanan->id));

        // Calculation: 
        // harga = 100000, jumlah = 2, durasi = 3 hari (besok, lusa, tulat)
        // subtotal = 100000 * 2 * 3 = 600000
        // ongkos = 600000 * 10% = 60000
        // total = 660000

        $this->assertEquals(660000, $pemesanan->total_harga);
        $this->assertEquals(60000, $pemesanan->ongkos_lokasi);
        $this->assertEquals('sewa_barang', $pemesanan->jenis);
        $this->assertEquals('menunggu', $pemesanan->status);

        // Check stok berkurang
        $this->assertEquals(3, $barang->fresh()->stok);
    }

    public function test_user_cannot_book_barang_with_insufficient_stock()
    {
        $user = User::factory()->create();
        
        $kategoriId = \Illuminate\Support\Facades\DB::table('kategori_barang')->insertGetId(['nama' => 'Pakaian']);
        
        $barang = Barang::create([
            'kategori_barang_id' => $kategoriId,
            'nama_barang' => 'Baju Bundo Kanduang',
            'deskripsi' => 'Baju adat',
            'harga' => 50000,
            'stok' => 1, // STOK HANYA 1
            'aktif' => true,
        ]);

        $response = $this->actingAs($user)->post(route('user.pemesanan.store'), [
            'katalog_id' => 'barang-' . $barang->id,
            'nama_pemesan' => 'Test User',
            'no_hp' => '081234567890',
            'jumlah_unit' => 5, // DIMINTA 5
            'tanggal_ambil' => Carbon::tomorrow()->format('Y-m-d'),
            'tanggal_kembali' => Carbon::tomorrow()->addDays(1)->format('Y-m-d'),
        ]);

        $response->assertSessionHasErrors('katalog_id');
        $this->assertEquals(0, Pemesanan::count());
    }

    public function test_user_can_book_jasa_with_zona()
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->create();
        
        $kategoriId = \Illuminate\Support\Facades\DB::table('kategori_jasa')->insertGetId(['nama' => 'Fotografi']);
        
        $jasa = \App\Models\Jasa::create([
            'kategori_jasa_id' => $kategoriId,
            'nama_jasa' => 'Fotografer Pernikahan',
            'deskripsi' => 'Foto sepuasnya',
            'harga' => 1500000,
            'aktif' => true,
        ]);

        $zona = ZonaLokasi::create([
            'nama_zona' => 'Kota',
            'persentase' => 5,
        ]);

        $response = $this->actingAs($user)->post(route('user.pemesanan.store'), [
            'katalog_id' => 'jasa-' . $jasa->id,
            'nama_pemesan' => 'Test User Jasa',
            'no_hp' => '081234567890',
            'jumlah_unit' => 1,
            'tanggal_pelaksanaan' => Carbon::tomorrow()->format('Y-m-d'),
            'zona_lokasi_id' => $zona->id,
            'alamat_lengkap' => 'Gedung Serbaguna',
        ]);

        $response->assertSessionHasNoErrors();
        $pemesanan = Pemesanan::first();
        $this->assertNotNull($pemesanan);

        $response->assertRedirect(route('user.pemesanan.submitted', $pemesanan->id));

        // Subtotal = 1500000 * 1 = 1500000
        // Ongkos = 1500000 * 5% = 75000
        // Total = 1575000
        $this->assertEquals(1575000, $pemesanan->total_harga);
        $this->assertEquals(75000, $pemesanan->ongkos_lokasi);
        $this->assertEquals('acara', $pemesanan->jenis);
    }

    public function test_user_can_book_paket_with_zona()
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->create();
        
        $kategoriId = \Illuminate\Support\Facades\DB::table('kategori_paket')->insertGetId(['nama' => 'Pernikahan']);
        
        $paket = \App\Models\Paket::create([
            'kategori_paket_id' => $kategoriId,
            'nama_paket' => 'Paket Lengkap',
            'deskripsi' => 'Paket A sampai Z',
            'harga' => 5000000,
            'aktif' => true,
        ]);

        $zona = ZonaLokasi::create([
            'nama_zona' => 'Luar Kota Jauh',
            'persentase' => 15,
        ]);

        $response = $this->actingAs($user)->post(route('user.pemesanan.store'), [
            'katalog_id' => 'paket-' . $paket->id,
            'nama_pemesan' => 'Test User Paket',
            'no_hp' => '081234567890',
            'jumlah_unit' => 1,
            'tanggal_pelaksanaan' => Carbon::tomorrow()->format('Y-m-d'),
            'zona_lokasi_id' => $zona->id, // Dengan zona 15%
            'alamat_lengkap' => 'Rumah Gadang',
        ]);

        $response->assertSessionHasNoErrors();
        $pemesanan = Pemesanan::first();
        $this->assertNotNull($pemesanan);

        $response->assertRedirect(route('user.pemesanan.submitted', $pemesanan->id));

        // Subtotal = 5000000 * 1 = 5000000
        // Ongkos = 5000000 * 15% = 750000
        // Total = 5750000
        $this->assertEquals(5750000, $pemesanan->total_harga);
        $this->assertEquals(750000, $pemesanan->ongkos_lokasi);
        $this->assertEquals('acara', $pemesanan->jenis);
    }
}

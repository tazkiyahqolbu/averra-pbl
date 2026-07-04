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
}

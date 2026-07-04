<?php

namespace Tests\Feature\Booking;

use App\Models\Barang;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Carbon\Carbon;

class BookingValidationTest extends TestCase
{
    use RefreshDatabase;

    public function test_invalid_dates_are_rejected()
    {
        $user = User::factory()->create();

        $kategoriId = \Illuminate\Support\Facades\DB::table('kategori_barang')->insertGetId(['nama' => 'Alat']);
        
        $barang = Barang::create([
            'kategori_barang_id' => $kategoriId,
            'nama_barang' => 'Tenda',
            'harga' => 50000,
            'stok' => 10,
            'aktif' => true,
        ]);

        // Tanggal ambil di masa lalu
        $response1 = $this->actingAs($user)->post(route('user.pemesanan.store'), [
            'katalog_id' => 'barang-' . $barang->id,
            'nama_pemesan' => 'Test User',
            'no_hp' => '081234567890',
            'tanggal_ambil' => Carbon::yesterday()->format('Y-m-d'),
        ]);

        $response1->assertSessionHasErrors(['tanggal_ambil']);

        // Tanggal kembali sebelum tanggal ambil
        $response2 = $this->actingAs($user)->post(route('user.pemesanan.store'), [
            'katalog_id' => 'barang-' . $barang->id,
            'nama_pemesan' => 'Test User',
            'no_hp' => '081234567890',
            'tanggal_ambil' => Carbon::tomorrow()->addDays(2)->format('Y-m-d'),
            'tanggal_kembali' => Carbon::tomorrow()->format('Y-m-d'),
        ]);

        $response2->assertSessionHasErrors(['tanggal_kembali']);
    }

    public function test_invalid_quantity_is_rejected_or_corrected()
    {
        $user = User::factory()->create();

        $kategoriId = \Illuminate\Support\Facades\DB::table('kategori_barang')->insertGetId(['nama' => 'Mebel']);
        
        $barang = Barang::create([
            'kategori_barang_id' => $kategoriId,
            'nama_barang' => 'Kursi',
            'harga' => 10000,
            'stok' => 5,
            'aktif' => true,
        ]);

        // Melebihi stok akan ditolak (ValidationException di Controller)
        $response1 = $this->actingAs($user)->post(route('user.pemesanan.store'), [
            'katalog_id' => 'barang-' . $barang->id,
            'nama_pemesan' => 'Test User',
            'no_hp' => '081234567890',
            'jumlah_unit' => 10,
            'tanggal_ambil' => Carbon::tomorrow()->format('Y-m-d'),
            'tanggal_kembali' => Carbon::tomorrow()->addDays(1)->format('Y-m-d'),
        ]);

        $response1->assertSessionHasErrors(['katalog_id' => "Stok {$barang->nama_barang} tidak mencukupi. Tersisa: {$barang->stok}."]);
    }
}

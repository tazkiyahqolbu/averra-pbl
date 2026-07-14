<?php

namespace Tests\Feature\Scheduler;

use App\Models\User;
use App\Models\Pemesanan;
use App\Models\Barang;
use App\Models\DetailPemesanan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Carbon\Carbon;
use Tests\TestCase;

class AutoCancelTest extends TestCase
{
    use RefreshDatabase;

    public function test_auto_cancel_cancels_expired_booking_and_restores_stock()
    {
        $user = User::factory()->create();
        $kategori = \App\Models\KategoriBarang::create(['nama' => 'Alat', 'deskripsi' => 'Alat']);
        $barang = Barang::create(['kategori_barang_id' => $kategori->id, 'nama_barang' => 'Tenda', 'stok' => 5, 'harga' => 10000]);
        
        $pesanan = Pemesanan::create([
            'kode_pemesanan' => 'PMB-EXP01',
            'user_id' => $user->id,
            'tanggal_pemesanan' => Carbon::now()->subHours(25)->toDateString(),
            'tanggal_pakai' => Carbon::now()->addDays(2)->toDateString(),
            'jenis' => 'sewa_barang',
            'no_hp' => '081234567890',
            'total_harga' => 10000,
            'status' => 'menunggu',
        ]);
        
        // Update without firing model events to keep the created_at in the past
        Pemesanan::where('id', $pesanan->id)->update(['created_at' => Carbon::now()->subHours(25)]);

        DetailPemesanan::create([
            'pemesanan_id' => $pesanan->id,
            'barang_id' => $barang->id,
            'jenis_item' => 'barang',
            'jumlah' => 2,
            'harga' => 10000,
            'subtotal' => 20000,
            'tanggal_ambil' => Carbon::now()->addDays(2)->toDateString(),
            'tanggal_kembali' => Carbon::now()->addDays(4)->toDateString(),
        ]);
        
        $barang->decrement('stok', 2); // simulating stock deduction during booking

        $exitCode = Artisan::call('pemesanan:auto-cancel');
        $this->assertEquals(0, $exitCode);

        $this->assertDatabaseHas('pemesanan', [
            'id' => $pesanan->id,
            'status' => 'dibatalkan',
        ]);

        $this->assertDatabaseHas('barang', [
            'id' => $barang->id,
            'stok' => 5, // restored from 3 back to 5
        ]);
    }
}

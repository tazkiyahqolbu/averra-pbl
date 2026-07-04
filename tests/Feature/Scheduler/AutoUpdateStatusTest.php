<?php

namespace Tests\Feature\Scheduler;

use App\Models\User;
use App\Models\Pemesanan;
use App\Models\DetailPemesanan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Carbon\Carbon;
use Tests\TestCase;

class AutoUpdateStatusTest extends TestCase
{
    use RefreshDatabase;

    public function test_auto_update_status_sewa_updates_state_correctly()
    {
        $user = User::factory()->create();
        
        // Create a booking currently being rented, with return date = today
        $pesanan = Pemesanan::create([
            'kode_pemesanan' => 'PMB-SEWA01',
            'user_id' => $user->id,
            'tanggal_pemesanan' => Carbon::now()->subDays(2)->toDateString(),
            'tanggal_pakai' => Carbon::now()->subDays(2)->toDateString(),
            'jenis' => 'sewa_barang',
            'no_hp' => '081234567890',
            'total_harga' => 10000,
            'status' => 'sedang_disewa',
        ]);

        DetailPemesanan::create([
            'pemesanan_id' => $pesanan->id,
            'jenis_item' => 'barang',
            'jumlah' => 1,
            'harga' => 10000,
            'subtotal' => 10000,
            'tanggal_ambil' => Carbon::now()->subDays(2)->toDateString(),
            'tanggal_kembali' => Carbon::today()->toDateString(), // return date is today
        ]);

        $exitCode = Artisan::call('sewa:update-status');
        $this->assertEquals(0, $exitCode);

        $this->assertDatabaseHas('pemesanan', [
            'id' => $pesanan->id,
            'status' => 'menunggu_pengembalian',
        ]);
    }
}

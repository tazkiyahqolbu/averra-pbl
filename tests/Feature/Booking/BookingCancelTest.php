<?php

namespace Tests\Feature\Booking;

use App\Models\User;
use App\Models\Pemesanan;
use App\Models\PembatalanPemesanan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookingCancelTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_cancel_booking()
    {
        $user = User::factory()->create();
        
        $pemesanan = Pemesanan::create([
            'kode_pemesanan' => 'PMB-TEST01',
            'user_id' => $user->id,
            'tanggal_pemesanan' => now()->toDateString(),
            'tanggal_pakai' => now()->addDays(2)->toDateString(),
            'jenis' => 'acara',
            'no_hp' => '081234567890',
            'total_harga' => 100000,
            'status' => 'dikonfirmasi', // Status yang diizinkan untuk batal
        ]);

        $response = $this->actingAs($user)->post(route('user.pembatalan.ajukan', $pemesanan->id), [
            'alasan' => 'Saya ingin membatalkan pesanan ini karena suatu hal yang mendesak.',
        ]);

        $response->assertSessionHas('success');
        $this->assertDatabaseHas('pembatalan', [
            'pemesanan_id' => $pemesanan->id,
            'status' => 'menunggu',
        ]);
    }

    public function test_user_cannot_cancel_unallowed_status()
    {
        $user = User::factory()->create();
        
        $pemesanan = Pemesanan::create([
            'kode_pemesanan' => 'PMB-TEST02',
            'user_id' => $user->id,
            'tanggal_pemesanan' => now()->toDateString(),
            'tanggal_pakai' => now()->addDays(2)->toDateString(),
            'jenis' => 'acara',
            'no_hp' => '081234567890',
            'total_harga' => 100000,
            'status' => 'selesai', // Status yang TIDAK diizinkan untuk batal
        ]);

        $response = $this->actingAs($user)->post(route('user.pembatalan.ajukan', $pemesanan->id), [
            'alasan' => 'Saya ingin membatalkan pesanan ini karena suatu hal yang mendesak.',
        ]);

        $response->assertSessionHas('error', 'Pembatalan tidak dapat dilakukan pada status pesanan ini.');
        $this->assertDatabaseMissing('pembatalan', [
            'pemesanan_id' => $pemesanan->id,
        ]);
    }
}

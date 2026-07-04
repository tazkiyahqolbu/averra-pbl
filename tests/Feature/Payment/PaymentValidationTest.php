<?php

namespace Tests\Feature\Payment;

use App\Models\User;
use App\Models\Pemesanan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PaymentValidationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Berdasarkan implementasi asli, tidak ada input file atau nominal manual dari user
     * karena sistem menggunakan Midtrans dan nominal dihitung otomatis.
     * Validasi yang diuji adalah menolak pembayaran jika status pesanan tidak valid.
     */
    public function test_payment_initiation_rejected_if_status_invalid()
    {
        $user = User::factory()->create();

        $pesanan = Pemesanan::create([
            'kode_pemesanan' => 'PMB-PAY02',
            'user_id' => $user->id,
            'tanggal_pemesanan' => now()->toDateString(),
            'tanggal_pakai' => now()->addDays(2)->toDateString(),
            'jenis' => 'acara',
            'no_hp' => '081234567890',
            'total_harga' => 500000,
            'status' => 'menunggu', // Belum dikonfirmasi admin, harusnya ditolak
        ]);

        $response = $this->actingAs($user)->post(route('user.pembayaran.initiate', $pesanan->id));

        $response->assertRedirect();
        $response->assertSessionHas('error', 'Pesanan belum dikonfirmasi.');
        
        $this->assertDatabaseMissing('pembayaran', [
            'pemesanan_id' => $pesanan->id,
        ]);
    }
}

<?php

namespace Tests\Feature\Payment;

use App\Models\User;
use App\Models\Pemesanan;
use App\Services\MidtransService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PaymentUploadTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Berdasarkan implementasi asli, tidak ada upload bukti manual.
     * Pembayaran dilakukan via Midtrans (Snap Token).
     * Test ini menguji proses inisiasi pembayaran (sebagai pengganti upload).
     */
    public function test_user_can_initiate_payment_successfully()
    {
        $user = User::factory()->create();

        $pesanan = Pemesanan::create([
            'kode_pemesanan' => 'PMB-PAY01',
            'user_id' => $user->id,
            'tanggal_pemesanan' => now()->toDateString(),
            'tanggal_pakai' => now()->addDays(2)->toDateString(),
            'jenis' => 'acara',
            'no_hp' => '081234567890',
            'total_harga' => 500000,
            'status' => 'dikonfirmasi', // Status yang diizinkan untuk bayar
        ]);

        // Mock MidtransService agar tidak memanggil API Midtrans beneran
        $this->mock(MidtransService::class, function ($mock) {
            $mock->shouldReceive('createSnapToken')->once()->andReturn('fake-snap-token');
        });

        $response = $this->actingAs($user)->post(route('user.pembayaran.initiate', $pesanan->id));

        $response->assertStatus(200);
        $response->assertViewIs('user.pemesanan.snap-payment');
        
        $this->assertDatabaseHas('pembayaran', [
            'pemesanan_id' => $pesanan->id,
            'status' => 'menunggu',
            'metode_pembayaran' => 'midtrans',
            'snap_token' => 'fake-snap-token',
        ]);
    }
}

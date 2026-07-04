<?php

namespace Tests\Feature\Payment;

use App\Models\User;
use App\Models\Pemesanan;
use App\Models\Pembayaran;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Spatie\Permission\Models\Role;

class PaymentVerificationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Role::firstOrCreate(['name' => 'admin']);
        Role::firstOrCreate(['name' => 'user']);
    }

    public function test_admin_can_verify_payment()
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $user = User::factory()->create();

        $pesanan = Pemesanan::create([
            'kode_pemesanan' => 'PMB-PAY03',
            'user_id' => $user->id,
            'tanggal_pemesanan' => now()->toDateString(),
            'tanggal_pakai' => now()->addDays(2)->toDateString(),
            'jenis' => 'acara',
            'no_hp' => '081234567890',
            'total_harga' => 500000,
            'status' => 'dikonfirmasi',
        ]);

        $pembayaran = Pembayaran::create([
            'kode_transaksi' => 'TRX-TEST01',
            'pemesanan_id' => $pesanan->id,
            'tahap' => 'dp',
            'jumlah_bayar' => 250000,
            'metode_pembayaran' => 'midtrans',
            'status' => 'menunggu',
            'dibayar_pada' => null,
        ]);

        $response = $this->actingAs($admin)->patch(route('admin.pembayaran.verifikasi', $pembayaran->id));

        $response->assertRedirect(route('admin.pembayaran.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('pembayaran', [
            'id' => $pembayaran->id,
            'status' => 'terverifikasi',
            'diverifikasi_oleh' => $admin->id,
        ]);

        $this->assertDatabaseHas('pemesanan', [
            'id' => $pesanan->id,
            'status' => 'berlangsung', // Karena tahap = dp
        ]);
    }

    public function test_regular_user_cannot_verify_payment()
    {
        $user = User::factory()->create();
        $user->assignRole('user'); // Bukan admin

        $pesanan = Pemesanan::create([
            'kode_pemesanan' => 'PMB-PAY04',
            'user_id' => $user->id,
            'tanggal_pemesanan' => now()->toDateString(),
            'tanggal_pakai' => now()->addDays(2)->toDateString(),
            'jenis' => 'acara',
            'no_hp' => '081234567890',
            'total_harga' => 500000,
            'status' => 'dikonfirmasi',
        ]);

        $pembayaran = Pembayaran::create([
            'kode_transaksi' => 'TRX-TEST02',
            'pemesanan_id' => $pesanan->id,
            'tahap' => 'dp',
            'jumlah_bayar' => 250000,
            'metode_pembayaran' => 'midtrans',
            'status' => 'menunggu',
            'dibayar_pada' => null,
        ]);

        $response = $this->actingAs($user)->patch(route('admin.pembayaran.verifikasi', $pembayaran->id));

        $response->assertStatus(403); // Unauthorized atau dilarang oleh middleware role

        $this->assertDatabaseHas('pembayaran', [
            'id' => $pembayaran->id,
            'status' => 'menunggu', // Tidak berubah
        ]);
    }
}

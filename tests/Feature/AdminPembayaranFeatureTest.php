<?php

namespace Tests\Feature;

use App\Models\Pembayaran;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\Support\CreatesTestData;
use Tests\TestCase;

class AdminPembayaranFeatureTest extends TestCase
{
    use RefreshDatabase;
    use CreatesTestData;

    public function test_admin_can_open_pembayaran_index_and_detail(): void
    {
        $admin = $this->makeAdmin();
        $user = $this->makeUser(['email' => 'pay-user@example.com']);
        $pemesanan = $this->makeSewaPemesanan($user);
        $pembayaran = Pembayaran::factory()->create([
            'pemesanan_id' => $pemesanan->id,
            'bukti_pembayaran_path' => 'bukti-pembayaran/test.jpg',
            'status' => 'menunggu',
        ]);

        $this->actingAs($admin)
            ->get(route('admin.pembayaran.index'))
            ->assertOk();

        $this->actingAs($admin)
            ->get(route('admin.pembayaran.show', $pembayaran->id))
            ->assertOk();
    }

    public function test_admin_can_verify_dp_payment_and_order_becomes_berlangsung(): void
    {
        $admin = $this->makeAdmin();
        $user = $this->makeUser(['email' => 'dp-user@example.com']);
        $pemesanan = $this->makeSewaPemesanan($user, ['status' => 'dikonfirmasi']);
        $pembayaran = Pembayaran::factory()->dp()->create([
            'pemesanan_id' => $pemesanan->id,
            'bukti_pembayaran_path' => 'bukti-pembayaran/dp.jpg',
            'status' => 'menunggu',
        ]);

        $response = $this->actingAs($admin)
            ->patch(route('admin.pembayaran.verifikasi', $pembayaran->id));

        $response->assertRedirect(route('admin.pembayaran.index'));
        $this->assertDatabaseHas('pembayaran', [
            'id' => $pembayaran->id,
            'status' => 'terverifikasi',
            'diverifikasi_oleh' => $admin->id,
        ]);
        $this->assertDatabaseHas('pemesanan', [
            'id' => $pemesanan->id,
            'status' => 'berlangsung',
        ]);
    }

    public function test_admin_can_verify_pelunasan_payment_and_order_becomes_selesai(): void
    {
        $admin = $this->makeAdmin();
        $user = $this->makeUser(['email' => 'pelunasan-user@example.com']);
        $pemesanan = $this->makeSewaPemesanan($user, ['status' => 'berlangsung']);
        $pembayaran = Pembayaran::factory()->create([
            'pemesanan_id' => $pemesanan->id,
            'tahap' => 'pelunasan',
            'bukti_pembayaran_path' => 'bukti-pembayaran/lunas.jpg',
            'status' => 'menunggu',
        ]);

        $this->actingAs($admin)
            ->patch(route('admin.pembayaran.verifikasi', $pembayaran->id))
            ->assertRedirect(route('admin.pembayaran.index'));

        $this->assertDatabaseHas('pemesanan', [
            'id' => $pemesanan->id,
            'status' => 'selesai',
        ]);
    }

    public function test_admin_can_reject_payment_with_reason(): void
    {
        $admin = $this->makeAdmin();
        $user = $this->makeUser(['email' => 'reject-payment-user@example.com']);
        $pemesanan = $this->makeSewaPemesanan($user);
        $pembayaran = Pembayaran::factory()->create([
            'pemesanan_id' => $pemesanan->id,
            'bukti_pembayaran_path' => 'bukti-pembayaran/reject.jpg',
            'status' => 'menunggu',
        ]);

        $response = $this->actingAs($admin)->patch(route('admin.pembayaran.tolak', $pembayaran->id), [
            'catatan_penolakan' => 'Nominal transfer tidak sesuai.',
        ]);

        $response->assertRedirect(route('admin.pembayaran.index'));
        $this->assertDatabaseHas('pembayaran', [
            'id' => $pembayaran->id,
            'status' => 'ditolak',
            'catatan_penolakan' => 'Nominal transfer tidak sesuai.',
        ]);
    }

    public function test_reject_payment_requires_reason(): void
    {
        $admin = $this->makeAdmin();
        $user = $this->makeUser(['email' => 'validation-payment-user@example.com']);
        $pemesanan = $this->makeSewaPemesanan($user);
        $pembayaran = Pembayaran::factory()->create(['pemesanan_id' => $pemesanan->id]);

        $response = $this->actingAs($admin)
            ->from(route('admin.pembayaran.show', $pembayaran->id))
            ->patch(route('admin.pembayaran.tolak', $pembayaran->id), []);

        $response->assertRedirect(route('admin.pembayaran.show', $pembayaran->id));
        $response->assertSessionHasErrors('catatan_penolakan');
    }
}

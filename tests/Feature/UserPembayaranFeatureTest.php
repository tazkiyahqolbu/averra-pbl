<?php

namespace Tests\Feature;

use App\Models\Pembayaran;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\Feature\Support\CreatesTestData;
use Tests\TestCase;

class UserPembayaranFeatureTest extends TestCase
{
    use RefreshDatabase;
    use CreatesTestData;

    public function test_user_can_upload_payment_proof_for_active_payment(): void
    {
        Storage::fake('public');

        $user = $this->makeUser();
        $pemesanan = $this->makeSewaPemesanan($user);
        $pembayaran = Pembayaran::factory()->create([
            'pemesanan_id' => $pemesanan->id,
            'status' => 'menunggu',
            'bukti_pembayaran_path' => null,
        ]);

        $response = $this->actingAs($user)->post(route('user.pembayaran.upload'), [
            'pemesanan_id' => $pemesanan->id,
            'bukti_pembayaran' => UploadedFile::fake()->image('bukti-transfer.jpg'),
        ]);

        $response->assertRedirect(route('user.pemesanan.show', $pemesanan->id));
        $pembayaran->refresh();
        $this->assertNotNull($pembayaran->bukti_pembayaran_path);
        $this->assertEquals('menunggu', $pembayaran->status);
        Storage::disk('public')->assertExists($pembayaran->bukti_pembayaran_path);
    }

    public function test_user_can_upload_again_when_payment_was_rejected(): void
    {
        Storage::fake('public');

        $user = $this->makeUser();
        $pemesanan = $this->makeSewaPemesanan($user);
        $pembayaran = Pembayaran::factory()->ditolak()->create([
            'pemesanan_id' => $pemesanan->id,
            'catatan_penolakan' => 'Bukti tidak jelas',
        ]);

        $this->actingAs($user)->post(route('user.pembayaran.upload'), [
            'pemesanan_id' => $pemesanan->id,
            'bukti_pembayaran' => UploadedFile::fake()->image('bukti-baru.png'),
        ])->assertRedirect(route('user.pemesanan.show', $pemesanan->id));

        $pembayaran->refresh();
        $this->assertEquals('menunggu', $pembayaran->status);
        $this->assertNull($pembayaran->catatan_penolakan);
        $this->assertNotNull($pembayaran->bukti_pembayaran_path);
    }

    public function test_upload_payment_proof_requires_valid_file(): void
    {
        $user = $this->makeUser();
        $pemesanan = $this->makeSewaPemesanan($user);

        $response = $this->actingAs($user)
            ->from(route('user.pemesanan.show', $pemesanan->id))
            ->post(route('user.pembayaran.upload'), [
                'pemesanan_id' => $pemesanan->id,
            ]);

        $response->assertRedirect(route('user.pemesanan.show', $pemesanan->id));
        $response->assertSessionHasErrors('bukti_pembayaran');
    }

    public function test_user_cannot_upload_payment_for_other_user_pemesanan(): void
    {
        Storage::fake('public');

        $owner = $this->makeUser(['email' => 'pemilik@example.com']);
        $other = $this->makeUser(['email' => 'orang-lain@example.com']);
        $pemesanan = $this->makeSewaPemesanan($owner);
        Pembayaran::factory()->create(['pemesanan_id' => $pemesanan->id]);

        $this->actingAs($other)->post(route('user.pembayaran.upload'), [
            'pemesanan_id' => $pemesanan->id,
            'bukti_pembayaran' => UploadedFile::fake()->image('bukti.png'),
        ])->assertNotFound();
    }

    public function test_upload_creates_pelunasan_when_dp_already_verified(): void
    {
        Storage::fake('public');

        $user = $this->makeUser();
        $pemesanan = $this->makeSewaPemesanan($user, ['total_harga' => 1000000]);
        Pembayaran::factory()->dp()->terverifikasi()->create([
            'pemesanan_id' => $pemesanan->id,
            'jumlah_bayar' => 500000,
        ]);

        $this->actingAs($user)->post(route('user.pembayaran.upload'), [
            'pemesanan_id' => $pemesanan->id,
            'bukti_pembayaran' => UploadedFile::fake()->image('pelunasan.jpg'),
        ])->assertRedirect(route('user.pemesanan.show', $pemesanan->id));

        $this->assertDatabaseHas('pembayaran', [
            'pemesanan_id' => $pemesanan->id,
            'tahap' => 'pelunasan',
            'jumlah_bayar' => 500000,
            'status' => 'menunggu',
        ]);
    }
}

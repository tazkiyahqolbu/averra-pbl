<?php

namespace Tests\Feature;

use App\Models\Pemesanan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\Support\CreatesTestData;
use Tests\TestCase;

class AdminPemesananFeatureTest extends TestCase
{
    use RefreshDatabase;
    use CreatesTestData;

    public function test_admin_can_open_pemesanan_index_and_detail(): void
    {
        $admin = $this->makeAdmin();
        $user = $this->makeUser(['email' => 'customer@example.com']);
        $pemesanan = Pemesanan::factory()->create(['user_id' => $user->id]);

        $this->actingAs($admin)
            ->get(route('admin.pemesanan.index'))
            ->assertOk();

        $this->actingAs($admin)
            ->get(route('admin.pemesanan.show', $pemesanan->id))
            ->assertOk();
    }

    public function test_admin_can_filter_pemesanan_by_status(): void
    {
        $admin = $this->makeAdmin();
        $user = $this->makeUser(['email' => 'filter-user@example.com']);
        Pemesanan::factory()->create(['user_id' => $user->id, 'status' => 'menunggu']);
        Pemesanan::factory()->create(['user_id' => $user->id, 'status' => 'dibatalkan']);

        $this->actingAs($admin)
            ->get(route('admin.pemesanan.index', ['status' => 'menunggu']))
            ->assertOk();
    }

    public function test_admin_can_confirm_pemesanan(): void
    {
        $admin = $this->makeAdmin();
        $user = $this->makeUser(['email' => 'confirm-user@example.com']);
        $pemesanan = Pemesanan::factory()->create([
            'user_id' => $user->id,
            'status' => 'menunggu',
        ]);

        $response = $this->actingAs($admin)
            ->patch(route('admin.pemesanan.konfirmasi', $pemesanan->id));

        $response->assertRedirect(route('admin.pemesanan.index'));
        $this->assertDatabaseHas('pemesanan', [
            'id' => $pemesanan->id,
            'status' => 'dikonfirmasi',
        ]);
    }

    public function test_admin_can_reject_pemesanan(): void
    {
        $admin = $this->makeAdmin();
        $user = $this->makeUser(['email' => 'reject-user@example.com']);
        $pemesanan = Pemesanan::factory()->create([
            'user_id' => $user->id,
            'status' => 'menunggu',
        ]);

        $response = $this->actingAs($admin)
            ->patch(route('admin.pemesanan.tolak', $pemesanan->id));

        $response->assertRedirect(route('admin.pemesanan.index'));
        $this->assertDatabaseHas('pemesanan', [
            'id' => $pemesanan->id,
            'status' => 'dibatalkan',
        ]);
    }
}

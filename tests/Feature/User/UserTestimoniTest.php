<?php

namespace Tests\Feature\User;

use App\Models\User;
use App\Models\Pemesanan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class UserTestimoniTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        Role::firstOrCreate(['name' => 'user']);
        $this->user = User::factory()->create();
        $this->user->assignRole('user');
    }

    public function test_user_can_access_testimoni_create_page()
    {
        $pesanan = Pemesanan::create([
            'kode_pemesanan' => 'PMB-001',
            'user_id' => $this->user->id,
            'tanggal_pemesanan' => now()->toDateString(),
            'tanggal_pakai' => now()->addDays(2)->toDateString(),
            'jenis' => 'sewa_barang',
            'no_hp' => '0812',
            'total_harga' => 100000,
            'status' => 'selesai',
        ]);

        $response = $this->actingAs($this->user)->get(route('testimoni.create', $pesanan->id));
        $response->assertStatus(200);
        $response->assertViewIs('user.testimoni.create');
    }

    public function test_user_can_submit_testimoni()
    {
        $pesanan = Pemesanan::create([
            'kode_pemesanan' => 'PMB-001',
            'user_id' => $this->user->id,
            'tanggal_pemesanan' => now()->toDateString(),
            'tanggal_pakai' => now()->addDays(2)->toDateString(),
            'jenis' => 'sewa_barang',
            'no_hp' => '0812',
            'total_harga' => 100000,
            'status' => 'selesai',
        ]);

        $response = $this->actingAs($this->user)->post(route('testimoni.store', $pesanan->id), [
            'rating' => 5,
            'isi_testimoni' => 'Pelayanan sangat bagus dan memuaskan.',
        ]);

        $response->assertRedirect(route('user.pemesanan.invoice', $pesanan->id));
        $this->assertDatabaseHas('testimoni', [
            'pemesanan_id' => $pesanan->id,
            'rating' => 5,
        ]);
    }
}

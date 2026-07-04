<?php

namespace Tests\Feature\User;

use App\Models\User;
use App\Models\Pemesanan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class UserPemesananHistoryTest extends TestCase
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

    public function test_user_can_access_pemesanan_history()
    {
        $response = $this->actingAs($this->user)->get(route('user.pemesanan.index'));
        $response->assertStatus(200);
        $response->assertViewIs('user.pemesanan.index');
    }

    public function test_user_can_view_pemesanan_detail()
    {
        $pesanan = Pemesanan::create([
            'kode_pemesanan' => 'PMB-001',
            'user_id' => $this->user->id,
            'tanggal_pemesanan' => now()->toDateString(),
            'tanggal_pakai' => now()->addDays(2)->toDateString(),
            'jenis' => 'sewa_barang',
            'no_hp' => '0812',
            'total_harga' => 100000,
            'status' => 'berlangsung', // to bypass invoice redirect
        ]);

        $response = $this->actingAs($this->user)->get(route('user.pemesanan.show', $pesanan->id));
        $response->assertStatus(200);
        $response->assertViewIs('user.pemesanan.show');
    }
}

<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use App\Models\Testimoni;
use App\Models\Pemesanan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class AdminTestimoniTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;

    protected function setUp(): void
    {
        parent::setUp();
        Role::firstOrCreate(['name' => 'admin']);
        $this->admin = User::factory()->create();
        $this->admin->assignRole('admin');
    }

    public function test_admin_can_access_testimoni_list()
    {
        $response = $this->actingAs($this->admin)->get(route('admin.testimoni.index'));
        $response->assertStatus(200);
        $response->assertViewIs('admin.testimoni.index');
        $response->assertViewHas('testimonis');
    }

    public function test_admin_can_reply_testimoni()
    {
        $user = User::factory()->create();
        $pesanan = Pemesanan::create([
            'kode_pemesanan' => 'PMB-001',
            'user_id' => $user->id,
            'tanggal_pemesanan' => now()->toDateString(),
            'tanggal_pakai' => now()->addDays(2)->toDateString(),
            'jenis' => 'acara',
            'no_hp' => '0812',
            'total_harga' => 100000,
            'status' => 'selesai',
        ]);
        $testimoni = Testimoni::create([
            'pemesanan_id' => $pesanan->id,
            'user_id' => $user->id,
            'rating' => 5,
            'isi_testimoni' => 'Bagus',
        ]);

        $response = $this->actingAs($this->admin)->patch(route('admin.testimoni.balas', $testimoni->id), [
            'dibalas' => 'Terima kasih',
        ]);

        $response->assertStatus(302);
        $this->assertDatabaseHas('testimoni', ['id' => $testimoni->id, 'dibalas' => 'Terima kasih']);
    }
}

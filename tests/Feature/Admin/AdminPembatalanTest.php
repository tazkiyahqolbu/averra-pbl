<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use App\Models\Pemesanan;
use App\Models\Pembatalan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Spatie\Permission\Models\Role;
use Tests\TestCase;
use App\Mail\PembatalanDisetujuiMail;
use App\Mail\PembatalanDitolakMail;

class AdminPembatalanTest extends TestCase
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

    public function test_admin_can_access_pembatalan_list()
    {
        $response = $this->actingAs($this->admin)->get(route('admin.pembatalan.index'));
        $response->assertStatus(200);
        $response->assertViewIs('admin.pembatalan.index');
    }

    public function test_admin_can_approve_pembatalan()
    {
        Mail::fake();

        $user = User::factory()->create();
        $pesanan = Pemesanan::create([
            'kode_pemesanan' => 'PMB-001',
            'user_id' => $user->id,
            'tanggal_pemesanan' => now()->toDateString(),
            'tanggal_pakai' => now()->addDays(2)->toDateString(),
            'jenis' => 'acara',
            'no_hp' => '0812',
            'total_harga' => 100000,
            'status' => 'menunggu_diambil',
        ]);

        $pembatalan = Pembatalan::create([
            'pemesanan_id' => $pesanan->id,
            'user_id' => $user->id,
            'alasan' => 'Tes Batal',
            'status' => 'menunggu',
        ]);

        $response = $this->actingAs($this->admin)->patch(route('admin.pembatalan.setujui', $pembatalan->id), [
            'catatan_admin' => 'Disetujui',
        ]);

        $response->assertStatus(302);
        $this->assertDatabaseHas('pembatalan', ['id' => $pembatalan->id, 'status' => 'disetujui']);
        $this->assertDatabaseHas('pemesanan', ['id' => $pesanan->id, 'status' => 'dibatalkan']);
        Mail::assertQueued(PembatalanDisetujuiMail::class);
    }

    public function test_admin_can_reject_pembatalan()
    {
        Mail::fake();

        $user = User::factory()->create();
        $pesanan = Pemesanan::create([
            'kode_pemesanan' => 'PMB-001',
            'user_id' => $user->id,
            'tanggal_pemesanan' => now()->toDateString(),
            'tanggal_pakai' => now()->addDays(2)->toDateString(),
            'jenis' => 'acara',
            'no_hp' => '0812',
            'total_harga' => 100000,
            'status' => 'menunggu_diambil',
        ]);

        $pembatalan = Pembatalan::create([
            'pemesanan_id' => $pesanan->id,
            'user_id' => $user->id,
            'alasan' => 'Tes Batal',
            'status' => 'menunggu',
        ]);

        $response = $this->actingAs($this->admin)->patch(route('admin.pembatalan.tolak', $pembatalan->id), [
            'catatan_admin' => 'Alasan tolak wajib 10 karakter',
        ]);

        $response->assertStatus(302);
        $this->assertDatabaseHas('pembatalan', ['id' => $pembatalan->id, 'status' => 'ditolak']);
        Mail::assertQueued(PembatalanDitolakMail::class);
    }
}

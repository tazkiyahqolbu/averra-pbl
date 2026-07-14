<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use App\Models\Pemesanan;
use App\Models\DetailPemesanan;
use App\Models\PengembalianBarang;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class AdminPengembalianBarangTest extends TestCase
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

    public function test_admin_can_access_pengembalian_list()
    {
        $response = $this->actingAs($this->admin)->get(route('admin.pengembalian.index'));
        $response->assertStatus(200);
        $response->assertViewIs('admin.pengembalian.index');
    }

    public function test_admin_can_update_pengembalian_condition()
    {
        $user = User::factory()->create();
        $pesanan = Pemesanan::create([
            'kode_pemesanan' => 'PMB-001',
            'user_id' => $user->id,
            'tanggal_pemesanan' => now()->toDateString(),
            'tanggal_pakai' => now()->addDays(2)->toDateString(),
            'jenis' => 'sewa_barang',
            'no_hp' => '0812',
            'total_harga' => 100000,
            'status' => 'berlangsung',
        ]);
        
        $detail = DetailPemesanan::create([
            'pemesanan_id' => $pesanan->id,
            'jenis_item' => 'barang',
            'jumlah' => 1,
            'harga' => 100000,
            'subtotal' => 100000,
            'tanggal_ambil' => now()->toDateString(),
            'tanggal_kembali' => now()->addDays(2)->toDateString(),
        ]);

        $pengembalian = PengembalianBarang::create([
            'detail_pemesanan_id' => $detail->id,
            'tanggal_kembali_aktual' => now()->toDateString(),
            'denda_keterlambatan' => 0,
            'status_pengembalian' => 'diperiksa',
        ]);

        $response = $this->actingAs($this->admin)->put(route('admin.pengembalian.update', $pengembalian->id), [
            'kondisi' => 'baik',
            'denda_kerusakan' => 0,
        ]);

        $response->assertStatus(302);
        $this->assertDatabaseHas('pengembalian_barang', [
            'id' => $pengembalian->id,
            'kondisi' => 'baik',
            'status_pengembalian' => 'selesai',
        ]);
    }
}

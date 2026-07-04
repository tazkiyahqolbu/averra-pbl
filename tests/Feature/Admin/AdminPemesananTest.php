<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use App\Models\Pemesanan;
use App\Models\DetailPemesanan;
use App\Models\Barang;
use App\Models\KategoriBarang;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class AdminPemesananTest extends TestCase
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

    public function test_admin_can_access_pemesanan_list()
    {
        $response = $this->actingAs($this->admin)->get(route('admin.pemesanan.index'));
        $response->assertStatus(200);
        $response->assertViewIs('admin.pemesanan.index');
    }

    public function test_admin_can_view_pemesanan_detail()
    {
        $user = User::factory()->create();
        $pesanan = Pemesanan::create([
            'kode_pemesanan' => 'PMB-111',
            'user_id' => $user->id,
            'tanggal_pemesanan' => now()->toDateString(),
            'tanggal_pakai' => now()->addDays(2)->toDateString(),
            'jenis' => 'acara',
            'no_hp' => '0812',
            'total_harga' => 100000,
            'status' => 'menunggu',
        ]);

        $response = $this->actingAs($this->admin)->get(route('admin.pemesanan.show', $pesanan->id));
        $response->assertStatus(200);
        $response->assertViewIs('admin.pemesanan.show');
    }

    public function test_admin_can_konfirmasi_pemesanan()
    {
        $user = User::factory()->create();
        $pesanan = Pemesanan::create([
            'kode_pemesanan' => 'PMB-222',
            'user_id' => $user->id,
            'tanggal_pemesanan' => now()->toDateString(),
            'tanggal_pakai' => now()->addDays(2)->toDateString(),
            'jenis' => 'acara',
            'no_hp' => '0812',
            'total_harga' => 100000,
            'status' => 'menunggu',
        ]);

        $response = $this->actingAs($this->admin)->patch(route('admin.pemesanan.konfirmasi', $pesanan->id));
        $response->assertRedirect(route('admin.pemesanan.index'));
        $this->assertDatabaseHas('pemesanan', ['id' => $pesanan->id, 'status' => 'dikonfirmasi']);
    }

    public function test_admin_can_tolak_pemesanan()
    {
        $user = User::factory()->create();
        $pesanan = Pemesanan::create([
            'kode_pemesanan' => 'PMB-333',
            'user_id' => $user->id,
            'tanggal_pemesanan' => now()->toDateString(),
            'tanggal_pakai' => now()->addDays(2)->toDateString(),
            'jenis' => 'acara',
            'no_hp' => '0812',
            'total_harga' => 100000,
            'status' => 'menunggu',
        ]);

        $response = $this->actingAs($this->admin)->patch(route('admin.pemesanan.tolak', $pesanan->id), [
            'alasan_penolakan' => 'Jadwal sudah penuh',
        ]);
        $response->assertRedirect(route('admin.pemesanan.show', $pesanan->id));
        $this->assertDatabaseHas('pemesanan', ['id' => $pesanan->id, 'status' => 'dibatalkan', 'alasan_penolakan' => 'Jadwal sudah penuh']);
    }

    public function test_admin_can_mark_diambil()
    {
        $user = User::factory()->create();
        $pesanan = Pemesanan::create([
            'kode_pemesanan' => 'PMB-444',
            'user_id' => $user->id,
            'tanggal_pemesanan' => now()->toDateString(),
            'tanggal_pakai' => now()->addDays(2)->toDateString(),
            'jenis' => 'sewa_barang',
            'no_hp' => '0812',
            'total_harga' => 100000,
            'status' => 'menunggu_diambil',
        ]);

        $response = $this->actingAs($this->admin)->patch(route('admin.pemesanan.diambil', $pesanan->id));
        $response->assertRedirect(route('admin.pemesanan.show', $pesanan->id));
        $this->assertDatabaseHas('pemesanan', ['id' => $pesanan->id, 'status' => 'sedang_disewa']);
    }

    public function test_admin_can_mark_dikembalikan()
    {
        $user = User::factory()->create();
        $pesanan = Pemesanan::create([
            'kode_pemesanan' => 'PMB-555',
            'user_id' => $user->id,
            'tanggal_pemesanan' => now()->toDateString(),
            'tanggal_pakai' => now()->addDays(-2)->toDateString(),
            'jenis' => 'sewa_barang',
            'no_hp' => '0812',
            'total_harga' => 100000,
            'status' => 'sedang_disewa',
        ]);

        $kategori = KategoriBarang::create([
            'nama' => 'Tenda'
        ]);

        $barang = Barang::create([
            'kategori_barang_id' => $kategori->id,
            'nama_barang' => 'Tenda Dome',
            'harga' => 50000,
            'tarif_denda_per_hari' => 10000,
            'stok' => 5,
        ]);

        $detail = DetailPemesanan::create([
            'pemesanan_id' => $pesanan->id,
            'barang_id' => $barang->id,
            'jenis_item' => 'barang',
            'tanggal_mulai' => now()->addDays(-2)->toDateString(),
            'tanggal_kembali' => now()->addDays(-1)->toDateString(),
            'harga' => 50000,
            'subtotal' => 100000,
            'jumlah' => 2
        ]);

        $response = $this->actingAs($this->admin)->post(route('admin.pemesanan.dikembalikan', $pesanan->id));
        $response->assertRedirect(route('admin.pemesanan.show', $pesanan->id));
        $this->assertDatabaseHas('pemesanan', ['id' => $pesanan->id, 'status' => 'menunggu_pelunasan']);
        $this->assertDatabaseHas('pengembalian_barang', ['detail_pemesanan_id' => $detail->id]);
    }
}

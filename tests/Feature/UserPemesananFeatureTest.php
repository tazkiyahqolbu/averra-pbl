<?php

namespace Tests\Feature;

use App\Models\DetailPemesanan;
use App\Models\Jasa;
use App\Models\KategoriJasa;
use App\Models\Pemesanan;
use App\Models\Pembayaran;
use App\Models\ZonaLokasi;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\Support\CreatesTestData;
use Tests\TestCase;

class UserPemesananFeatureTest extends TestCase
{
    use RefreshDatabase;
    use CreatesTestData;

    public function test_guest_is_redirected_from_user_pemesanan_page(): void
    {
        $this->get(route('user.pemesanan.index'))->assertRedirect(route('login'));
    }

    public function test_user_can_open_pemesanan_index(): void
    {
        $user = $this->makeUser();
        Pemesanan::factory()->create(['user_id' => $user->id, 'status' => 'menunggu']);

        $this->actingAs($user)
            ->get(route('user.pemesanan.index'))
            ->assertOk();
    }

    public function test_user_can_open_create_acara_page(): void
    {
        $user = $this->makeUser();
        Jasa::factory()->create(['kategori_jasa_id' => KategoriJasa::first()->id, 'aktif' => true]);

        $this->actingAs($user)
            ->get(route('user.pemesanan.create.acara'))
            ->assertOk();
    }

    public function test_user_can_open_create_sewa_page(): void
    {
        $user = $this->makeUser();
        $this->makeAvailableBarang();

        $this->actingAs($user)
            ->get(route('user.pemesanan.create.sewa'))
            ->assertOk();
    }

    public function test_user_can_store_acara_pemesanan_with_jasa(): void
    {
        $user = $this->makeUser();
        $jasa = Jasa::factory()->create([
            'kategori_jasa_id' => KategoriJasa::first()->id,
            'harga' => 750000,
            'aktif' => true,
        ]);
        $zona = ZonaLokasi::first();

        $response = $this->actingAs($user)->post(route('user.pemesanan.store'), [
            'katalog_id' => 'jasa-' . $jasa->id,
            'zona_lokasi_id' => $zona->id,
            'tanggal_pelaksanaan' => now()->addDays(10)->toDateString(),
            'alamat_lengkap' => 'Jl. Testing No. 1 Padang',
            'nama_pemesan' => 'Zikra Test',
            'no_hp' => '081234567890',
            'keterangan_acara' => 'Acara pengujian',
            'metode_bayar' => 'dp',
            'total_harga' => 750000,
        ]);

        $pemesanan = Pemesanan::where('user_id', $user->id)->first();

        $response->assertRedirect(route('user.pemesanan.show', $pemesanan->id));
        $this->assertDatabaseHas('pemesanan', [
            'id' => $pemesanan->id,
            'user_id' => $user->id,
            'jenis' => 'acara',
            'status' => 'menunggu',
        ]);
        $this->assertDatabaseHas('detail_pemesanan', [
            'pemesanan_id' => $pemesanan->id,
            'jenis_item' => 'jasa',
            'jasa_id' => $jasa->id,
        ]);
        $this->assertDatabaseHas('pembayaran', [
            'pemesanan_id' => $pemesanan->id,
            'tahap' => 'dp',
            'status' => 'menunggu',
        ]);
    }

    public function test_user_can_store_sewa_barang_pemesanan_and_calculate_subtotal(): void
    {
        $user = $this->makeUser();
        $barang = $this->makeAvailableBarang(['harga' => 100000]);

        $response = $this->actingAs($user)->post(route('user.pemesanan.store'), [
            'katalog_id' => 'barang-' . $barang->id,
            'tanggal_ambil' => now()->addDays(5)->toDateString(),
            'tanggal_kembali' => now()->addDays(7)->toDateString(),
            'jumlah_unit' => 2,
            'alamat_lengkap' => 'Jl. Testing Sewa',
            'nama_pemesan' => 'Penyewa Test',
            'no_hp' => '081234567891',
            'metode_bayar' => 'lunas',
            'total_harga' => 0,
        ]);

        $pemesanan = Pemesanan::where('user_id', $user->id)->first();

        $response->assertRedirect(route('user.pemesanan.show', $pemesanan->id));
        $this->assertDatabaseHas('pemesanan', [
            'id' => $pemesanan->id,
            'jenis' => 'sewa_barang',
            'total_harga' => 600000,
        ]);
        $this->assertDatabaseHas('detail_pemesanan', [
            'pemesanan_id' => $pemesanan->id,
            'jenis_item' => 'barang',
            'barang_id' => $barang->id,
            'jumlah' => 2,
            'subtotal' => 600000,
        ]);
        $this->assertDatabaseHas('pembayaran', [
            'pemesanan_id' => $pemesanan->id,
            'tahap' => 'langsung',
            'jumlah_bayar' => 600000,
        ]);
    }

    public function test_store_pemesanan_requires_katalog_and_total_harga(): void
    {
        $user = $this->makeUser();

        $response = $this->actingAs($user)
            ->from(route('user.pemesanan.create.acara'))
            ->post(route('user.pemesanan.store'), []);

        $response->assertRedirect(route('user.pemesanan.create.acara'));
        $response->assertSessionHasErrors(['katalog_id', 'total_harga']);
    }

    public function test_user_can_only_see_own_pemesanan_detail(): void
    {
        $owner = $this->makeUser(['email' => 'owner@example.com']);
        $other = $this->makeUser(['email' => 'other@example.com']);
        $pemesanan = Pemesanan::factory()->create(['user_id' => $owner->id]);

        $this->actingAs($other)
            ->get(route('user.pemesanan.show', $pemesanan->id))
            ->assertNotFound();
    }

    public function test_user_can_open_invoice_for_own_pemesanan(): void
    {
        $user = $this->makeUser();
        $pemesanan = Pemesanan::factory()->create(['user_id' => $user->id]);
        Pembayaran::factory()->create(['pemesanan_id' => $pemesanan->id]);

        $this->actingAs($user)
            ->get(route('user.pemesanan.invoice', $pemesanan->id))
            ->assertOk();
    }
}

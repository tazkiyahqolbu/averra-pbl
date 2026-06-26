<?php

namespace Tests\Feature;

use App\Models\KategoriPaket;
use App\Models\Paket;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\Feature\Support\CreatesTestData;
use Tests\TestCase;

class AdminPaketFeatureTest extends TestCase
{
    use RefreshDatabase;
    use CreatesTestData;

    public function test_admin_can_open_paket_index_and_create_page(): void
    {
        $admin = $this->makeAdmin();

        $this->actingAs($admin)->get(route('admin.paket.index'))->assertOk();
        $this->actingAs($admin)->get(route('admin.paket.create'))->assertOk();
    }

    public function test_admin_can_store_paket_with_detail_item(): void
    {
        Storage::fake('public');
        $admin = $this->makeAdmin();
        $kategori = KategoriPaket::first();

        $response = $this->actingAs($admin)->post(route('admin.paket.store'), [
            'kategori_paket_id' => $kategori->id,
            'nama_paket' => 'Paket Wedding Test',
            'deskripsi' => 'Deskripsi paket',
            'harga' => 5000000,
            'keterangan_acara' => 'Pernikahan',
            'catatan' => 'Catatan paket',
            'aktif' => '1',
            'thumbnail_path' => UploadedFile::fake()->image('paket.jpg'),
            'nama_item' => ['Tari Pasambahan'],
            'jumlah' => [1],
            'tipe' => ['wajib'],
            'harga_tambahan' => [0],
            'keterangan' => ['Termasuk paket'],
        ]);

        $response->assertRedirect(route('admin.paket.index'));
        $paket = Paket::where('nama_paket', 'Paket Wedding Test')->first();
        $this->assertNotNull($paket);
        $this->assertDatabaseHas('paket_detail', [
            'paket_id' => $paket->id,
            'nama_item' => 'Tari Pasambahan',
            'jumlah' => 1,
        ]);
    }

    public function test_store_paket_requires_required_fields(): void
    {
        $admin = $this->makeAdmin();

        $response = $this->actingAs($admin)
            ->from(route('admin.paket.create'))
            ->post(route('admin.paket.store'), []);

        $response->assertRedirect(route('admin.paket.create'));
        $response->assertSessionHasErrors(['kategori_paket_id', 'nama_paket', 'harga']);
    }

    public function test_admin_can_update_paket(): void
    {
        $admin = $this->makeAdmin();
        $kategori = KategoriPaket::first();
        $paket = Paket::factory()->create([
            'kategori_paket_id' => $kategori->id,
            'nama_paket' => 'Paket Lama',
            'aktif' => true,
        ]);

        $response = $this->actingAs($admin)->put(route('admin.paket.update', $paket->id), [
            'kategori_paket_id' => $kategori->id,
            'nama_paket' => 'Paket Baru',
            'deskripsi' => 'Update paket',
            'harga' => 6500000,
            'keterangan_acara' => 'Acara kantor',
            'catatan' => 'Catatan baru',
        ]);

        $response->assertRedirect(route('admin.paket.index'));
        $this->assertDatabaseHas('paket', [
            'id' => $paket->id,
            'nama_paket' => 'Paket Baru',
            'harga' => 6500000,
            'aktif' => false,
        ]);
    }

    public function test_admin_can_delete_paket(): void
    {
        $admin = $this->makeAdmin();
        $paket = Paket::factory()->create([
            'kategori_paket_id' => KategoriPaket::first()->id,
        ]);

        $this->actingAs($admin)
            ->delete(route('admin.paket.destroy', $paket->id))
            ->assertRedirect(route('admin.paket.index'));

        $this->assertDatabaseMissing('paket', ['id' => $paket->id]);
    }
}

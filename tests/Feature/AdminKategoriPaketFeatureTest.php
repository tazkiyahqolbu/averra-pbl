<?php

namespace Tests\Feature;

use App\Models\KategoriPaket;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\Support\CreatesTestData;
use Tests\TestCase;

class AdminKategoriPaketFeatureTest extends TestCase
{
    use RefreshDatabase;
    use CreatesTestData;

    public function test_admin_can_open_kategori_paket_page(): void
    {
        $admin = $this->makeAdmin();

        $this->actingAs($admin)
            ->get(route('admin.kategori-paket.index'))
            ->assertOk();
    }

    public function test_admin_can_store_kategori_paket(): void
    {
        $admin = $this->makeAdmin();

        $response = $this->actingAs($admin)->post(route('admin.kategori-paket.store'), [
            'nama' => 'Kategori Test',
            'deskripsi' => 'Deskripsi kategori test',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('kategori_paket', [
            'nama' => 'Kategori Test',
            'deskripsi' => 'Deskripsi kategori test',
        ]);
    }

    public function test_store_kategori_paket_requires_nama(): void
    {
        $admin = $this->makeAdmin();

        $response = $this->actingAs($admin)
            ->from(route('admin.kategori-paket.index'))
            ->post(route('admin.kategori-paket.store'), []);

        $response->assertRedirect(route('admin.kategori-paket.index'));
        $response->assertSessionHasErrors('nama');
    }

    public function test_admin_can_update_kategori_paket(): void
    {
        $admin = $this->makeAdmin();
        $kategori = KategoriPaket::first();

        $response = $this->actingAs($admin)->put(route('admin.kategori-paket.update', $kategori->id), [
            'nama' => 'Kategori Update',
            'deskripsi' => 'Deskripsi update',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('kategori_paket', [
            'id' => $kategori->id,
            'nama' => 'Kategori Update',
            'deskripsi' => 'Deskripsi update',
        ]);
    }

    public function test_admin_can_delete_kategori_paket(): void
    {
        $admin = $this->makeAdmin();
        $kategori = KategoriPaket::create([
            'nama' => 'Kategori Hapus',
            'deskripsi' => 'Akan dihapus',
        ]);

        $this->actingAs($admin)
            ->delete(route('admin.kategori-paket.destroy', $kategori->id))
            ->assertRedirect();

        $this->assertDatabaseMissing('kategori_paket', ['id' => $kategori->id]);
    }
}

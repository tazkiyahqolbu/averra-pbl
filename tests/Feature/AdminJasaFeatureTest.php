<?php

namespace Tests\Feature;

use App\Models\Jasa;
use App\Models\KategoriJasa;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\Feature\Support\CreatesTestData;
use Tests\TestCase;

class AdminJasaFeatureTest extends TestCase
{
    use RefreshDatabase;
    use CreatesTestData;

    public function test_admin_can_open_jasa_index_and_create_page(): void
    {
        $admin = $this->makeAdmin();

        $this->actingAs($admin)->get(route('admin.jasa.index'))->assertOk();
        $this->actingAs($admin)->get(route('admin.jasa.create'))->assertOk();
    }

    public function test_admin_can_store_jasa(): void
    {
        Storage::fake('public');
        $admin = $this->makeAdmin();
        $kategori = KategoriJasa::first();

        $response = $this->actingAs($admin)->post(route('admin.jasa.store'), [
            'kategori_jasa_id' => $kategori->id,
            'nama_jasa' => 'Jasa Tari Test',
            'deskripsi' => 'Deskripsi jasa testing',
            'harga' => 1500000,
            'maks_booking_harian' => 4,
            'aktif' => '1',
            'thumbnail_path' => UploadedFile::fake()->image('thumbnail.jpg'),
        ]);

        $response->assertRedirect(route('admin.jasa.index'));
        $this->assertDatabaseHas('jasa', [
            'nama_jasa' => 'Jasa Tari Test',
            'harga' => 1500000,
            'maks_booking_harian' => 4,
            'aktif' => true,
        ]);
    }

    public function test_store_jasa_requires_required_fields(): void
    {
        $admin = $this->makeAdmin();

        $response = $this->actingAs($admin)
            ->from(route('admin.jasa.create'))
            ->post(route('admin.jasa.store'), []);

        $response->assertRedirect(route('admin.jasa.create'));
        $response->assertSessionHasErrors([
            'kategori_jasa_id',
            'nama_jasa',
            'harga',
            'maks_booking_harian',
        ]);
    }

    public function test_admin_can_update_jasa(): void
    {
        $admin = $this->makeAdmin();
        $kategori = KategoriJasa::first();
        $jasa = Jasa::factory()->create([
            'kategori_jasa_id' => $kategori->id,
            'nama_jasa' => 'Nama Lama',
            'aktif' => true,
        ]);

        $response = $this->actingAs($admin)->put(route('admin.jasa.update', $jasa->id), [
            'kategori_jasa_id' => $kategori->id,
            'nama_jasa' => 'Nama Baru',
            'deskripsi' => 'Update deskripsi',
            'harga' => 2000000,
            'maks_booking_harian' => 2,
        ]);

        $response->assertRedirect(route('admin.jasa.index'));
        $this->assertDatabaseHas('jasa', [
            'id' => $jasa->id,
            'nama_jasa' => 'Nama Baru',
            'harga' => 2000000,
            'maks_booking_harian' => 2,
            'aktif' => false,
        ]);
    }

    public function test_admin_can_delete_jasa(): void
    {
        $admin = $this->makeAdmin();
        $jasa = Jasa::factory()->create([
            'kategori_jasa_id' => KategoriJasa::first()->id,
        ]);

        $this->actingAs($admin)
            ->delete(route('admin.jasa.destroy', $jasa->id))
            ->assertRedirect(route('admin.jasa.index'));

        $this->assertDatabaseMissing('jasa', ['id' => $jasa->id]);
    }
}

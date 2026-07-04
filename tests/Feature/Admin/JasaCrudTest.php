<?php

namespace Tests\Feature\Admin;

use App\Models\Jasa;
use App\Models\KategoriJasa;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class JasaCrudTest extends TestCase
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

    public function test_unauthorized_access_is_rejected()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get(route('admin.jasa.index'));
        $response->assertStatus(403);
    }

    public function test_admin_can_read_jasa_list()
    {
        $response = $this->actingAs($this->admin)->get(route('admin.jasa.index'));
        $response->assertStatus(200);
        $response->assertViewIs('admin.jasa.index');
    }

    public function test_admin_can_create_jasa()
    {
        Storage::fake('public');
        $kategori = KategoriJasa::create(['nama' => 'Test', 'deskripsi' => 'Test']);
        
        $response = $this->actingAs($this->admin)->post(route('admin.jasa.store'), [
            'kategori_jasa_id' => $kategori->id,
            'nama_jasa' => 'Fotografi',
            'harga' => 500000,
            'maks_booking_harian' => 2,
            'thumbnail_path' => UploadedFile::fake()->image('thumb.jpg'),
        ]);

        $response->assertRedirect(route('admin.jasa.index'));
        $this->assertDatabaseHas('jasa', ['nama_jasa' => 'Fotografi', 'maks_booking_harian' => 2]);
    }

    public function test_jasa_validation_fails_on_empty_fields()
    {
        $response = $this->actingAs($this->admin)->post(route('admin.jasa.store'), []);
        $response->assertSessionHasErrors(['kategori_jasa_id', 'nama_jasa', 'harga', 'maks_booking_harian']);
    }

    public function test_admin_can_update_jasa()
    {
        $kategori = KategoriJasa::create(['nama' => 'Test', 'deskripsi' => 'Test']);
        $jasa = Jasa::create([
            'kategori_jasa_id' => $kategori->id,
            'nama_jasa' => 'Old',
            'harga' => 100000,
            'maks_booking_harian' => 1,
        ]);

        $response = $this->actingAs($this->admin)->put(route('admin.jasa.update', $jasa->id), [
            'kategori_jasa_id' => $kategori->id,
            'nama_jasa' => 'New',
            'harga' => 200000,
            'maks_booking_harian' => 3,
        ]);

        $response->assertRedirect(route('admin.jasa.index'));
        $this->assertDatabaseHas('jasa', ['id' => $jasa->id, 'nama_jasa' => 'New', 'maks_booking_harian' => 3]);
    }

    public function test_admin_can_delete_jasa()
    {
        $kategori = KategoriJasa::create(['nama' => 'Test', 'deskripsi' => 'Test']);
        $jasa = Jasa::create([
            'kategori_jasa_id' => $kategori->id,
            'nama_jasa' => 'To Delete',
            'harga' => 10,
            'maks_booking_harian' => 1,
        ]);

        $response = $this->actingAs($this->admin)->delete(route('admin.jasa.destroy', $jasa->id));
        $response->assertStatus(302);
        $this->assertDatabaseMissing('jasa', ['id' => $jasa->id]);
    }
}

<?php

namespace Tests\Feature\Admin;

use App\Models\Barang;
use App\Models\KategoriBarang;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class BarangCrudTest extends TestCase
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
        $response = $this->actingAs($user)->get(route('admin.barang.index'));
        $response->assertStatus(403);
    }

    public function test_admin_can_read_barang_list()
    {
        $response = $this->actingAs($this->admin)->get(route('admin.barang.index'));
        $response->assertStatus(200);
        $response->assertViewIs('admin.barang.index');
    }

    public function test_admin_can_create_barang()
    {
        Storage::fake('public');
        $kategori = KategoriBarang::create(['nama' => 'Test', 'deskripsi' => 'Test']);
        
        $response = $this->actingAs($this->admin)->post(route('admin.barang.store'), [
            'kategori_barang_id' => $kategori->id,
            'nama_barang' => 'Kursi',
            'harga' => 5000,
            'nilai_barang' => 100000,
            'stok' => 50,
            'thumbnail_path' => UploadedFile::fake()->image('thumb.jpg'),
        ]);

        $response->assertRedirect(route('admin.barang.index'));
        $this->assertDatabaseHas('barang', ['nama_barang' => 'Kursi', 'stok' => 50]);
    }

    public function test_barang_validation_fails_on_empty_fields()
    {
        $response = $this->actingAs($this->admin)->post(route('admin.barang.store'), []);
        $response->assertSessionHasErrors(['kategori_barang_id', 'nama_barang', 'harga', 'nilai_barang', 'stok']);
    }

    public function test_admin_can_update_barang()
    {
        $kategori = KategoriBarang::create(['nama' => 'Test', 'deskripsi' => 'Test']);
        $barang = Barang::create([
            'kategori_barang_id' => $kategori->id,
            'nama_barang' => 'Old',
            'harga' => 10,
            'nilai_barang' => 10,
            'stok' => 10,
        ]);

        $response = $this->actingAs($this->admin)->put(route('admin.barang.update', $barang->id), [
            'kategori_barang_id' => $kategori->id,
            'nama_barang' => 'New',
            'harga' => 20,
            'nilai_barang' => 20,
            'stok' => 20,
            'aktif' => 1,
        ]);

        $response->assertRedirect(route('admin.barang.index'));
        $this->assertDatabaseHas('barang', ['id' => $barang->id, 'nama_barang' => 'New']);
    }

    public function test_admin_can_delete_barang()
    {
        $kategori = KategoriBarang::create(['nama' => 'Test', 'deskripsi' => 'Test']);
        $barang = Barang::create([
            'kategori_barang_id' => $kategori->id,
            'nama_barang' => 'To Delete',
            'harga' => 10,
            'nilai_barang' => 10,
            'stok' => 10,
        ]);

        $response = $this->actingAs($this->admin)->delete(route('admin.barang.destroy', $barang->id));
        $response->assertStatus(302);
        $this->assertDatabaseMissing('barang', ['id' => $barang->id]);
    }
}

<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use App\Models\KategoriBarang;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class KategoriCrudTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Role::firstOrCreate(['name' => 'admin']);
        Role::firstOrCreate(['name' => 'user']);
    }

    private function getAdmin()
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');
        return $admin;
    }

    private function getUser()
    {
        $user = User::factory()->create();
        $user->assignRole('user');
        return $user;
    }

    public function test_unauthorized_access_is_rejected()
    {
        $user = $this->getUser();
        $response = $this->actingAs($user)->get(route('admin.kategori.index', 'barang'));
        $response->assertStatus(403);
    }

    public function test_admin_can_read_kategori_list()
    {
        $admin = $this->getAdmin();
        KategoriBarang::create(['nama' => 'Alat Camping', 'deskripsi' => 'Untuk camping']);

        $response = $this->actingAs($admin)->get(route('admin.kategori.index', 'barang'));
        $response->assertStatus(200);
        $response->assertSee('Alat Camping');
    }

    public function test_admin_can_create_kategori()
    {
        $admin = $this->getAdmin();

        $response = $this->actingAs($admin)->post(route('admin.kategori.store', 'barang'), [
            'nama' => 'Elektronik',
            'deskripsi' => 'Barang elektronik',
        ]);

        $response->assertRedirect(route('admin.kategori.index', 'barang'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('kategori_barang', [
            'nama' => 'Elektronik',
            'deskripsi' => 'Barang elektronik',
        ]);
    }

    public function test_kategori_validation_fails_on_empty_name()
    {
        $admin = $this->getAdmin();
        $response = $this->actingAs($admin)->post(route('admin.kategori.store', 'barang'), []);
        
        $response->assertSessionHasErrors(['nama']);
    }

    public function test_admin_can_update_kategori()
    {
        $admin = $this->getAdmin();
        $kategori = KategoriBarang::create(['nama' => 'Lama', 'deskripsi' => 'Desc lama']);

        $response = $this->actingAs($admin)->put(route('admin.kategori.update', ['tipe' => 'barang', 'id' => $kategori->id]), [
            'nama' => 'Baru',
            'deskripsi' => 'Desc baru',
        ]);

        $response->assertRedirect(route('admin.kategori.index', 'barang'));
        $this->assertDatabaseHas('kategori_barang', [
            'id' => $kategori->id,
            'nama' => 'Baru',
            'deskripsi' => 'Desc baru',
        ]);
    }

    public function test_admin_can_delete_kategori()
    {
        $admin = $this->getAdmin();
        $kategori = KategoriBarang::create(['nama' => 'Dihapus', 'deskripsi' => 'Akan dihapus']);

        $response = $this->actingAs($admin)->delete(route('admin.kategori.destroy', ['tipe' => 'barang', 'id' => $kategori->id]));

        $response->assertRedirect();
        $this->assertDatabaseMissing('kategori_barang', [
            'id' => $kategori->id,
        ]);
    }
    
    public function test_invalid_tipe_returns_404()
    {
        $admin = $this->getAdmin();
        $response = $this->actingAs($admin)->get(route('admin.kategori.index', 'invalid_tipe'));
        $response->assertStatus(404);
    }
}

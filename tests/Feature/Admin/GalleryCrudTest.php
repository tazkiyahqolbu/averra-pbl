<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use App\Models\Galeri;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class GalleryCrudTest extends TestCase
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
        $response = $this->actingAs($user)->get(route('admin.galeri.index'));
        $response->assertStatus(403);
    }

    public function test_admin_can_read_galeri_list()
    {
        $admin = $this->getAdmin();
        Galeri::create([
            'judul' => 'Foto Acara',
            'jenis_media' => 'foto',
            'media_path' => 'galeri/foto.jpg',
            'unggulan' => false,
        ]);

        $response = $this->actingAs($admin)->get(route('admin.galeri.index'));
        $response->assertStatus(200);
        $response->assertSee('Foto Acara');
    }

    public function test_admin_can_create_galeri()
    {
        $admin = $this->getAdmin();
        Storage::fake('public');
        $media = UploadedFile::fake()->image('gambar.jpg');

        $response = $this->actingAs($admin)->post(route('admin.galeri.store'), [
            'judul' => 'Koleksi Baru',
            'kategori' => 'Wedding',
            'media_path' => $media,
            'jenis_media' => 'foto',
            'keterangan' => 'Foto bagus',
            'unggulan' => 1,
        ]);

        $response->assertRedirect(route('admin.galeri.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('galeri', [
            'judul' => 'Koleksi Baru',
            'jenis_media' => 'foto',
            'unggulan' => 1,
        ]);
        
        $galeri = Galeri::where('judul', 'Koleksi Baru')->first();
        Storage::disk('public')->assertExists($galeri->media_path);
    }

    public function test_galeri_validation_fails_on_empty_fields()
    {
        $admin = $this->getAdmin();
        $response = $this->actingAs($admin)->post(route('admin.galeri.store'), []);
        
        $response->assertSessionHasErrors(['judul', 'media_path', 'jenis_media']);
    }

    public function test_admin_can_update_galeri()
    {
        $admin = $this->getAdmin();
        $galeri = Galeri::create([
            'judul' => 'Judul Lama',
            'jenis_media' => 'foto',
            'media_path' => 'galeri/lama.jpg',
            'unggulan' => false,
        ]);

        $response = $this->actingAs($admin)->put(route('admin.galeri.update', $galeri->id), [
            'judul' => 'Judul Baru',
            'jenis_media' => 'foto',
            // media_path is optional on update
            'unggulan' => 1,
        ]);

        $response->assertRedirect(route('admin.galeri.index'));
        $this->assertDatabaseHas('galeri', [
            'id' => $galeri->id,
            'judul' => 'Judul Baru',
            'unggulan' => 1,
        ]);
    }

    public function test_admin_can_delete_galeri()
    {
        $admin = $this->getAdmin();
        $galeri = Galeri::create([
            'judul' => 'Akan Dihapus',
            'jenis_media' => 'foto',
            'media_path' => 'galeri/hapus.jpg',
            'unggulan' => false,
        ]);

        $response = $this->actingAs($admin)->delete(route('admin.galeri.destroy', $galeri->id));

        $response->assertRedirect();
        $this->assertDatabaseMissing('galeri', [
            'id' => $galeri->id,
        ]);
    }
}

<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use App\Models\Paket;
use App\Models\KategoriPaket;
use App\Models\Jasa;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class PaketCrudTest extends TestCase
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
        $response = $this->actingAs($user)->get(route('admin.paket.index'));
        $response->assertStatus(403);
    }

    public function test_admin_can_read_paket_list()
    {
        $admin = $this->getAdmin();
        $kategori = KategoriPaket::create(['nama' => 'Pernikahan']);
        Paket::create([
            'kategori_paket_id' => $kategori->id,
            'nama_paket' => 'Paket Hemat',
            'harga' => 5000000,
            'aktif' => true,
        ]);

        $response = $this->actingAs($admin)->get(route('admin.paket.index'));
        $response->assertStatus(200);
        $response->assertSee('Paket Hemat');
    }

    public function test_admin_can_create_paket()
    {
        $admin = $this->getAdmin();
        Storage::fake('public');
        $kategori = KategoriPaket::create(['nama' => 'Pernikahan']);
        $jasa = Jasa::create([
            'kategori_jasa_id' => \Illuminate\Support\Facades\DB::table('kategori_jasa')->insertGetId(['nama' => 'Fotografi']),
            'nama_jasa' => 'Foto Wedding',
            'harga' => 1000000,
            'aktif' => true,
        ]);

        $thumbnail = UploadedFile::fake()->image('thumbnail.jpg');

        $response = $this->actingAs($admin)->post(route('admin.paket.store'), [
            'kategori_paket_id' => $kategori->id,
            'nama_paket' => 'Paket Mewah',
            'harga' => 10000000,
            'deskripsi' => 'Deskripsi mewah',
            'keterangan_acara' => 'Pernikahan mewah',
            'catatan' => 'Catatan penting',
            'aktif' => 1,
            'thumbnail_path' => $thumbnail,
            'nama_item' => ['Sewa Gedung'],
            'jasa_id' => [$jasa->id],
            'jumlah' => [1],
            'tipe' => ['wajib'],
            'harga_tambahan' => [0],
            'keterangan' => ['Gedung A'],
        ]);

        $response->assertRedirect(route('admin.paket.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('paket', [
            'nama_paket' => 'Paket Mewah',
            'harga' => 10000000,
        ]);
        
        $paket = Paket::where('nama_paket', 'Paket Mewah')->first();
        Storage::disk('public')->assertExists($paket->thumbnail_path);
        
        $this->assertDatabaseHas('paket_detail', [
            'paket_id' => $paket->id,
            'nama_item' => 'Sewa Gedung',
        ]);
    }

    public function test_paket_validation_fails_on_empty_fields()
    {
        $admin = $this->getAdmin();
        $response = $this->actingAs($admin)->post(route('admin.paket.store'), []);
        
        $response->assertSessionHasErrors(['kategori_paket_id', 'nama_paket', 'harga']);
    }

    public function test_admin_can_update_paket()
    {
        $admin = $this->getAdmin();
        $kategori = KategoriPaket::create(['nama' => 'Pernikahan']);
        $paket = Paket::create([
            'kategori_paket_id' => $kategori->id,
            'nama_paket' => 'Paket A',
            'harga' => 100000,
            'aktif' => true,
        ]);

        $response = $this->actingAs($admin)->put(route('admin.paket.update', $paket->id), [
            'kategori_paket_id' => $kategori->id,
            'nama_paket' => 'Paket B',
            'harga' => 200000,
            'aktif' => 0,
        ]);

        $response->assertRedirect(route('admin.paket.index'));
        $this->assertDatabaseHas('paket', [
            'id' => $paket->id,
            'nama_paket' => 'Paket B',
            'harga' => 200000,
            'aktif' => 0,
        ]);
    }

    public function test_admin_can_delete_paket()
    {
        $admin = $this->getAdmin();
        $kategori = KategoriPaket::create(['nama' => 'Pernikahan']);
        $paket = Paket::create([
            'kategori_paket_id' => $kategori->id,
            'nama_paket' => 'Paket Hapus',
            'harga' => 100000,
            'aktif' => true,
        ]);

        $response = $this->actingAs($admin)->delete(route('admin.paket.destroy', $paket->id));

        $response->assertRedirect(route('admin.paket.index'));
        $this->assertDatabaseMissing('paket', [
            'id' => $paket->id,
        ]);
    }
}

<?php

namespace Tests\Feature\Admin;

use App\Models\ZonaLokasi;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class ZonaLokasiCrudTest extends TestCase
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
        $response = $this->actingAs($user)->get(route('admin.zona-lokasi.index'));
        $response->assertStatus(403);
    }

    public function test_admin_can_read_zona_list()
    {
        $response = $this->actingAs($this->admin)->get(route('admin.zona-lokasi.index'));
        $response->assertStatus(200);
        $response->assertViewIs('admin.zona-lokasi.index');
    }

    public function test_admin_can_create_zona()
    {
        $response = $this->actingAs($this->admin)->post(route('admin.zona-lokasi.store'), [
            'nama_zona' => 'Luar Kota',
            'biaya' => 50000,
            'persentase' => 10,
        ]);

        $response->assertRedirect(route('admin.zona-lokasi.index'));
        $this->assertDatabaseHas('zona_lokasi', ['nama_zona' => 'Luar Kota', 'biaya' => 50000]);
    }

    public function test_zona_validation_fails_on_empty_fields()
    {
        $response = $this->actingAs($this->admin)->post(route('admin.zona-lokasi.store'), []);
        $response->assertSessionHasErrors(['nama_zona', 'biaya', 'persentase']);
    }

    public function test_admin_can_update_zona()
    {
        $zona = ZonaLokasi::create([
            'nama_zona' => 'Lama',
            'biaya' => 10000,
            'persentase' => 0,
        ]);

        $response = $this->actingAs($this->admin)->put(route('admin.zona-lokasi.update', $zona->id), [
            'nama_zona' => 'Baru',
            'biaya' => 20000,
            'persentase' => 5,
        ]);

        $response->assertRedirect(route('admin.zona-lokasi.index'));
        $this->assertDatabaseHas('zona_lokasi', ['id' => $zona->id, 'nama_zona' => 'Baru']);
    }

    public function test_admin_can_delete_zona()
    {
        $zona = ZonaLokasi::create([
            'nama_zona' => 'Hapus',
            'biaya' => 10000,
            'persentase' => 0,
        ]);

        $response = $this->actingAs($this->admin)->delete(route('admin.zona-lokasi.destroy', $zona->id));
        $response->assertStatus(302);
        $this->assertDatabaseMissing('zona_lokasi', ['id' => $zona->id]);
    }
}

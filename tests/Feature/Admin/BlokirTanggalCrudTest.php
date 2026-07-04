<?php

namespace Tests\Feature\Admin;

use App\Models\BlokirTanggal;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class BlokirTanggalCrudTest extends TestCase
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
        $response = $this->actingAs($user)->get(route('admin.blokir-tanggal.index'));
        $response->assertStatus(403);
    }

    public function test_admin_can_read_blokir_tanggal_list()
    {
        $response = $this->actingAs($this->admin)->get(route('admin.blokir-tanggal.index'));
        $response->assertStatus(200);
        $response->assertViewIs('admin.blokir-tanggal.index');
    }

    public function test_admin_can_create_blokir_tanggal()
    {
        $response = $this->actingAs($this->admin)->post(route('admin.blokir-tanggal.store'), [
            'tanggal' => '2026-12-31',
            'keterangan' => 'Tahun Baru',
        ]);

        $response->assertStatus(302); // back()
        $this->assertDatabaseHas('blokir_tanggal', ['tanggal' => '2026-12-31 00:00:00', 'keterangan' => 'Tahun Baru']);
    }

    public function test_blokir_tanggal_validation_fails_on_empty_fields()
    {
        $response = $this->actingAs($this->admin)->post(route('admin.blokir-tanggal.store'), []);
        $response->assertSessionHasErrors(['tanggal']);
    }

    public function test_admin_can_delete_blokir_tanggal()
    {
        $blokir = BlokirTanggal::create([
            'tanggal' => '2026-08-17',
            'keterangan' => 'Kemerdekaan',
            'full_block' => true,
        ]);

        $response = $this->actingAs($this->admin)->delete(route('admin.blokir-tanggal.destroy', $blokir->id));
        $response->assertStatus(302);
        $this->assertDatabaseMissing('blokir_tanggal', ['id' => $blokir->id]);
    }
}

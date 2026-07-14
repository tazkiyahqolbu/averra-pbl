<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use App\Models\Pemesanan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class AdminLaporanTest extends TestCase
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

    public function test_admin_can_access_laporan_dashboard()
    {
        $response = $this->actingAs($this->admin)->get(route('admin.laporan.index'));
        $response->assertStatus(200);
        $response->assertViewIs('admin.laporan.index');
    }

    public function test_admin_can_export_laporan_excel()
    {
        $response = $this->actingAs($this->admin)->get(route('admin.laporan.export'));
        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    }
}

<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class AdminPelangganTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;

    protected function setUp(): void
    {
        parent::setUp();
        Role::firstOrCreate(['name' => 'admin']);
        Role::firstOrCreate(['name' => 'user']);
        $this->admin = User::factory()->create();
        $this->admin->assignRole('admin');
    }

    public function test_admin_can_access_pelanggan_list()
    {
        $response = $this->actingAs($this->admin)->get(route('admin.pelanggan.index'));
        $response->assertStatus(200);
        $response->assertViewIs('admin.pelanggan.index');
        $response->assertViewHas('pelanggan');
    }
}

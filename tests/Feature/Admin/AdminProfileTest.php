<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class AdminProfileTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;

    protected function setUp(): void
    {
        parent::setUp();
        Role::firstOrCreate(['name' => 'admin']);
        $this->admin = User::factory()->create([
            'password' => Hash::make('oldpassword'),
        ]);
        $this->admin->assignRole('admin');
    }

    public function test_admin_can_access_profile_page()
    {
        $response = $this->actingAs($this->admin)->get(route('admin.akun.index'));
        $response->assertStatus(200);
        $response->assertViewIs('admin.akun.index');
    }

    public function test_admin_can_update_profile_info()
    {
        $response = $this->actingAs($this->admin)->put(route('admin.akun.update'), [
            'nama' => 'Admin Baru',
            'no_hp' => '08123456789',
        ]);

        $response->assertStatus(302);
        $this->assertDatabaseHas('users', [
            'id' => $this->admin->id,
            'nama' => 'Admin Baru',
            'no_hp' => '08123456789',
        ]);
    }

    public function test_admin_can_update_password()
    {
        $response = $this->actingAs($this->admin)->put(route('admin.akun.password'), [
            'current_password' => 'oldpassword',
            'password' => 'newpassword123',
            'password_confirmation' => 'newpassword123',
        ]);

        $response->assertStatus(302);
        $this->assertTrue(Hash::check('newpassword123', $this->admin->fresh()->password));
    }
}

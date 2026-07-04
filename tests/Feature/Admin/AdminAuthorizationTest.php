<?php

namespace Tests\Feature\Admin;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class AdminAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_non_admin_cannot_access_admin_dashboard(): void
    {
        $user = User::factory()->create();
        \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'pelanggan']);
        $user->assignRole('pelanggan');

        $response = $this->actingAs($user)->get('/admin/dashboard');

        // Should return 403 or redirect
        $this->assertTrue(in_array($response->status(), [403, 302, 401]));
    }

    public function test_admin_can_access_admin_dashboard(): void
    {
        $admin = User::factory()->create();
        \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'admin']);
        $admin->assignRole('admin');

        $response = $this->actingAs($admin)->get('/admin/dashboard');

        $response->assertStatus(200);
    }
}

<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Spatie\Permission\Models\Role;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Buat role dasar yang digunakan dalam AuthController
        Role::firstOrCreate(['name' => 'admin']);
        Role::firstOrCreate(['name' => 'user']);
    }

    public function test_login_screen_can_be_rendered(): void
    {
        $response = $this->get(route('login'));
        $response->assertStatus(200);
        $response->assertViewIs('auth.login');
    }

    public function test_admin_can_authenticate_and_redirect_to_dashboard(): void
    {
        $admin = User::factory()->create([
            'password' => bcrypt('password123'),
        ]);
        $admin->assignRole('admin');

        $response = $this->post('/login', [
            'email' => $admin->email,
            'password' => 'password123',
        ]);

        $this->assertAuthenticatedAs($admin);
        $response->assertRedirect(route('admin.dashboard'));
    }

    public function test_user_can_authenticate_and_redirect_to_beranda(): void
    {
        $user = User::factory()->create([
            'password' => bcrypt('password123'),
        ]);
        $user->assignRole('user');

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password123',
        ]);

        $this->assertAuthenticatedAs($user);
        $response->assertRedirect(route('public.beranda'));
    }

    public function test_users_can_not_authenticate_with_invalid_credentials(): void
    {
        $user = User::factory()->create([
            'password' => bcrypt('password123'),
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
        $response->assertSessionHasErrors(['email' => 'Email atau password salah.']);
    }

    public function test_login_validation_fails_on_empty_input(): void
    {
        $response = $this->post('/login', [
            'email' => '',
            'password' => '',
        ]);

        $this->assertGuest();
        $response->assertSessionHasErrors([
            'email' => 'Email wajib diisi.',
            'password' => 'Password wajib diisi.'
        ]);
    }
}

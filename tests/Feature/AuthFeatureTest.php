<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\Feature\Support\CreatesTestData;
use Tests\TestCase;

class AuthFeatureTest extends TestCase
{
    use RefreshDatabase;
    use CreatesTestData;

    public function test_login_page_can_be_opened(): void
    {
        $this->get(route('login'))->assertOk();
    }

    public function test_register_page_can_be_opened(): void
    {
        $this->get(route('register'))->assertOk();
    }

    public function test_user_can_register_and_get_user_role(): void
    {
        $this->setUpBaseData();

        $response = $this->post(route('register'), [
            'nama' => 'Pelanggan Baru',
            'email' => 'pelanggan@example.com',
            'no_hp' => '081234567890',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertRedirect(route('public.beranda'));
        $this->assertAuthenticated();
        $this->assertDatabaseHas('users', [
            'nama' => 'Pelanggan Baru',
            'email' => 'pelanggan@example.com',
        ]);
        $this->assertTrue(User::where('email', 'pelanggan@example.com')->first()->hasRole('user'));
    }

    public function test_register_requires_valid_data(): void
    {
        $this->setUpBaseData();

        $response = $this->from(route('register'))->post(route('register'), [
            'nama' => '',
            'email' => 'email-tidak-valid',
            'password' => 'short',
            'password_confirmation' => 'beda',
        ]);

        $response->assertRedirect(route('register'));
        $response->assertSessionHasErrors(['nama', 'email', 'password']);
    }

    public function test_admin_login_redirects_to_admin_dashboard(): void
    {
        $admin = $this->makeAdmin([
            'email' => 'admin-login@example.com',
            'password' => Hash::make('password'),
        ]);

        $response = $this->post(route('login'), [
            'email' => 'admin-login@example.com',
            'password' => 'password',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticatedAs($admin);
    }

    public function test_user_login_redirects_to_public_home(): void
    {
        $user = $this->makeUser([
            'email' => 'user-login@example.com',
            'password' => Hash::make('password'),
        ]);

        $response = $this->post(route('login'), [
            'email' => 'user-login@example.com',
            'password' => 'password',
        ]);

        $response->assertRedirect(route('public.beranda'));
        $this->assertAuthenticatedAs($user);
    }

    public function test_login_fails_with_wrong_password(): void
    {
        $this->makeUser([
            'email' => 'wrong-password@example.com',
            'password' => Hash::make('password'),
        ]);

        $response = $this->from(route('login'))->post(route('login'), [
            'email' => 'wrong-password@example.com',
            'password' => 'salah123',
        ]);

        $response->assertRedirect(route('login'));
        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_authenticated_user_can_logout(): void
    {
        $user = $this->makeUser();

        $response = $this->actingAs($user)->post(route('logout'));

        $response->assertRedirect(route('login'));
        $this->assertGuest();
    }
}

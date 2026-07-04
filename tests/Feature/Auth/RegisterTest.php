<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');
        $response->assertStatus(200);
    }

    public function test_new_users_can_register(): void
    {
        \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'pelanggan']);
        
        $response = $this->post('/register', [
            'nama' => 'Test User',
            'email' => 'test@example.com',
            'no_hp' => '081234567890',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertSessionHasNoErrors();
        
        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com',
        ]);
    }
}

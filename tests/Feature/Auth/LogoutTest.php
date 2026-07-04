<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_logout(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->post(route('logout'));

        $this->assertGuest();
        $response->assertRedirect(route('login'));
        $response->assertSessionHas('success', 'Anda telah logout.');
    }

    public function test_unauthenticated_user_cannot_logout(): void
    {
        // Route logout menggunakan middleware auth
        $response = $this->post(route('logout'));

        // Middleware auth akan redirect ke /login
        $response->assertRedirect(route('login'));
    }
}

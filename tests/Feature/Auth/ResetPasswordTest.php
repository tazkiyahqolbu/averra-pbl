<?php

namespace Tests\Feature\Auth;

use App\Models\PasswordResetOtp;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ResetPasswordTest extends TestCase
{
    use RefreshDatabase;

    public function test_reset_password_screen_redirects_if_no_session(): void
    {
        $response = $this->get(route('password.reset-form'));
        $response->assertRedirect(route('password.request'));
    }

    public function test_reset_password_screen_renders_with_session(): void
    {
        $response = $this->withSession(['reset_email' => 'test@example.com'])
                         ->get(route('password.reset-form'));
                         
        $response->assertStatus(200);
        $response->assertViewIs('auth.reset-password');
    }

    public function test_reset_password_success(): void
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('oldpassword')
        ]);

        PasswordResetOtp::create([
            'email' => 'test@example.com',
            'otp' => '123456',
            'expires_at' => now()->addMinutes(10)
        ]);

        $response = $this->withSession([
            'reset_email' => 'test@example.com',
            'email' => 'test@example.com' // Set both just in case
        ])->post(route('password.update'), [
            'password' => 'newpassword123',
            'password_confirmation' => 'newpassword123',
        ]);

        $response->assertRedirect(route('login'));
        $response->assertSessionHas('success', 'Password berhasil direset. Silakan login.');
        
        $this->assertTrue(Hash::check('newpassword123', $user->fresh()->password));
        $this->assertDatabaseMissing('password_reset_otps', [
            'email' => 'test@example.com'
        ]);
        $this->assertNull(session('reset_email'));
    }

    public function test_reset_password_fails_if_same_as_old(): void
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('oldpassword123')
        ]);

        $response = $this->withSession(['reset_email' => 'test@example.com'])
                         ->post(route('password.update'), [
            'password' => 'oldpassword123',
            'password_confirmation' => 'oldpassword123',
        ]);

        $response->assertSessionHasErrors([
            'password' => 'Password baru tidak boleh sama dengan password saat ini.'
        ]);
    }
    
    public function test_reset_password_validation_fails(): void
    {
        $response = $this->withSession(['reset_email' => 'test@example.com'])
                         ->post(route('password.update'), [
            'password' => 'short', // under 8 chars
            'password_confirmation' => 'mismatch',
        ]);

        $response->assertSessionHasErrors(['password']);
    }
}

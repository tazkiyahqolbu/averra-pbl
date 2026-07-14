<?php

namespace Tests\Feature\Auth;

use App\Mail\OtpMail;
use App\Models\PasswordResetOtp;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class ForgotPasswordTest extends TestCase
{
    use RefreshDatabase;

    public function test_forgot_password_screen_can_be_rendered(): void
    {
        $response = $this->get(route('password.request'));
        $response->assertStatus(200);
        $response->assertViewIs('auth.forgot-password');
    }

    public function test_send_otp_success(): void
    {
        Mail::fake();

        $user = User::factory()->create([
            'email' => 'test@example.com'
        ]);

        $response = $this->post(route('password.send-otp'), [
            'email' => 'test@example.com'
        ]);

        $response->assertRedirect(route('password.verify-otp'));
        $response->assertSessionHas('email', 'test@example.com');
        
        $this->assertDatabaseHas('password_reset_otps', [
            'email' => 'test@example.com'
        ]);

        Mail::assertQueued(OtpMail::class);
    }

    public function test_send_otp_validation_fails_for_non_existent_email(): void
    {
        $response = $this->post(route('password.send-otp'), [
            'email' => 'tidakada@example.com'
        ]);

        $response->assertSessionHasErrors([
            'email' => 'Email tidak terdaftar.'
        ]);
    }

    public function test_verify_otp_screen_redirects_if_no_session(): void
    {
        $response = $this->get(route('password.verify-otp'));
        $response->assertRedirect(route('password.request'));
    }

    public function test_verify_otp_screen_renders_with_session(): void
    {
        $response = $this->withSession(['email' => 'test@example.com'])
                         ->get(route('password.verify-otp'));
                         
        $response->assertStatus(200);
        $response->assertViewIs('auth.verify-otp');
    }

    public function test_check_otp_success(): void
    {
        $email = 'test@example.com';
        $otp = '123456';
        
        PasswordResetOtp::create([
            'email' => $email,
            'otp' => $otp,
            'expires_at' => now()->addMinutes(10)
        ]);

        $response = $this->post(route('password.check-otp'), [
            'email' => $email,
            'otp' => $otp
        ]);

        $response->assertRedirect(route('password.reset-form'));
        $response->assertSessionHas('reset_email', $email);
    }

    public function test_check_otp_fails_if_expired_or_invalid(): void
    {
        $email = 'test@example.com';
        
        PasswordResetOtp::create([
            'email' => $email,
            'otp' => '123456',
            'expires_at' => now()->subMinutes(1) // Expired
        ]);

        $response = $this->post(route('password.check-otp'), [
            'email' => $email,
            'otp' => '123456'
        ]);

        $response->assertSessionHasErrors(['otp' => 'Kode OTP tidak valid atau sudah kedaluwarsa.']);
    }
}

<?php

namespace Tests\Feature\Payment;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class PaymentTest extends TestCase
{
    use RefreshDatabase;

    public function test_payment_selection_screen_redirects_if_unauthenticated(): void
    {
        $response = $this->get('/pembayaran/1/pilih');
        $response->assertRedirect('/login');
    }

    public function test_payment_selection_screen_renders_for_authorized_user(): void
    {
        $user = User::factory()->create();
        
        // This is a basic test that assumes pemesanan ID 1 doesn't exist yet, should 404
        $response = $this->actingAs($user)->get('/pembayaran/1/pilih');
        $response->assertStatus(404);
    }
}

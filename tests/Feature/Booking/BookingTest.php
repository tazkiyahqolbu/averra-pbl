<?php

namespace Tests\Feature\Booking;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class BookingTest extends TestCase
{
    use RefreshDatabase;

    public function test_booking_screen_can_be_rendered_for_authenticated_user(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/pemesanan/buat/acara');

        $response->assertStatus(200);
    }
    
    public function test_unauthenticated_user_cannot_view_booking_screen(): void
    {
        $response = $this->get('/pemesanan/buat/acara');
        $response->assertRedirect('/login');
    }
}

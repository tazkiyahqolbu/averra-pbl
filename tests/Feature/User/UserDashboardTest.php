<?php

namespace Tests\Feature\User;

use App\Models\User;
use App\Models\Pemesanan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class UserDashboardTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        Role::firstOrCreate(['name' => 'user']);
        $this->user = User::factory()->create();
        $this->user->assignRole('user');
    }

    public function test_unauthenticated_user_cannot_access_dashboard()
    {
        $response = $this->get(route('user.dashboard.index'));
        $response->assertRedirect(route('login'));
    }

    public function test_user_can_access_dashboard()
    {
        $response = $this->actingAs($this->user)->get(route('user.dashboard.index'));
        $response->assertStatus(200);
        $response->assertViewIs('user.dashboard.index');
        $response->assertViewHas('statusCounts');
    }
}

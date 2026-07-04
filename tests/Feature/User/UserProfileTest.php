<?php

namespace Tests\Feature\User;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class UserProfileTest extends TestCase
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

    public function test_user_can_access_profile_page()
    {
        $response = $this->actingAs($this->user)->get(route('user.profile.index'));
        $response->assertStatus(200);
        $response->assertViewIs('user.profile.index');
    }

    public function test_user_can_update_profile_info()
    {
        $response = $this->actingAs($this->user)->put(route('user.profile.update'), [
            'nama' => 'John Doe Baru',
            'no_hp' => '08123456789',
        ]);

        $response->assertStatus(302);
        $this->assertDatabaseHas('users', [
            'id' => $this->user->id,
            'nama' => 'John Doe Baru',
            'no_hp' => '08123456789',
        ]);
    }

    public function test_user_can_update_password()
    {
        $user = User::factory()->create([
            'password' => Hash::make('oldpassword'),
        ]);

        $response = $this->actingAs($user)->put(route('user.profile.update'), [
            'current_password' => 'oldpassword',
            'password' => 'newpassword123',
            'password_confirmation' => 'newpassword123',
        ]);

        $response->assertStatus(302);
        $this->assertTrue(Hash::check('newpassword123', $user->fresh()->password));
    }
}

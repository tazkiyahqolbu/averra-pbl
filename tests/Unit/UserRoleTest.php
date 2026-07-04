<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;

class UserRoleTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_has_admin_role()
    {
        Role::firstOrCreate(['name' => 'admin']);
        $user = User::factory()->create();
        $user->assignRole('admin');

        $this->assertTrue($user->hasRole('admin'));
    }
}

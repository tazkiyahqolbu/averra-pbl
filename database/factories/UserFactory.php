<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected static ?string $password;

    public function definition(): array
    {
        return [
            'nama'       => fake()->name(),        // ← name → nama
            'email'      => fake()->unique()->safeEmail(),
            'password'   => static::$password ??= Hash::make('password'),
            'no_hp'      => fake()->numerify('08##########'),
            'remember_token' => Str::random(10),
            // ← email_verified_at dihapus (kolom tidak ada)
        ];
    }

    public function admin(): static
    {
       return $this->afterCreating(function (User $user) {
            $user->assignRole('admin');
        });
    }

    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => []);
    }
}

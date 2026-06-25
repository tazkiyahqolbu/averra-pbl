<?php

namespace Database\Factories;

use App\Models\Pemesanan;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TestimoniFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id'         => User::factory(),
            'pemesanan_id'    => Pemesanan::factory()->selesai(),
            'isi_testimoni'   => fake()->paragraph(),
            'rating'          => fake()->numberBetween(3, 5),
            'dibalas'         => null,
            'dipublikasikan'  => true,
        ];
    }

}

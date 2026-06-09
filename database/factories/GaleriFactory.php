<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class GaleriFactory extends Factory
{
    public function definition(): array
    {
        return [
            'judul'       => fake()->sentence(3),
            'kategori'    => fake()->randomElement(['Pernikahan', 'Sunatan', 'Ulang Tahun', 'Acara Kantor']),
            'media_path'  => 'galeri/placeholder.jpg',
            'jenis_media' => 'foto',
            'keterangan'  => fake()->sentence(),
            'unggulan'    => false,
        ];
    }

    public function unggulan(): static
    {
        return $this->state(fn (array $attributes) => ['unggulan' => true]);
    }

    public function video(): static
    {
        return $this->state(fn (array $attributes) => ['jenis_media' => 'video']);
    }
}

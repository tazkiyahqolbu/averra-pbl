<?php

namespace Database\Factories;

use App\Models\KategoriJasa;
use Illuminate\Database\Eloquent\Factories\Factory;

class JasaFactory extends Factory
{
    public function definition(): array
    {
        return [
            'kategori_jasa_id'     => KategoriJasa::inRandomOrder()->first()?->id ?? 1,
            'nama_jasa'            => fake()->words(3, true),
            'deskripsi'            => fake()->sentence(),
            'harga'                => fake()->numberBetween(100000, 5000000),
            'maks_booking_harian'  => fake()->numberBetween(1, 5),
            'thumbnail_path'       => null,
            'aktif'                => true,
        ];
    }

    public function nonaktif(): static
    {
        return $this->state(fn (array $attributes) => ['aktif' => false]);
    }
}

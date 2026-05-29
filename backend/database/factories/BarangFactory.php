<?php

namespace Database\Factories;

use App\Models\KategoriBarang;
use Illuminate\Database\Eloquent\Factories\Factory;

class BarangFactory extends Factory
{
    public function definition(): array
    {
        return [
            'kategori_barang_id' => KategoriBarang::inRandomOrder()->first()?->id ?? 1,
            'nama_barang'        => fake()->words(2, true),
            'deskripsi'          => fake()->sentence(),
            'harga'              => fake()->numberBetween(50000, 2000000),
            'nilai_barang'       => fake()->numberBetween(100000, 5000000),
            'stok'               => fake()->numberBetween(0, 20),
            'thumbnail_path'     => null,
            'aktif'              => true,
        ];
    }

    public function habis(): static
    {
        return $this->state(fn (array $attributes) => ['stok' => 0]);
    }

    public function nonaktif(): static
    {
        return $this->state(fn (array $attributes) => ['aktif' => false]);
    }
}

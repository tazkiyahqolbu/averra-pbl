<?php

namespace Database\Factories;

use App\Models\KategoriPaket;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaketFactory extends Factory
{
    public function definition(): array
    {
        return [
            'kategori_paket_id' => KategoriPaket::inRandomOrder()->first()?->id ?? 1,
            'nama_paket'        => fake()->words(3, true),
            'deskripsi'         => fake()->sentence(),
            'harga'             => fake()->numberBetween(500000, 10000000),
            'keterangan_acara'  => fake()->words(2, true),
            'catatan'           => fake()->sentence(),
            'thumbnail_path'    => null,
            'aktif'             => true,
        ];
    }

    public function nonaktif(): static
    {
        return $this->state(fn (array $attributes) => ['aktif' => false]);
    }
}

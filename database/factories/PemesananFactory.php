<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\ZonaLokasi;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PemesananFactory extends Factory
{
    public function definition(): array
    {
        return [
            'kode_pemesanan'    => 'PMB-' . strtoupper(Str::random(8)),
            'user_id'           => User::factory(),
            'zona_id'           => ZonaLokasi::inRandomOrder()->first()?->id,
            'tanggal_pemesanan' => fake()->dateTimeBetween('-1 month', 'now'),
            'tanggal_pakai'     => fake()->dateTimeBetween('now', '+3 months'),
            'jenis'             => fake()->randomElement(['acara', 'sewa_barang']),
            'lokasi'            => fake()->address(),
            'ongkos_lokasi'     => fake()->numberBetween(0, 200000),
            'no_hp'             => fake()->numerify('08##########'),
            'catatan'           => fake()->sentence(),
            'total_harga'       => fake()->numberBetween(500000, 20000000),
            'status'            => 'menunggu',
        ];
    }

    public function dikonfirmasi(): static
    {
        return $this->state(fn (array $attributes) => ['status' => 'dikonfirmasi']);
    }

    public function selesai(): static
    {
        return $this->state(fn (array $attributes) => ['status' => 'selesai']);
    }

    public function dibatalkan(): static
    {
        return $this->state(fn (array $attributes) => ['status' => 'dibatalkan']);
    }
}

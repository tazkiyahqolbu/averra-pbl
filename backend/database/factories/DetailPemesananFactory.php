<?php

namespace Database\Factories;

use App\Models\Barang;
use App\Models\Jasa;
use App\Models\Paket;
use App\Models\Pemesanan;
use Illuminate\Database\Eloquent\Factories\Factory;

class DetailPemesananFactory extends Factory
{
    public function definition(): array
    {
        // Default: jenis jasa
        $harga = fake()->numberBetween(100000, 5000000);
        $jumlah = fake()->numberBetween(1, 5);

        return [
            'pemesanan_id' => Pemesanan::factory(),
            'jenis_item'   => 'jasa',
            'jasa_id'      => Jasa::factory(),
            'barang_id'    => null,
            'paket_id'     => null,
            'jumlah'       => $jumlah,
            'harga'        => $harga,
            'subtotal'     => $harga * $jumlah,
            'tanggal_ambil'   => null,
            'tanggal_kembali' => null,
        ];
    }

    public function untukBarang(): static
    {
        return $this->state(function (array $attributes) {
            $harga  = fake()->numberBetween(50000, 2000000);
            $jumlah = fake()->numberBetween(1, 3);
            return [
                'jenis_item'      => 'barang',
                'barang_id'       => Barang::factory(),
                'jasa_id'         => null,
                'paket_id'        => null,
                'harga'           => $harga,
                'subtotal'        => $harga * $jumlah,
                'jumlah'          => $jumlah,
                'tanggal_ambil'   => fake()->dateTimeBetween('now', '+1 week'),
                'tanggal_kembali' => fake()->dateTimeBetween('+1 week', '+2 weeks'),
            ];
        });
    }

    public function untukPaket(): static
    {
        return $this->state(function (array $attributes) {
            $harga  = fake()->numberBetween(500000, 10000000);
            $jumlah = 1;
            return [
                'jenis_item' => 'paket',
                'paket_id'   => Paket::factory(),
                'jasa_id'    => null,
                'barang_id'  => null,
                'harga'      => $harga,
                'subtotal'   => $harga * $jumlah,
                'jumlah'     => $jumlah,
            ];
        });
    }
}

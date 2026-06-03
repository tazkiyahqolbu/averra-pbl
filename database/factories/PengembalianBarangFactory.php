<?php

namespace Database\Factories;

use App\Models\DetailPemesanan;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PengembalianBarangFactory extends Factory
{
    public function definition(): array
    {
        $dendaKeterlambatan = fake()->numberBetween(0, 200000);
        $dendaKerusakan     = fake()->numberBetween(0, 500000);

        return [
            'detail_pemesanan_id'    => DetailPemesanan::factory()->untukBarang(),
            'tanggal_kembali_aktual' => fake()->dateTimeBetween('-1 month', 'now'),
            'kondisi'                => 'baik',
            'catatan_kerusakan'      => null,
            'foto_bukti_path'        => null,
            'status_pengembalian'    => 'menunggu',
            'denda_keterlambatan'    => 0,
            'denda_kerusakan'        => 0,
            'total_denda'            => 0,
            'status_denda'           => 'tidak_ada',
            'dicatat_oleh'           => User::factory()->admin(),
        ];
    }

    public function rusak(): static
    {
        return $this->state(function (array $attributes) {
            $dKeterlambatan = fake()->numberBetween(0, 200000);
            $dKerusakan     = fake()->numberBetween(100000, 500000);
            return [
                'kondisi'             => fake()->randomElement(['rusak_ringan', 'rusak_berat']),
                'catatan_kerusakan'   => fake()->sentence(),
                'denda_keterlambatan' => $dKeterlambatan,
                'denda_kerusakan'     => $dKerusakan,
                'total_denda'         => $dKeterlambatan + $dKerusakan,
                'status_denda'        => 'menunggu_bayar',
            ];
        });
    }

    public function hilang(): static
    {
        return $this->state(function (array $attributes) {
            $totalDenda = fake()->numberBetween(500000, 3000000);
            return [
                'kondisi'             => 'hilang',
                'catatan_kerusakan'   => 'Barang hilang tidak dikembalikan',
                'denda_kerusakan'     => $totalDenda,
                'total_denda'         => $totalDenda,
                'status_denda'        => 'menunggu_bayar',
            ];
        });
    }
}

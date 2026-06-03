<?php

namespace Database\Factories;

use App\Models\Pemesanan;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PembayaranFactory extends Factory
{
    public function definition(): array
    {
        return [
            'kode_transaksi'       => 'TRX-' . strtoupper(Str::random(10)),
            'pemesanan_id'         => Pemesanan::factory(),
            'tahap'                => fake()->randomElement(['dp', 'pelunasan', 'langsung']),
            'persen_dp'            => null,
            'jumlah_bayar'         => fake()->numberBetween(100000, 10000000),
            'dibayar_pada'         => fake()->dateTimeBetween('-1 month', 'now'),
            'metode_pembayaran'    => fake()->randomElement(['transfer', 'tunai', 'qris']),
            'bukti_pembayaran_path'=> null,
            'status'               => 'menunggu',
            'diverifikasi_oleh'    => null,
            'diverifikasi_pada'    => null,
            'catatan_penolakan'    => null,
        ];
    }

    public function dp(): static
    {
        return $this->state(fn (array $attributes) => [
            'tahap'     => 'dp',
            'persen_dp' => fake()->randomElement([30, 50]),
        ]);
    }

    public function terverifikasi(): static
    {
        return $this->state(fn (array $attributes) => [
            'status'            => 'terverifikasi',
            'diverifikasi_pada' => now(),
        ]);
    }

    public function ditolak(): static
    {
        return $this->state(fn (array $attributes) => [
            'status'            => 'ditolak',
            'catatan_penolakan' => fake()->sentence(),
        ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ZonaLokasiSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['nama_zona' => 'Zona 1 — Dalam Kota',   'keterangan' => 'Radius 0-10 km',  'biaya' => 50000],
            ['nama_zona' => 'Zona 2 — Pinggir Kota', 'keterangan' => 'Radius 10-25 km', 'biaya' => 100000],
            ['nama_zona' => 'Zona 3 — Luar Kota',    'keterangan' => 'Radius 25-50 km', 'biaya' => 200000],
            ['nama_zona' => 'Zona 4 — Luar Daerah',  'keterangan' => 'Lebih dari 50 km','biaya' => 350000],
        ];

        foreach ($data as $item) {
            DB::table('zona_lokasi')->insert([
                ...$item,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

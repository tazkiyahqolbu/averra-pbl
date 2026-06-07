<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ZonaLokasiSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['nama_zona' => 'Dalam Kota Padang',       'keterangan' => 'Wilayah dalam kota Padang',            'biaya' => 0],
            ['nama_zona' => 'Luar Kota Padang',        'keterangan' => 'Wilayah luar kota Padang (Sumbar)',    'biaya' => 150000],
            ['nama_zona' => 'Wilayah Sumatera Barat',  'keterangan' => 'Luar Padang, masih di Sumatera Barat', 'biaya' => 300000],
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

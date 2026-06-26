<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriJasaSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['nama' => 'Pertunjukan Tari',   'deskripsi' => 'Jasa pertunjukan tari tradisional'],
            ['nama' => 'Musik Tradisional',  'deskripsi' => 'Jasa musik dan alat musik tradisional'],
            ['nama' => 'Pelatihan',          'deskripsi' => 'Jasa kelas dan pelatihan seni'],
            ['nama' => 'Dokumentasi',        'deskripsi' => 'Jasa foto dan video acara'],
            ['nama' => 'Dekorasi',           'deskripsi' => 'Jasa dekorasi panggung dan venue'],
        ];

        foreach ($data as $item) {
            DB::table('kategori_jasa')->insert([
                ...$item,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

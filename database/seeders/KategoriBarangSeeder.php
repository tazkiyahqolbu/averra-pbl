<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriBarangSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['nama' => 'Kostum',        'deskripsi' => 'Kostum dan pakaian adat'],
            ['nama' => 'Properti Tari', 'deskripsi' => 'Properti pendukung pertunjukan tari'],
            ['nama' => 'Alat Musik',    'deskripsi' => 'Alat musik tradisional'],
            ['nama' => 'Dekorasi',      'deskripsi' => 'Perlengkapan dekorasi acara'],
        ];

        foreach ($data as $item) {
            DB::table('kategori_barang')->insert([
                ...$item,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

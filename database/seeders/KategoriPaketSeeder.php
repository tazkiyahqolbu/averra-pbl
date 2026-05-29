<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriPaketSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['nama' => 'Paket Pernikahan',   'deskripsi' => 'Paket lengkap untuk acara pernikahan'],
            ['nama' => 'Paket Sunatan',      'deskripsi' => 'Paket lengkap untuk acara sunatan'],
            ['nama' => 'Paket Ulang Tahun',  'deskripsi' => 'Paket hiburan untuk ulang tahun'],
            ['nama' => 'Paket Acara Kantor', 'deskripsi' => 'Paket hiburan untuk acara perusahaan'],
        ];

        foreach ($data as $item) {
            DB::table('kategori_paket')->insert([
                ...$item,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

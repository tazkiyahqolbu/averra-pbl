<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Seeder statis (data master) — RoleSeeder PALING ATAS
        $this->call([
            RoleSeeder::class,
            KategoriJasaSeeder::class,
            KategoriPaketSeeder::class,
            KategoriBarangSeeder::class,
            ZonaLokasiSeeder::class,
        ]);

        // Akun admin — role 'admin' otomatis dari factory admin()
        User::factory()->admin()->create([
            'nama'  => 'Admin Sanggar',
            'email' => 'admin@rantiang.com',
        ]);

        // Akun user biasa + assign role 'user'
        User::factory()->create([
            'nama'  => 'User Test',
            'email' => 'user@rantiang.com',
        ])->assignRole('user');
    }
}

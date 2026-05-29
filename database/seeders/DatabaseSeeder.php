<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Buat 1 akun admin
        User::factory()->admin()->create([
            'nama'  => 'Admin Sanggar',
            'email' => 'admin@rantiang.com',
        ]);

        // Buat 1 akun user biasa
        User::factory()->create([
            'nama'  => 'User Test',
            'email' => 'user@rantiang.com',
        ]);
    }
}

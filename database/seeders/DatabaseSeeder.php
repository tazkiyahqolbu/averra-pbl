<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Booking;
use App\Models\Testimoni;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seed Users
        $admin = User::updateOrCreate(
            ['email' => 'admin@silart.id'],
            [
                'name' => 'Admin SILART',
                'phone' => '081122334455',
                'role' => 'admin',
                'password' => Hash::make('admin123'),
            ]
        );

        $user = User::updateOrCreate(
            ['email' => 'user@silart.id'],
            [
                'name' => 'Bunda Ayu',
                'phone' => '081234567890',
                'role' => 'user',
                'password' => Hash::make('user123'),
            ]
        );

        // 2. Seed Bookings
        Booking::create([
            'id' => 'BK-AYU882',
            'name' => 'Bunda Ayu',
            'phone' => '081234567890',
            'email' => 'user@silart.id',
            'service' => 'Rias Pengantin Jawa Modern',
            'date' => '2026-06-15',
            'location' => 'Gedung Serbaguna, Jakarta',
            'notes' => 'Tolong sediakan aksesoris melati asli.',
            'groom_name' => 'Mas Andi',
            'bride_name' => 'Bunda Ayu',
            'witness_name' => 'Bapak Slamet',
            'mahar' => 'Emas Logam Mulia 10 gram',
            'status' => 'Confirmed',
            'created_by' => 'user@silart.id',
        ]);

        Booking::create([
            'id' => 'BK-SITI331',
            'name' => 'Bunda Siti',
            'phone' => '085678901234',
            'email' => 'siti@example.com',
            'service' => 'Rias Pengantin Sunda Siger',
            'date' => '2026-07-20',
            'location' => 'Hotel Grand Aston, Bandung',
            'notes' => 'Acara akad nikah pagi hari pukul 08:00.',
            'groom_name' => 'Mas Budi',
            'bride_name' => 'Bunda Siti',
            'witness_name' => 'Bapak Heru',
            'mahar' => 'Seperangkat Alat Sholat & Ring',
            'status' => 'Pending',
            'created_by' => 'user@silart.id',
        ]);

        // 3. Seed Testimonials
        Testimoni::create([
            'name' => 'Bunda Ayu',
            'rating' => 5,
            'message' => 'Sangat puas dengan riasan dari SILART! Hasilnya flawless, manglingi, dan awet seharian. Terima kasih banyak Bunda!',
        ]);

        Testimoni::create([
            'name' => 'Bunda Rina',
            'rating' => 4,
            'message' => 'Layanannya ramah banget, gaun pengantinnya bersih dan wangi. Hasil riasannya rapi dan elegan.',
        ]);
    }
}

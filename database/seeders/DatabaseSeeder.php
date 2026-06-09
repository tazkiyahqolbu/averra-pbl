<?php

namespace Database\Seeders;

use App\Models\Barang;
use App\Models\Galeri;
use App\Models\Jasa;
use App\Models\Paket;
use App\Models\Pembayaran;
use App\Models\Pemesanan;
use App\Models\Testimoni;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Data master — RoleSeeder PALING ATAS
        $this->call([
            RoleSeeder::class,
            KategoriJasaSeeder::class,
            KategoriPaketSeeder::class,
            KategoriBarangSeeder::class,
            ZonaLokasiSeeder::class,
        ]);

        // 2. Akun demo admin
        User::factory()->admin()->create([
            'nama'  => 'Admin Sanggar',
            'email' => 'admin@rantiang.com',
        ]);

        // 3. Akun demo user/pelanggan
        $userTest = User::factory()->create([
            'nama'  => 'User Test',
            'email' => 'user@rantiang.com',
        ]);
        $userTest->assignRole('user');

        // 4. Data layanan
        Jasa::factory()->count(6)->create();
        Paket::factory()->count(4)->create();
        Barang::factory()->count(10)->create();
        Barang::factory()->count(2)->habis()->create();

        // 5. Dummy pemesanan untuk user test (campuran semua status)
        $pemesananMenunggu    = Pemesanan::factory()->count(2)->create(['user_id' => $userTest->id]);
        $pemesananDikonfirmasi = Pemesanan::factory()->dikonfirmasi()->create(['user_id' => $userTest->id]);
        $pemesananSelesai     = Pemesanan::factory()->selesai()->create(['user_id' => $userTest->id]);
        Pemesanan::factory()->dibatalkan()->create(['user_id' => $userTest->id]);

        // 6. Pembayaran untuk pemesanan dikonfirmasi & selesai
        Pembayaran::factory()->dp()->terverifikasi()->create([
            'pemesanan_id' => $pemesananDikonfirmasi->id,
        ]);
        Pembayaran::factory()->terverifikasi()->create([
            'pemesanan_id' => $pemesananSelesai->id,
        ]);

        // 7. Testimoni untuk pemesanan selesai
        Testimoni::factory()->create([
            'user_id'      => $userTest->id,
            'pemesanan_id' => $pemesananSelesai->id,
        ]);

        // 8. Galeri
        Galeri::factory()->count(3)->unggulan()->create();
        Galeri::factory()->count(6)->create();
    }
}

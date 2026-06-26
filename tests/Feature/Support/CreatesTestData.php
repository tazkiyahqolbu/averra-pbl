<?php

namespace Tests\Feature\Support;

use App\Models\Barang;
use App\Models\KategoriBarang;
use App\Models\KategoriJasa;
use App\Models\KategoriPaket;
use App\Models\Pemesanan;
use App\Models\User;
use App\Models\ZonaLokasi;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

trait CreatesTestData
{
    protected function setUpBaseData(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        Role::firstOrCreate(['name' => 'user', 'guard_name' => 'web']);

        KategoriJasa::firstOrCreate(['nama' => 'Pertunjukan Tari'], ['deskripsi' => 'Jasa pertunjukan tari']);
        KategoriPaket::firstOrCreate(['nama' => 'Paket Pernikahan'], ['deskripsi' => 'Paket acara pernikahan']);
        KategoriBarang::firstOrCreate(['nama' => 'Kostum'], ['deskripsi' => 'Kostum dan properti']);
        ZonaLokasi::firstOrCreate(['nama_zona' => 'Dalam Kota Padang'], [
            'keterangan' => 'Wilayah dalam Kota Padang',
            'biaya' => 0,
        ]);
    }

    protected function makeAdmin(array $attributes = []): User
    {
        $this->setUpBaseData();

        $user = User::factory()->create(array_merge([
            'nama' => 'Admin Test',
            'email' => 'admin-test@example.com',
            'password' => Hash::make('password'),
        ], $attributes));

        $user->assignRole('admin');

        return $user;
    }

    protected function makeUser(array $attributes = []): User
    {
        $this->setUpBaseData();

        $user = User::factory()->create(array_merge([
            'nama' => 'User Test',
            'email' => 'user-test@example.com',
            'password' => Hash::make('password'),
        ], $attributes));

        $user->assignRole('user');

        return $user;
    }

    protected function makeSewaPemesanan(User $user, array $attributes = []): Pemesanan
    {
        $this->setUpBaseData();

        return Pemesanan::factory()->create(array_merge([
            'user_id' => $user->id,
            'jenis' => 'sewa_barang',
            'status' => 'menunggu',
            'tanggal_pakai' => now()->addDays(7)->toDateString(),
            'total_harga' => 500000,
        ], $attributes));
    }

    protected function makeAvailableBarang(array $attributes = []): Barang
    {
        $this->setUpBaseData();

        return Barang::factory()->create(array_merge([
            'kategori_barang_id' => KategoriBarang::first()->id,
            'nama_barang' => 'Kostum Tari Test',
            'harga' => 100000,
            'nilai_barang' => 1000000,
            'stok' => 5,
            'aktif' => true,
        ], $attributes));
    }
}

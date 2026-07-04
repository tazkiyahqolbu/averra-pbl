<?php

namespace Tests\Feature\Public;

use App\Models\Paket;
use App\Models\KategoriPaket;
use App\Models\Galeri;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_access_beranda()
    {
        $response = $this->get(route('public.beranda'));
        $response->assertStatus(200);
        $response->assertViewIs('public.Beranda');
    }

    public function test_can_access_katalog_index()
    {
        $response = $this->get(route('public.katalog.index'));
        $response->assertStatus(200);
        // Katalog view might be frontend or public.katalog
    }

    public function test_can_access_katalog_show()
    {
        $kategori = KategoriPaket::create(['nama' => 'Test', 'deskripsi' => 'Test']);
        $paket = Paket::create([
            'kategori_paket_id' => $kategori->id,
            'nama_paket' => 'Test Paket',
            'harga' => 100000,
            'aktif' => true,
        ]);

        $response = $this->get(route('katalog.show', 'paket-' . $paket->id));
        $response->assertStatus(200);
    }

    public function test_can_access_galeri_kami()
    {
        Galeri::create([
            'judul' => 'Test Galeri',
            'media_path' => 'test.jpg',
            'jenis_media' => 'foto',
            'unggulan' => true,
        ]);

        $response = $this->get(route('public.galeri.index'));
        $response->assertStatus(200);
        $response->assertViewIs('public.galeri.index');
    }

    public function test_can_access_tentang_kami()
    {
        $response = $this->get(route('public.tentang.index'));
        $response->assertStatus(200);
        $response->assertViewIs('public.tentang.index');
    }
}

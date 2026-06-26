<?php

namespace Tests\Feature;

use App\Models\Barang;
use App\Models\Jasa;
use App\Models\KategoriBarang;
use App\Models\KategoriJasa;
use App\Models\KategoriPaket;
use App\Models\Paket;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\Support\CreatesTestData;
use Tests\TestCase;

class PublicKatalogFeatureTest extends TestCase
{
    use RefreshDatabase;
    use CreatesTestData;

    public function test_public_home_page_can_be_opened(): void
    {
        $this->get(route('public.beranda'))->assertOk();
    }

    public function test_katalog_page_displays_active_items(): void
    {
        $this->setUpBaseData();

        Jasa::factory()->create([
            'kategori_jasa_id' => KategoriJasa::first()->id,
            'nama_jasa' => 'Tari Pasambahan Test',
            'aktif' => true,
        ]);
        Paket::factory()->create([
            'kategori_paket_id' => KategoriPaket::first()->id,
            'nama_paket' => 'Paket Wedding Test',
            'aktif' => true,
        ]);
        Barang::factory()->create([
            'kategori_barang_id' => KategoriBarang::first()->id,
            'nama_barang' => 'Kostum Anak Test',
            'stok' => 3,
            'aktif' => true,
        ]);

        $response = $this->get(route('public.katalog.index'));

        $response->assertOk();
        $response->assertSee('Tari Pasambahan Test');
        $response->assertSee('Paket Wedding Test');
        $response->assertSee('Kostum Anak Test');
    }

    public function test_katalog_search_filters_items_by_name(): void
    {
        $this->setUpBaseData();

        Jasa::factory()->create([
            'kategori_jasa_id' => KategoriJasa::first()->id,
            'nama_jasa' => 'Tari Piring Unik',
            'aktif' => true,
        ]);
        Jasa::factory()->create([
            'kategori_jasa_id' => KategoriJasa::first()->id,
            'nama_jasa' => 'MC Pernikahan',
            'aktif' => true,
        ]);

        $response = $this->get(route('public.katalog.index', ['search' => 'Piring']));

        $response->assertOk();
        $response->assertSee('Tari Piring Unik');
        $response->assertDontSee('MC Pernikahan');
    }

    public function test_katalog_detail_for_jasa_can_be_opened(): void
    {
        $this->setUpBaseData();

        $jasa = Jasa::factory()->create([
            'kategori_jasa_id' => KategoriJasa::first()->id,
            'nama_jasa' => 'Detail Jasa Test',
            'aktif' => true,
        ]);

        $this->get(route('katalog.show', 'jasa-' . $jasa->id))
            ->assertOk()
            ->assertSee('Detail Jasa Test');
    }

    public function test_katalog_detail_for_paket_can_be_opened(): void
    {
        $this->setUpBaseData();

        $paket = Paket::factory()->create([
            'kategori_paket_id' => KategoriPaket::first()->id,
            'nama_paket' => 'Detail Paket Test',
            'aktif' => true,
        ]);

        $this->get(route('katalog.show', 'paket-' . $paket->id))
            ->assertOk()
            ->assertSee('Detail Paket Test');
    }

    public function test_katalog_detail_for_barang_can_be_opened(): void
    {
        $barang = $this->makeAvailableBarang(['nama_barang' => 'Detail Barang Test']);

        $this->get(route('katalog.show', 'barang-' . $barang->id))
            ->assertOk()
            ->assertSee('Detail Barang Test');
    }

    public function test_invalid_katalog_slug_returns_not_found(): void
    {
        $this->setUpBaseData();

        $this->get(route('katalog.show', 'tidak-valid-999'))->assertNotFound();
    }
}

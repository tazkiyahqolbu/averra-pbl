<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Jasa;
use App\Models\Paket;
use App\Models\Testimoni;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KatalogController extends Controller
{
    public function index(Request $request)
    {
        $search   = $request->query('search', '');
        $category = $request->query('category', 'Semua');
        $sort = $request->query('sort', 'terbaru');

        $jasaUlasan   = $this->ulasanStats('jasa', 'jasa_id');
        $paketUlasan  = $this->ulasanStats('paket', 'paket_id');
        $barangUlasan = $this->ulasanStats('barang', 'barang_id');

        $jasaItems = Jasa::where('aktif', true)->get()->map(fn($j) => (object)[
            'id'       => 'jasa-' . $j->id,
            'type'     => 'jasa',
            'name'     => $j->nama_jasa,
            'category' => 'Jasa',
            'img'      => $j->thumbnail_path ? Storage::url($j->thumbnail_path) : 'image/background.png',
            'price'    => (float) $j->harga,
            'desc'     => $j->deskripsi,
            'available' => true,
            'rating'   => $jasaUlasan->get($j->id)['avg'] ?? 0,
            'ulasan'   => $jasaUlasan->get($j->id)['count'] ?? 0,
            'color'    => null,
            'material' => null,
            'stok'     => null,
        ]);

        $paketItems = Paket::where('aktif', true)->get()->map(fn($p) => (object)[
            'id'       => 'paket-' . $p->id,
            'type'     => 'paket',
            'name'     => $p->nama_paket,
            'category' => 'Paket Acara',
            'img'      => $p->thumbnail_path ? Storage::url($p->thumbnail_path) : 'image/background.png',
            'price'    => (float) $p->harga,
            'desc'     => $p->deskripsi,
            'available' => true,
            'rating'   => $paketUlasan->get($p->id)['avg'] ?? 0,
            'ulasan'   => $paketUlasan->get($p->id)['count'] ?? 0,
            'color'    => null,
            'material' => null,
            'stok'     => null,
        ]);

        $barangItems = Barang::where('aktif', true)->get()->map(fn($b) => (object)[
            'id'       => 'barang-' . $b->id,
            'type'     => 'barang',
            'name'     => $b->nama_barang,
            'category' => 'Sewa Barang',
            'img'      => $b->thumbnail_path ? Storage::url($b->thumbnail_path) : 'image/background.png',
            'price'    => (float) $b->harga,
            'desc'     => $b->deskripsi,
            'available' => $b->stok > 0,
            'rating'   => $barangUlasan->get($b->id)['avg'] ?? 0,
            'ulasan'   => $barangUlasan->get($b->id)['count'] ?? 0,
            'color'    => null,
            'material' => null,
            'stok'     => $b->stok,
        ]);

        $katalogs = $jasaItems->concat($paketItems)->concat($barangItems);

        if ($search) {
            $katalogs = $katalogs->filter(
                fn($i) => str_contains(strtolower($i->name), strtolower($search))
            )->values();
        }

        // Fix: tambah cek string kosong supaya category '' tidak ikut filter
        if ($category && $category !== 'Semua') {
            $katalogs = $katalogs->filter(fn($i) => $i->category === $category)->values();
        }

        // Sort yang sebelumnya tidak ada sama sekali di controller
        if ($sort === 'termurah') {
            $katalogs = $katalogs->sortBy('price')->values();
        } elseif ($sort === 'termahal') {
            $katalogs = $katalogs->sortByDesc('price')->values();
        } elseif ($sort === 'testimoni_terbanyak') {
            $katalogs = $katalogs->sortByDesc('ulasan')->values();
        }

        return view('public.katalog.index', compact('katalogs', 'sort'));
    }

    /**
     * Hitung jumlah & rata-rata rating testimoni terpublikasi per item
     * (jasa/paket/barang), dikelompokkan berdasarkan id item. Dihitung
     * sekali per batch agar tidak query N+1 di dalam loop map() item katalog.
     *
     * @return \Illuminate\Support\Collection<int, array{count:int, avg:float}>
     */
    private function ulasanStats(string $jenisItem, string $idColumn): \Illuminate\Support\Collection
    {
        return Testimoni::where('dipublikasikan', true)
            ->whereHas('pemesanan.detailPemesanans', fn($q) => $q->where('jenis_item', $jenisItem))
            ->with(['pemesanan.detailPemesanans' => fn($q) => $q->where('jenis_item', $jenisItem)])
            ->get()
            ->flatMap(fn($t) => $t->pemesanan->detailPemesanans->pluck($idColumn)->map(fn($id) => [
                'id'     => $id,
                'rating' => $t->rating,
            ]))
            ->groupBy('id')
            ->map(fn($group) => [
                'count' => $group->count(),
                'avg'   => round($group->avg('rating'), 1),
            ]);
    }

    public function show(string $slug)
    {
        $parts  = explode('-', $slug, 2);
        $type   = $parts[0] ?? null;
        $typeId = $parts[1] ?? null;

        $fotos      = collect();
        $testimonis = collect();

        if ($type === 'jasa' && $typeId) {
            $model = Jasa::with(['fotos' => fn($q) => $q->orderBy('urutan')])->findOrFail($typeId);

            $fotos = $model->fotos;

            $testimonis = Testimoni::where('dipublikasikan', true)
                ->whereHas('pemesanan', fn($q) => $q->whereHas(
                    'detailPemesanans',
                    fn($q2) => $q2->where('jenis_item', 'jasa')->where('jasa_id', (int) $typeId)
                ))
                ->with(['user', 'fotos'])
                ->latest()
                ->get();

            $avgRating = $testimonis->isNotEmpty()
                ? round($testimonis->avg('rating'), 1)
                : 0;

            $item = (object)[
                'id'        => $slug,
                'type'      => 'jasa',
                'name'      => $model->nama_jasa,
                'category'  => 'Jasa',
                'img'       => $model->thumbnail_path ? Storage::url($model->thumbnail_path) : 'image/background.png',
                'price'     => (float) $model->harga,
                'desc'      => $model->deskripsi,
                'available' => true,
                'rating'    => $avgRating,
                'ulasan'    => $testimonis->count(),
                'color'     => null,
                'material'  => null,
                'stok'      => null,
            ];
        } elseif ($type === 'paket' && $typeId) {
            $model = Paket::with(['paketDetails.jasa', 'fotos' => fn($q) => $q->orderBy('urutan')])->findOrFail($typeId);
            $fotos = $model->fotos;

            $testimonis = Testimoni::where('dipublikasikan', true)
                ->whereHas('pemesanan', fn($q) => $q->whereHas(
                    'detailPemesanans',
                    fn($q2) => $q2->where('jenis_item', 'paket')->where('paket_id', (int) $typeId)
                ))
                ->with(['user', 'fotos'])
                ->latest()
                ->get();

            $avgRating = $testimonis->isNotEmpty() ? round($testimonis->avg('rating'), 1) : 0;

            $item  = (object)[
                'id'        => $slug,
                'type'      => 'paket',
                'name'      => $model->nama_paket,
                'category'  => 'Paket Acara',
                'img'       => $model->thumbnail_path ? Storage::url($model->thumbnail_path) : 'image/background.png',
                'price'     => (float) $model->harga,
                'desc'      => $model->deskripsi,
                'available' => true,
                'rating'    => $avgRating,
                'ulasan'    => $testimonis->count(),
                'color'     => null,
                'material'  => null,
                'stok'      => null,
                'details'   => $model->paketDetails,
            ];
        } elseif ($type === 'barang' && $typeId) {
            $model = Barang::with(['fotos' => fn($q) => $q->orderBy('urutan')])->findOrFail($typeId);
            $fotos = $model->fotos;


            $testimonis = Testimoni::where('dipublikasikan', true)
                ->whereHas('pemesanan', fn($q) => $q->whereHas(
                    'detailPemesanans',
                    fn($q2) => $q2->where('jenis_item', 'barang')->where('barang_id', (int) $typeId)
                ))
                ->with(['user', 'fotos'])
                ->latest()
                ->get();

            $avgRating = $testimonis->isNotEmpty() ? round($testimonis->avg('rating'), 1) : 0;

            $item  = (object)[
                'id'        => $slug,
                'type'      => 'barang',
                'name'      => $model->nama_barang,
                'category'  => 'Sewa Barang',
                'img'       => $model->thumbnail_path ? Storage::url($model->thumbnail_path) : 'image/background.png',
                'price'     => (float) $model->harga,
                'desc'      => $model->deskripsi,
                'available' => $model->stok > 0,
                'rating'    => $avgRating,
                'ulasan'    => $testimonis->count(),
                'color'     => null,
                'material'  => null,
                'stok'      => $model->stok,
            ];
        } else {
            abort(404);
        }

        return view('public.katalog.show', compact('item', 'fotos', 'testimonis'));
    }
}

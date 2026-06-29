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

        $jasaItems = Jasa::where('aktif', true)->get()->map(fn($j) => (object)[
            'id'       => 'jasa-' . $j->id,
            'type'     => 'jasa',
            'name'     => $j->nama_jasa,
            'category' => 'Jasa',
            'img'      => $j->thumbnail_path ? Storage::url($j->thumbnail_path) : 'image/background.png',
            'price'    => (float) $j->harga,
            'desc'     => $j->deskripsi,
            'available' => true,
            'rating'   => 4.8,
            'ulasan'   => 0,
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
            'rating'   => 4.8,
            'ulasan'   => 0,
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
            'rating'   => 4.8,
            'ulasan'   => 0,
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
        }

        return view('public.katalog.index', compact('katalogs', 'sort'));
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
                ->with('user')
                ->latest()
                ->get();

            $avgRating = $testimonis->isNotEmpty()
                ? round($testimonis->avg('rating'), 1)
                : 4.8;

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
            $model = Paket::with('paketDetails.jasa')->findOrFail($typeId);

            $testimonis = Testimoni::where('dipublikasikan', true)
                ->whereHas('pemesanan', fn($q) => $q->whereHas(
                    'detailPemesanans',
                    fn($q2) => $q2->where('jenis_item', 'paket')->where('paket_id', (int) $typeId)
                ))
                ->with('user')
                ->latest()
                ->get();

            $avgRating = $testimonis->isNotEmpty() ? round($testimonis->avg('rating'), 1) : 4.8;

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
            $model = Barang::findOrFail($typeId);

            $testimonis = Testimoni::where('dipublikasikan', true)
                ->whereHas('pemesanan', fn($q) => $q->whereHas(
                    'detailPemesanans',
                    fn($q2) => $q2->where('jenis_item', 'barang')->where('barang_id', (int) $typeId)
                ))
                ->with('user')
                ->latest()
                ->get();

            $avgRating = $testimonis->isNotEmpty() ? round($testimonis->avg('rating'), 1) : 4.8;

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

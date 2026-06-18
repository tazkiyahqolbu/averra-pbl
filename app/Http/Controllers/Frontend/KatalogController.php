<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Jasa;
use App\Models\Paket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KatalogController extends Controller
{
    public function index(Request $request)
    {
        $search   = $request->get('search', '');
        $category = $request->get('category', 'Semua');

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

        $katalogs = $jasaItems->concat($paketItems);

        if ($search) {
            $katalogs = $katalogs->filter(
                fn($i) => str_contains(strtolower($i->name), strtolower($search))
            )->values();
        }

        if ($category !== 'Semua') {
            $katalogs = $katalogs->filter(fn($i) => $i->category === $category)->values();
        }

        return view('public.katalog.index', compact('katalogs'));
    }

    public function show(string $slug)
    {
        $parts  = explode('-', $slug, 2);
        $type   = $parts[0] ?? null;
        $typeId = $parts[1] ?? null;

        if ($type === 'jasa' && $typeId) {
            $model = Jasa::findOrFail($typeId);
            $item  = (object)[
                'id'       => $slug,
                'type'     => 'jasa',
                'name'     => $model->nama_jasa,
                'category' => 'Jasa',
                'img'      => $model->thumbnail_path ? Storage::url($model->thumbnail_path) : 'image/background.png',
                'price'    => (float) $model->harga,
                'desc'     => $model->deskripsi,
                'available' => true,
                'rating'   => 4.8,
                'ulasan'   => 0,
                'color'    => null,
                'material' => null,
                'stok'     => null,
            ];
        } elseif ($type === 'paket' && $typeId) {
            $model = Paket::findOrFail($typeId);
            $item  = (object)[
                'id'       => $slug,
                'type'     => 'paket',
                'name'     => $model->nama_paket,
                'category' => 'Paket Acara',
                'img'      => $model->thumbnail_path ? Storage::url($model->thumbnail_path) : 'image/background.png',
                'price'    => (float) $model->harga,
                'desc'     => $model->deskripsi,
                'available' => true,
                'rating'   => 4.8,
                'ulasan'   => 0,
                'color'    => null,
                'material' => null,
                'stok'     => null,
            ];
        } else {
            abort(404);
        }

        return view('public.katalog.show', compact('item'));
    }
}

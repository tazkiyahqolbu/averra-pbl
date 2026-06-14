<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KategoriPaket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KategoriPaketController extends Controller
{
    public function index()
    {
        $kategoriPakets = KategoriPaket::latest()->get();

        return view(
            'admin.kategori-paket.index',
            compact('kategoriPakets')
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
        ]);

        $ikonPath = null;

        if ($request->hasFile('ikon_path')) {

            $ikonPath = $request
                ->file('ikon_path')
                ->store('kategori-paket', 'public');
        }

        KategoriPaket::create([

            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'ikon_path' => $ikonPath,

        ]);

        return back()
            ->with('success', 'Kategori berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $kategori = KategoriPaket::findOrFail($id);

        $ikonPath = $kategori->ikon_path;

        if ($request->hasFile('ikon_path')) {

            if (
                $kategori->ikon_path &&
                Storage::disk('public')->exists($kategori->ikon_path)
            ) {

                Storage::disk('public')
                    ->delete($kategori->ikon_path);
            }

            $ikonPath = $request
                ->file('ikon_path')
                ->store('kategori-paket', 'public');
        }

        $kategori->update([

            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'ikon_path' => $ikonPath,

        ]);

        return back()
            ->with('success', 'Kategori berhasil diperbarui');
    }

    public function destroy($id)
    {
        $kategori = KategoriPaket::findOrFail($id);

        if (
            $kategori->ikon_path &&
            Storage::disk('public')
                ->exists($kategori->ikon_path)
        ) {

            Storage::disk('public')
                ->delete($kategori->ikon_path);
        }

        $kategori->delete();

        return back()
            ->with('success', 'Kategori berhasil dihapus');
    }
}

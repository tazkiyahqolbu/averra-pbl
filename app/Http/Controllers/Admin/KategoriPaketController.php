<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KategoriPaket;
use Illuminate\Http\Request;

class KategoriPaketController extends Controller
{
    public function index()
    {
        $kategoriPakets = KategoriPaket::latest()->get();

        return view('admin.kategori-paket.index', compact('kategoriPakets'));
    }

    public function create()
    {
        return view('admin.kategori-paket.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
        ]);

        KategoriPaket::create([
            'nama'      => $request->nama,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()
            ->route('admin.kategori-paket.index')
            ->with('success', 'Kategori berhasil ditambahkan');
    }

    public function edit($id)
    {
        $kategoriPaket = KategoriPaket::findOrFail($id);

        return view('admin.kategori-paket.edit', compact('kategoriPaket'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
        ]);

        KategoriPaket::findOrFail($id)->update([
            'nama'      => $request->nama,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()
            ->route('admin.kategori-paket.index')
            ->with('success', 'Kategori berhasil diperbarui');
    }

    public function destroy($id)
    {
        KategoriPaket::findOrFail($id)->delete();

        return back()->with('success', 'Kategori berhasil dihapus');
    }
}

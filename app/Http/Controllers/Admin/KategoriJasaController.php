<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KategoriJasa;
use Illuminate\Http\Request;

class KategoriJasaController extends Controller
{
    public function index()
    {
        $kategori = KategoriJasa::latest()->get();

        return view('admin.kategori-jasa.index', compact('kategori'));
    }

    public function create()
    {
        return view('admin.kategori-jasa.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'      => 'required|max:255',
            'deskripsi' => 'nullable',
        ]);

        KategoriJasa::create([
            'nama'      => $request->nama,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()
            ->route('admin.kategori-jasa.index')
            ->with('success', 'Kategori jasa berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $kategori = KategoriJasa::findOrFail($id);

        return view('admin.kategori-jasa.edit', compact('kategori'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama'      => 'required|max:255',
            'deskripsi' => 'nullable',
        ]);

        $kategori = KategoriJasa::findOrFail($id);

        $kategori->update([
            'nama'      => $request->nama,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()
            ->route('admin.kategori-jasa.index')
            ->with('success', 'Kategori jasa berhasil diubah.');
    }

    public function destroy($id)
    {
        KategoriJasa::findOrFail($id)->delete();

        return back()->with('success', 'Kategori jasa berhasil dihapus.');
    }
}

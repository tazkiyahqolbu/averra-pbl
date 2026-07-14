<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KategoriBarang;
use App\Models\KategoriJasa;
use App\Models\KategoriPaket;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    private const MODELS = [
        'barang' => KategoriBarang::class,
        'jasa'   => KategoriJasa::class,
        'paket'  => KategoriPaket::class,
    ];

    private function resolveModel(string $tipe): string
    {
        return self::MODELS[$tipe] ?? abort(404);
    }

    public function index(string $tipe)
    {
        $model = $this->resolveModel($tipe);
        $kategori = $model::latest()->get();
        return view("admin.kategori-{$tipe}.index", compact('kategori', 'tipe'));
    }

    public function create(string $tipe)
{
    $this->resolveModel($tipe);
    return view("admin.kategori-{$tipe}.create", compact('tipe'));
}

    public function store(Request $request, string $tipe)
    {
        $model = $this->resolveModel($tipe);
        $request->validate(['nama' => 'required|max:255', 'deskripsi' => 'nullable']);
        $model::create($request->only('nama', 'deskripsi'));
        return redirect()->route('admin.kategori.index', $tipe)->with('success', 'Kategori berhasil ditambahkan.');
    }

   public function edit(string $tipe, $id)
{
    $model = $this->resolveModel($tipe);
    $kategori = $model::findOrFail($id);
    return view("admin.kategori-{$tipe}.edit", compact('kategori', 'tipe'));
}

    public function update(Request $request, string $tipe, $id)
    {
        $model = $this->resolveModel($tipe);
        $request->validate(['nama' => 'required|max:255', 'deskripsi' => 'nullable']);
        $model::findOrFail($id)->update($request->only('nama', 'deskripsi'));
        return redirect()->route('admin.kategori.index', $tipe)->with('success', 'Kategori berhasil diubah.');
    }

    public function destroy(string $tipe, $id)
    {
        $model = $this->resolveModel($tipe);
        $model::findOrFail($id)->delete();
        return back()->with('success', 'Kategori berhasil dihapus.');
    }
}

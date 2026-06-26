<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\KategoriBarang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BarangController extends Controller
{
    public function index()
    {
        $barangs = Barang::with('kategori')->latest()->get();

        return view('admin.barang.index', compact('barangs'));
    }

    public function create()
    {
        $kategoriBarangs = KategoriBarang::all();

        return view(
            'admin.barang.create',
            compact('kategoriBarangs')
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori_barang_id' => 'required|exists:kategori_barang,id',
            'nama_barang' => 'required',
            'harga' => 'required|numeric',
            'nilai_barang' => 'required|numeric',
            'stok' => 'required|integer',
            'thumbnail_path' => 'nullable|image',
        ]);

        $thumbnail = null;

        if ($request->hasFile('thumbnail_path')) {

            $thumbnail = $request
                ->file('thumbnail_path')
                ->store('barang', 'public');
        }

        Barang::create([

            'kategori_barang_id' => $request->kategori_barang_id,
            'nama_barang' => $request->nama_barang,
            'deskripsi' => $request->deskripsi,
            'harga' => $request->harga,
            'nilai_barang' => $request->nilai_barang,
            'stok' => $request->stok,
            'thumbnail_path' => $thumbnail,
            'aktif' => $request->aktif ?? 1,

        ]);

        return redirect()
            ->route('admin.barang.index')
            ->with('success', 'Barang berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $barang = Barang::findOrFail($id);

        $kategoriBarangs = KategoriBarang::all();

        return view(
            'admin.barang.edit',
            compact('barang', 'kategoriBarangs')
        );
    }

    public function update(Request $request, $id)
    {
        $barang = Barang::findOrFail($id);

        $thumbnail = $barang->thumbnail_path;

        if ($request->hasFile('thumbnail_path')) {

            if (
                $barang->thumbnail_path &&
                Storage::disk('public')->exists($barang->thumbnail_path)
            ) {

                Storage::disk('public')
                    ->delete($barang->thumbnail_path);
            }

            $thumbnail = $request
                ->file('thumbnail_path')
                ->store('barang', 'public');
        }

        $barang->update([

            'kategori_barang_id' => $request->kategori_barang_id,
            'nama_barang' => $request->nama_barang,
            'deskripsi' => $request->deskripsi,
            'harga' => $request->harga,
            'nilai_barang' => $request->nilai_barang,
            'stok' => $request->stok,
            'thumbnail_path' => $thumbnail,
            'aktif' => $request->aktif,

        ]);

        return redirect()
            ->route('admin.barang.index')
            ->with('success', 'Barang berhasil diupdate.');
    }

    public function destroy($id)
    {
        $barang = Barang::findOrFail($id);

        if (
            $barang->thumbnail_path &&
            Storage::disk('public')->exists($barang->thumbnail_path)
        ) {

            Storage::disk('public')
                ->delete($barang->thumbnail_path);
        }

        $barang->delete();

        return back()
            ->with('success', 'Barang berhasil dihapus.');
    }
}

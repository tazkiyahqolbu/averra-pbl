<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KategoriJasa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KategoriJasaController extends Controller
{
    public function index()
    {
        $kategori = KategoriJasa::latest()->get();

        return view(
            'admin.kategori-jasa.index',
            compact('kategori')
        );
    }

    public function create()
    {
        return view('admin.kategori-jasa.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|max:255',
            'deskripsi' => 'nullable',
            'ikon_path' => 'nullable|image',
        ]);

        $ikon = null;

        if ($request->hasFile('ikon_path')) {
            $ikon = $request
                ->file('ikon_path')
                ->store('kategori-jasa', 'public');
        }

        KategoriJasa::create([
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'ikon_path' => $ikon,
        ]);

        return redirect()
            ->route('admin.kategori-jasa.index')
            ->with('success', 'Kategori jasa berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $kategori = KategoriJasa::findOrFail($id);

        return view(
            'admin.kategori-jasa.edit',
            compact('kategori')
        );
    }

    public function update(Request $request, $id)
    {
        $kategori = KategoriJasa::findOrFail($id);

        $ikon = $kategori->ikon_path;

        if ($request->hasFile('ikon_path')) {

            if (
                $kategori->ikon_path &&
                Storage::disk('public')->exists($kategori->ikon_path)
            ) {
                Storage::disk('public')->delete($kategori->ikon_path);
            }

            $ikon = $request
                ->file('ikon_path')
                ->store('kategori-jasa', 'public');
        }

        $kategori->update([
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'ikon_path' => $ikon,
        ]);

        return redirect()
            ->route('admin.kategori-jasa.index')
            ->with('success', 'Kategori jasa berhasil diubah.');
    }

    public function destroy($id)
    {
        $kategori = KategoriJasa::findOrFail($id);

        if (
            $kategori->ikon_path &&
            Storage::disk('public')->exists($kategori->ikon_path)
        ) {
            Storage::disk('public')->delete($kategori->ikon_path);
        }

        $kategori->delete();

        return back()->with('success', 'Kategori jasa berhasil dihapus.');
    }
}

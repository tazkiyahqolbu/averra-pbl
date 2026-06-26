<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KategoriBarang;
use Illuminate\Http\Request;

class KategoriBarangController extends Controller
{
    public function index()
    {
        $kategori = KategoriBarang::latest()->get();

        return view(
            'admin.kategori-barang.index',
            compact('kategori')
        );
    }

    public function create()
    {
        return view('admin.kategori-barang.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|max:255',
            'deskripsi' => 'nullable',
        ]);

        KategoriBarang::create([
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()
            ->route('admin.kategori-barang.index')
            ->with('success', 'Kategori berhasil ditambahkan.');
    }
}

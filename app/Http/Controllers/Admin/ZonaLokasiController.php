<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ZonaLokasi;
use Illuminate\Http\Request;

class ZonaLokasiController extends Controller
{
    public function index()
    {
        $zonaLokasi = ZonaLokasi::latest()->get();

        return view(
            'admin.zona-lokasi.index',
            compact('zonaLokasi')
        );
    }

    public function create()
    {
        return view('admin.zona-lokasi.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_zona' => 'required|max:255',
            'keterangan' => 'nullable',
            'biaya' => 'required|numeric|min:0',
            'persentase' => 'required|numeric|min:0|max:100',
        ]);

        ZonaLokasi::create($request->all());

        return redirect()
            ->route('admin.zona-lokasi.index')
            ->with('success', 'Zona lokasi berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $zona = ZonaLokasi::findOrFail($id);

        return view(
            'admin.zona-lokasi.edit',
            compact('zona')
        );
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_zona' => 'required|max:255',
            'keterangan' => 'nullable',
            'biaya' => 'required|numeric|min:0',
            'persentase' => 'required|numeric|min:0|max:100',
        ]);

        $zona = ZonaLokasi::findOrFail($id);

        $zona->update($request->all());

        return redirect()
            ->route('admin.zona-lokasi.index')
            ->with('success', 'Zona lokasi berhasil diubah.');
    }

    public function destroy($id)
    {
        ZonaLokasi::findOrFail($id)->delete();

        return back()->with('success', 'Zona lokasi berhasil dihapus.');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jasa;
use App\Models\KategoriJasa;
use App\Models\FotoJasa;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class JasaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jasaItems = Jasa::with('kategori')
        ->latest()
        ->get();

        $kategoris = KategoriJasa::all();

    return view('admin.jasa.index', compact('jasaItems', 'kategoris'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategoris = KategoriJasa::all();

        return view('admin.jasa.create', compact('kategoris'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kategori_jasa_id' => 'required|exists:kategori_jasa,id',
            'nama_jasa' => 'required|string|max:255',
            'harga' => 'required|numeric',
            'maks_booking_harian' => 'required|integer|min:1',
            'thumbnail_path' => 'nullable|image',
        ]);

        $thumbnailPath = null;

        if ($request->hasFile('thumbnail_path')) {
            $thumbnailPath = $request->file('thumbnail_path')
                ->store('jasa/thumbnail', 'public');
        }

        $jasa = Jasa::create([
            'kategori_jasa_id' => $request->kategori_jasa_id,
            'nama_jasa' => $request->nama_jasa,
            'deskripsi' => $request->deskripsi,
            'harga' => $request->harga,
            'maks_booking_harian' => $request->maks_booking_harian,
            'thumbnail_path' => $thumbnailPath,
            'aktif' => $request->input('aktif', 0) == 1,
        ]);

        if ($request->hasFile('foto_jasa')) {

            foreach ($request->file('foto_jasa') as $index => $foto) {

                $fotoPath = $foto->store('jasa/foto', 'public');

                FotoJasa::create([
                    'jasa_id' => $jasa->id,
                    'foto_path' => $fotoPath,
                    'keterangan' => $request->keterangan_foto[$index] ?? null,
                    'urutan' => $request->urutan_foto[$index] ?? ($index + 1),
                ]);

            }
        }

        return redirect()
            ->route('admin.jasa.index')
            ->with('success', 'Jasa berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $jasa = Jasa::with('fotos')->findOrFail($id);

        $kategoris = KategoriJasa::all();

        return view('admin.jasa.edit', compact('jasa', 'kategoris'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'kategori_jasa_id' => 'required|exists:kategori_jasa,id',
            'nama_jasa' => 'required|string|max:255',
            'harga' => 'required|numeric',
            'maks_booking_harian' => 'required|integer|min:1',
            'thumbnail_path' => 'nullable|image',
        ]);

        $jasa = Jasa::findOrFail($id);

        // upload thumbnail baru
        if ($request->hasFile('thumbnail_path')) {

            if ($jasa->thumbnail_path &&
                Storage::disk('public')->exists($jasa->thumbnail_path)) {

                Storage::disk('public')->delete($jasa->thumbnail_path);
            }

            $thumbnailPath = $request->file('thumbnail_path')
                ->store('jasa/thumbnail', 'public');

        } else {

            $thumbnailPath = $jasa->thumbnail_path;
        }

        $jasa->update([
            'kategori_jasa_id' => $request->kategori_jasa_id,
            'nama_jasa' => $request->nama_jasa,
            'deskripsi' => $request->deskripsi,
            'harga' => $request->harga,
            'maks_booking_harian' => $request->maks_booking_harian,
            'thumbnail_path' => $thumbnailPath,
            'aktif' => $request->input('aktif', 0) == 1,
        ]);

        if ($request->has('keterangan_foto')) {

            foreach ($request->keterangan_foto as $fotoId => $keterangan) {

                $foto = FotoJasa::find($fotoId);

                if ($foto) {

                    $foto->update([
                        'keterangan' => $keterangan,
                        'urutan' => $request->urutan_foto[$fotoId] ?? 1,
                    ]);
                }
            }
        }

        if ($request->hasFile('foto_jasa')) {
            foreach ($request->file('foto_jasa') as $index => $foto) {
                $fotoPath = $foto->store('jasa/foto', 'public');
                FotoJasa::create([
                    'jasa_id' => $jasa->id,
                    'foto_path' => $fotoPath,
                    'keterangan' => null,
                    'urutan' => $jasa->fotos()->count() + $index + 1,
                ]);
            }
        }

        return redirect()
            ->route('admin.jasa.index')
            ->with('success', 'Data jasa berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $jasa = Jasa::with('fotos')->findOrFail($id);

        // hapus thumbnail
        if (
            $jasa->thumbnail_path &&
            Storage::disk('public')->exists($jasa->thumbnail_path)
        ) {
            Storage::disk('public')->delete($jasa->thumbnail_path);
        }

        // hapus semua file foto galeri
        foreach ($jasa->fotos as $foto) {

            if (
                $foto->foto_path &&
                Storage::disk('public')->exists($foto->foto_path)
            ) {
                Storage::disk('public')->delete($foto->foto_path);
            }
        }

        // hapus data jasa
        $jasa->delete();

        return redirect()
            ->route('admin.jasa.index')
            ->with('success', 'Jasa berhasil dihapus');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Paket;
use App\Models\KategoriPaket;
use App\Models\PaketDetail;
use App\Models\FotoPaket;
use App\Models\Jasa;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class PaketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Paket::with('kategori');

        if ($request->search) {
            $query->where('nama_paket', 'like', '%' . $request->search . '%');
        }

        $paketItems = $query->latest()->get();

        return view('admin.paket.index', compact('paketItems'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategoris = KategoriPaket::all();
        $jasaList  = Jasa::where('aktif', true)->get(['id', 'nama_jasa']);

        return view('admin.paket.create', compact('kategoris', 'jasaList'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kategori_paket_id' => 'required|exists:kategori_paket,id',
            'nama_paket'        => 'required',
            'harga'             => 'required|numeric',
            'thumbnail_path'    => 'nullable|image',
            'foto_paket.*'      => 'nullable|image',
        ]);

        $thumbnailPath = null;

        if ($request->hasFile('thumbnail_path')) {

            $thumbnailPath = $request->file('thumbnail_path')
                ->store('paket/thumbnail', 'public');
        }

        $paket = Paket::create([
            'kategori_paket_id' => $request->kategori_paket_id,
            'nama_paket' => $request->nama_paket,
            'deskripsi' => $request->deskripsi,
            'harga' => $request->harga,
            'keterangan_acara' => $request->keterangan_acara,
            'catatan' => $request->catatan,
            'thumbnail_path' => $thumbnailPath,
            'aktif' => $request->input('aktif', 1) == 1,
        ]);

        if ($request->nama_item) {

            foreach ($request->nama_item as $index => $item) {

                if (!empty($item)) {

                    PaketDetail::create([
                        'paket_id'       => $paket->id,
                        'jasa_id'        => !empty($request->jasa_id[$index]) ? $request->jasa_id[$index] : null,
                        'nama_item'      => $item,
                        'jumlah'         => $request->jumlah[$index] ?? 1,
                        'tipe'           => $request->tipe[$index] ?? 'wajib',
                        'harga_tambahan' => $request->harga_tambahan[$index] ?? 0,
                        'keterangan'     => $request->keterangan[$index] ?? null,
                    ]);
                }
            }
        }

        if ($request->hasFile('foto_paket')) {

            foreach ($request->file('foto_paket') as $index => $foto) {

                $fotoPath = $foto->store('paket/foto', 'public');

                FotoPaket::create([
                    'paket_id' => $paket->id,
                    'foto_path' => $fotoPath,
                    'urutan' => $index + 1,
                ]);
            }
        }

        return redirect()
            ->route('admin.paket.index')
            ->with('success', 'Paket berhasil ditambahkan');
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
        $paket = Paket::with([
            'kategori',
            'fotos',
            'paketDetails'
        ])->findOrFail($id);

        $kategoris = KategoriPaket::all();
        $jasaList  = Jasa::where('aktif', true)->get(['id', 'nama_jasa']);

        return view(
            'admin.paket.edit',
            compact('paket', 'kategoris', 'jasaList')
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'kategori_paket_id' => 'required|exists:kategori_paket,id',
            'nama_paket'        => 'required',
            'harga'             => 'required|numeric',
            'thumbnail_path'    => 'nullable|image',
            'foto_paket.*'      => 'nullable|image',
        ]);

        $paket = Paket::findOrFail($id);

        $thumbnailPath = $paket->thumbnail_path;

        if ($request->hasFile('thumbnail_path')) {

            if (
                $paket->thumbnail_path &&
                Storage::disk('public')
                ->exists($paket->thumbnail_path)
            ) {

                Storage::disk('public')
                    ->delete($paket->thumbnail_path);
            }

            $thumbnailPath = $request
                ->file('thumbnail_path')
                ->store('paket/thumbnail', 'public');
        }

        $paket->update([
            'kategori_paket_id' => $request->kategori_paket_id,
            'nama_paket' => $request->nama_paket,
            'deskripsi' => $request->deskripsi,
            'harga' => $request->harga,
            'keterangan_acara' => $request->keterangan_acara,
            'catatan' => $request->catatan,
            'thumbnail_path' => $thumbnailPath,
            'aktif' => $request->input('aktif', 1) == 1,
        ]);

        if ($request->foto_id) {

            foreach ($request->foto_id as $index => $idFoto) {

                $foto = FotoPaket::find($idFoto);

                if ($foto) {

                    $foto->update([

                        'keterangan' =>
                        $request->keterangan_foto[$index] ?? null,

                        'urutan' =>
                        $request->urutan_foto[$index] ?? 1,

                    ]);
                }
            }
        }

        if ($request->hasFile('foto_paket')) {
            foreach ($request->file('foto_paket') as $index => $foto) {
                $fotoPath = $foto->store('paket/foto', 'public');
                FotoPaket::create([
                    'paket_id' => $paket->id,
                    'foto_path' => $fotoPath,
                    'keterangan' => null,
                    'urutan' => $paket->fotos()->count() + $index + 1,
                ]);
            }
        }

        return redirect()
            ->route('admin.paket.index')
            ->with('success', 'Paket berhasil diperbarui');
    }

    public function destroyFoto($id)
    {
        $foto = FotoPaket::findOrFail($id);

        if (
            $foto->foto_path &&
            Storage::disk('public')->exists($foto->foto_path)
        ) {

            Storage::disk('public')
                ->delete($foto->foto_path);
        }

        $foto->delete();

        return back()
            ->with('success', 'Foto berhasil dihapus');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $paket = Paket::with(['fotos', 'paketDetails'])
            ->findOrFail($id);

        // hapus file thumbnail
        if (
            $paket->thumbnail_path &&
            Storage::disk('public')
            ->exists($paket->thumbnail_path)
        ) {

            Storage::disk('public')
                ->delete($paket->thumbnail_path);
        }

        // hapus file foto galeri
        foreach ($paket->fotos as $foto) {

            if (
                $foto->foto_path &&
                Storage::disk('public')
                ->exists($foto->foto_path)
            ) {

                Storage::disk('public')
                    ->delete($foto->foto_path);
            }

            $foto->delete();
        }

        // hapus detail paket
        $paket->paketDetails()->delete();

        // hapus paket
        $paket->delete();

        return redirect()
            ->route('admin.paket.index')
            ->with('success', 'Paket berhasil dihapus');
    }
}

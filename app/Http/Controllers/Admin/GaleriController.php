<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Galeri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GaleriController extends Controller
{
    public function index()
    {
        $galeri = Galeri::latest()->get();

        return view(
            'admin.galeri.index',
            compact('galeri')
        );
    }

    public function create()
    {
        return view('admin.galeri.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|max:255',
            'kategori' => 'nullable|max:255',
            'media_path' => 'required|file|mimes:jpg,jpeg,png,mp4,mov',
            'jenis_media' => 'required',
            'keterangan' => 'nullable',
            'unggulan' => 'nullable'
        ]);

        $media = $request
            ->file('media_path')
            ->store('galeri', 'public');

        Galeri::create([
            'judul' => $request->judul,
            'kategori' => $request->kategori,
            'media_path' => $media,
            'jenis_media' => $request->jenis_media,
            'keterangan' => $request->keterangan,
            'unggulan' => $request->has('unggulan')
        ]);

        return redirect()
            ->route('admin.galeri.index')
            ->with('success', 'Galeri berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $galeri = Galeri::findOrFail($id);

        return view(
            'admin.galeri.edit',
            compact('galeri')
        );
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required|max:255',
            'kategori' => 'nullable|max:255',
            'media_path' => 'nullable|file|mimes:jpg,jpeg,png,mp4,mov',
            'jenis_media' => 'required',
            'keterangan' => 'nullable',
            'unggulan' => 'nullable'
        ]);

        $galeri = Galeri::findOrFail($id);

        $media = $galeri->media_path;

        if ($request->hasFile('media_path')) {

            if (
                $media &&
                Storage::disk('public')->exists($media)
            ) {
                Storage::disk('public')->delete($media);
            }

            $media = $request
                ->file('media_path')
                ->store('galeri', 'public');
        }

        $galeri->update([
            'judul' => $request->judul,
            'kategori' => $request->kategori,
            'media_path' => $media,
            'jenis_media' => $request->jenis_media,
            'keterangan' => $request->keterangan,
            'unggulan' => $request->has('unggulan')
        ]);

        return redirect()
            ->route('admin.galeri.index')
            ->with('success', 'Galeri berhasil diubah.');
    }

    public function destroy($id)
    {
        $galeri = Galeri::findOrFail($id);

        if (
            $galeri->media_path &&
            Storage::disk('public')->exists($galeri->media_path)
        ) {
            Storage::disk('public')->delete($galeri->media_path);
        }

        $galeri->delete();

        return back()->with('success', 'Galeri berhasil dihapus.');
    }
}

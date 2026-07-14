<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\FotoTestimoni;
use App\Models\Pemesanan;
use App\Models\Testimoni;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TestimoniController extends Controller
{
    // Menampilkan halaman form ulasan
    public function create($pemesanan_id)
    {
        // Ambil pesanan milik user yang login dan statusnya harus selesai
        // findOrFail → otomatis 404 kalau tidak ditemukan
        $pesanan = Pemesanan::where('user_id', Auth::id())
            ->where('status', 'selesai')
            ->with('testimoni')
            ->findOrFail($pemesanan_id);

        // Jaga-jaga kalau status 'selesai' ke-set tanpa pelunasan benar-benar terverifikasi
        if (!$pesanan->isLunas()) {
            return redirect()->route('user.pemesanan.show', $pemesanan_id)
                ->with('error', 'Pesanan belum lunas. Selesaikan pelunasan terlebih dahulu sebelum memberi ulasan.');
        }

        // Kalau pesanan ini sudah punya testimoni, tidak perlu tampilkan form lagi
        if ($pesanan->testimoni) {
            return redirect()->route('user.pemesanan.show', $pemesanan_id)
                ->with('info', 'Kamu sudah memberikan ulasan untuk pesanan ini.');
        }

        // Kirim data pesanan ke view supaya bisa ditampilkan di form
        return view('user.testimoni.create', compact('pesanan'));
    }

    // Memproses dan menyimpan ulasan dari form
    public function store(Request $request, $pemesanan_id)
    {
        // Cek ulang seperti create() — antisipasi user kirim POST langsung tanpa lewat form
        $pesanan = Pemesanan::where('user_id', Auth::id())
            ->where('status', 'selesai')
            ->with('testimoni')
            ->findOrFail($pemesanan_id);

        if (!$pesanan->isLunas()) {
            return redirect()->route('user.pemesanan.show', $pemesanan_id)
                ->with('error', 'Pesanan belum lunas. Selesaikan pelunasan terlebih dahulu sebelum memberi ulasan.');
        }

        // Cegah duplikat ulasan untuk pesanan yang sama
        if ($pesanan->testimoni) {
            return redirect()->route('user.pemesanan.show', $pemesanan_id)
                ->with('info', 'Kamu sudah memberikan ulasan untuk pesanan ini.');
        }

        // Validasi input dari form sebelum disimpan ke database
        // Kalau gagal, Laravel otomatis redirect balik ke form dengan pesan error
        $request->validate([
            'rating'        => 'required|integer|min:1|max:5',  // wajib, angka 1-5
            'isi_testimoni' => 'required|string|min:10|max:1000', // wajib, min 10 karakter
            'fotos.*'       => 'nullable|image|max:2048',        // opsional, maks 2MB per foto
        ]);

        // Simpan ulasan ke tabel testimoni
        // dipublikasikan: true → langsung tampil di halaman publik
        $testimoni = Testimoni::create([
            'user_id'        => Auth::id(),
            'pemesanan_id'   => $pesanan->id,
            'rating'         => $request->rating,
            'isi_testimoni'  => $request->isi_testimoni,
            'dipublikasikan' => true,
        ]);

        // Kalau user upload foto, simpan tiap foto ke tabel foto_testimoni
        if ($request->hasFile('fotos')) {
            foreach ($request->file('fotos') as $i => $foto) {
                // Simpan file ke storage/app/public/testimoni
                $path = $foto->store('testimoni', 'public');

                FotoTestimoni::create([
                    'testimoni_id' => $testimoni->id,
                    'foto_path'    => $path,
                    'urutan'       => $i + 1, // urutan foto: 1, 2, 3, dst
                ]);
            }
        }

        // Redirect ke detail pesanan (bukan invoice) dengan pesan sukses
        return redirect()->route('user.pemesanan.show', $pemesanan_id)
            ->with('success', 'Terima kasih! Ulasan kamu berhasil dikirim.');
    }
}

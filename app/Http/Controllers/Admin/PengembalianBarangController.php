<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PengembalianBarang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PengembalianBarangController extends Controller
{
    public function index(Request $request)
    {
        $status = request('status', 'semua');

        $query = PengembalianBarang::with([
            'detailPemesanan.barang',
            'detailPemesanan.jasa',
            'detailPemesanan.paket',
            'detailPemesanan.pemesanan',
        ])->latest();

        if ($status !== 'semua') {
            $query->where('status_pengembalian', $status);
        }

        $returns = $query->get();
        $countMenunggu = PengembalianBarang::where('status_pengembalian', 'menunggu')->count();

        return view('admin.pengembalian.index', compact('returns', 'countMenunggu', 'status'));
    }

    public function show($id)
    {
        $return = PengembalianBarang::with([
            'detailPemesanan.barang',
            'detailPemesanan.jasa',
            'detailPemesanan.paket',
            'detailPemesanan.pemesanan',
        ])->findOrFail($id);

        return view('admin.pengembalian.show', compact('return'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kondisi' => 'required|in:baik,rusak_ringan,rusak_berat,hilang',
            'catatan_kerusakan' => 'nullable|string',
            'foto_bukti_path' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'denda_kerusakan' => 'required|numeric|min:0',
        ]);

        $pengembalian = PengembalianBarang::with('detailPemesanan.pemesanan')
            ->findOrFail($id);

        $foto = $pengembalian->foto_bukti_path;

        if ($request->hasFile('foto_bukti_path')) {

            if ($foto && Storage::disk('public')->exists($foto)) {
                Storage::disk('public')->delete($foto);
            }

            $foto = $request->file('foto_bukti_path')
                            ->store('pengembalian', 'public');
        }

        $totalDenda =
            $pengembalian->denda_keterlambatan +
            $request->denda_kerusakan;

        $pengembalian->update([
            'kondisi'             => $request->kondisi,
            'catatan_kerusakan'   => $request->catatan_kerusakan,
            'foto_bukti_path'     => $foto,
            'denda_kerusakan'     => $request->denda_kerusakan,
            'total_denda'         => $totalDenda,
            'status_pengembalian' => 'selesai',
            'status_denda'        => $totalDenda > 0 ? 'menunggu_bayar' : 'tidak_ada',
        ]);

        // Pesanan tetap menunggu_pelunasan (diset sejak tandaiDikembalikan()) — customer
        // masih perlu melunasi sisa sewa (+ denda jika ada) lewat payment gateway.
        // Status baru pindah ke selesai lewat webhook saat pelunasan itu terverifikasi.

        return redirect()
            ->route('admin.pengembalian.index')
            ->with('success', 'Pemeriksaan berhasil disimpan.');
    }
}

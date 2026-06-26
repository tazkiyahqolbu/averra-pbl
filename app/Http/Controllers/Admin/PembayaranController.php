<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PembayaranController extends Controller
{
    public function index(): View
    {
        $status = request('status', 'semua');

        $query = Pembayaran::with(['pemesanan.user'])
            ->whereNotNull('bukti_pembayaran_path')
            ->latest();

        if ($status !== 'semua') {
            $query->where('status', $status);
        }

        $pembayarans   = $query->get();
        $countMenunggu = Pembayaran::whereNotNull('bukti_pembayaran_path')
            ->where('status', 'menunggu')
            ->count();

        return view('admin.pembayaran.index', compact('pembayarans', 'countMenunggu'));
    }

    public function show($id): View
    {
        $pembayaran = Pembayaran::with(['pemesanan.user', 'diverifikasiOleh'])->findOrFail($id);

        return view('admin.pembayaran.show', compact('pembayaran'));
    }

    public function verifikasi($id): RedirectResponse
    {
        $pembayaran = Pembayaran::with('pemesanan')->findOrFail($id);

        $pembayaran->update([
            'status'            => 'terverifikasi',
            'diverifikasi_oleh' => Auth::id(),
            'diverifikasi_pada' => now(),
            'catatan_penolakan' => null,
        ]);

        $pesanan = $pembayaran->pemesanan;
        if ($pembayaran->tahap === 'pelunasan') {
            $pesanan->update(['status' => 'selesai']);
        } else {
            // dp atau langsung → berlangsung
            $pesanan->update(['status' => 'berlangsung']);
        }

        return redirect()->route('admin.pembayaran.index')
            ->with('success', "Pembayaran #{$pembayaran->kode_transaksi} berhasil diverifikasi.");
    }

    public function tolak(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'catatan_penolakan' => 'required|string|max:500',
        ]);

        $pembayaran = Pembayaran::findOrFail($id);
        $pembayaran->update([
            'status'            => 'ditolak',
            'catatan_penolakan' => $request->catatan_penolakan,
            'diverifikasi_oleh' => Auth::id(),
            'diverifikasi_pada' => now(),
        ]);

        return redirect()->route('admin.pembayaran.index')
            ->with('success', "Pembayaran #{$pembayaran->kode_transaksi} ditolak.");
    }
}

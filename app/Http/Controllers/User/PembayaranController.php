<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Pemesanan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PembayaranController extends Controller
{
    public function upload(Request $request): RedirectResponse
    {
        $request->validate([
            'pemesanan_id'     => 'required|integer',
            'bukti_pembayaran' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        $pesanan = Pemesanan::where('user_id', Auth::id())
            ->with('pembayarans')
            ->findOrFail($request->pemesanan_id);

        // Cari pembayaran yang menunggu atau ditolak (boleh upload ulang)
        $pembayaran = $pesanan->pembayarans
            ->whereIn('status', ['menunggu', 'ditolak'])
            ->sortBy('id')
            ->first();

        if (!$pembayaran) {
            // Tidak ada record menunggu → ini adalah pelunasan (DP sudah terverifikasi)
            $dpSudahVerifikasi = $pesanan->pembayarans
                ->where('tahap', 'dp')
                ->where('status', 'terverifikasi')
                ->isNotEmpty();

            if (!$dpSudahVerifikasi) {
                return back()->with('error', 'Tidak ada tagihan pembayaran yang aktif.');
            }

            $sudahBayar = $pesanan->pembayarans
                ->where('status', 'terverifikasi')
                ->sum('jumlah_bayar');

            $sisa = max(0, $pesanan->total_harga - $sudahBayar);

            $pembayaran = $pesanan->pembayarans()->create([
                'kode_transaksi'    => 'TRX-' . strtoupper(Str::random(8)),
                'tahap'             => 'pelunasan',
                'persen_dp'         => null,
                'jumlah_bayar'      => $sisa,
                'metode_pembayaran' => 'transfer',
                'status'            => 'menunggu',
                'dibayar_pada'      => null,
            ]);
        }

        $path = $request->file('bukti_pembayaran')->store('bukti-pembayaran', 'public');

        $pembayaran->update([
            'bukti_pembayaran_path' => $path,
            'dibayar_pada'          => now(),
            'status'                => 'menunggu',
            'catatan_penolakan'     => null,
        ]);

        return redirect()->route('user.pemesanan.show', $pesanan->id)
            ->with('success', 'Bukti pembayaran berhasil diupload. Menunggu verifikasi admin.');
    }
}

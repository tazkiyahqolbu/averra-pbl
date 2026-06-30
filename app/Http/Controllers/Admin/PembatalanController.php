<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\PembatalanDisetujuiMail;
use App\Mail\PembatalanDitolakMail;
use App\Models\Pembatalan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class PembatalanController extends Controller
{
    public function index(): View
    {
        $pembatalans = Pembatalan::with(['pemesanan', 'user'])
            ->orderByRaw("FIELD(status, 'menunggu', 'disetujui', 'ditolak')")
            ->latest()
            ->get();

        return view('admin.pembatalan.index', compact('pembatalans'));
    }

    public function show(int $id): View
    {
        $pembatalan = Pembatalan::with([
            'pemesanan.detailPemesanans.barang',
            'pemesanan.detailPemesanans.jasa',
            'pemesanan.detailPemesanans.paket',
            'pemesanan.pembayarans',
            'user',
            'diprosesoleh',
        ])->findOrFail($id);

        return view('admin.pembatalan.show', compact('pembatalan'));
    }

    public function setujui(Request $request, int $id): RedirectResponse
    {
        $request->validate([
            'jumlah_refund' => 'required|numeric|min:0',
            'catatan_admin' => 'nullable|string|max:500',
        ]);

        $pembatalan = Pembatalan::with(['pemesanan.user', 'pemesanan.detailPemesanans.barang'])->findOrFail($id);

        if ($pembatalan->status !== 'menunggu') {
            return back()->with('error', 'Permintaan ini sudah diproses sebelumnya.');
        }

        $pembatalan->update([
            'status'        => 'disetujui',
            'jumlah_refund' => $request->jumlah_refund,
            'catatan_admin' => $request->catatan_admin,
            'diproses_oleh' => Auth::id(),
            'diproses_pada' => now(),
        ]);

        $pesanan = $pembatalan->pemesanan;

        // Pulihkan stok barang jika sewa dan belum diambil
        if ($pesanan->jenis === 'sewa_barang' && in_array($pesanan->status, ['menunggu_dp', 'menunggu_diambil'])) {
            foreach ($pesanan->detailPemesanans as $detail) {
                if ($detail->barang_id) {
                    $detail->barang->increment('stok', $detail->jumlah);
                }
            }
        }

        $pesanan->update([
            'status'           => 'dibatalkan',
            'alasan_penolakan' => 'Pembatalan disetujui. Refund Rp ' . number_format($request->jumlah_refund, 0, ',', '.') . ' sedang diproses.',
        ]);

        Mail::to($pembatalan->user->email)->queue(new PembatalanDisetujuiMail($pembatalan));

        return redirect()->route('admin.pembatalan.show', $id)
            ->with('success', 'Pembatalan disetujui dan email notifikasi dikirim ke customer.');
    }

    public function tolak(Request $request, int $id): RedirectResponse
    {
        $request->validate([
            'catatan_admin' => 'required|string|min:10|max:500',
        ], [
            'catatan_admin.required' => 'Alasan penolakan wajib diisi.',
            'catatan_admin.min'      => 'Alasan minimal 10 karakter.',
        ]);

        $pembatalan = Pembatalan::with(['pemesanan', 'user'])->findOrFail($id);

        if ($pembatalan->status !== 'menunggu') {
            return back()->with('error', 'Permintaan ini sudah diproses sebelumnya.');
        }

        $pembatalan->update([
            'status'        => 'ditolak',
            'catatan_admin' => $request->catatan_admin,
            'diproses_oleh' => Auth::id(),
            'diproses_pada' => now(),
        ]);

        Mail::to($pembatalan->user->email)->queue(new PembatalanDitolakMail($pembatalan));

        return redirect()->route('admin.pembatalan.show', $id)
            ->with('success', 'Permintaan pembatalan ditolak dan email notifikasi dikirim ke customer.');
    }

    public function uploadBuktiRefund(Request $request, int $id): RedirectResponse
    {
        $request->validate([
            'bukti_transfer' => 'required|image|max:5120',
        ], [
            'bukti_transfer.required' => 'Bukti transfer wajib diunggah.',
            'bukti_transfer.image'    => 'File harus berupa gambar.',
            'bukti_transfer.max'      => 'Ukuran file maksimal 5MB.',
        ]);

        $pembatalan = Pembatalan::findOrFail($id);
        $buktiPath  = $request->file('bukti_transfer')->store('refund', 'public');

        $pembatalan->update([
            'bukti_transfer_path' => $buktiPath,
            'diproses_pada'       => now(),
        ]);

        return redirect()->route('admin.pembatalan.show', $id)
            ->with('success', 'Bukti transfer refund berhasil diupload.');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PengembalianBarang;
use App\Models\Pemesanan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;
use App\Mail\InvoiceMail;
use App\Mail\TagihanPelunasanMail;

class PemesananController extends Controller
{
    public function index(): View
    {
        $status = request('status', 'semua');

        $query = Pemesanan::with([
            'user',
            'detailPemesanans.barang',
            'detailPemesanans.jasa',
            'detailPemesanans.paket',
            'zonaLokasi',
            'pembayarans',
        ])->latest();

        if ($status === 'pengembalian') {
            $query->where('jenis', 'sewa_barang')
                  ->whereIn('status', ['sedang_disewa', 'menunggu_pengembalian']);
        } elseif ($status !== 'semua') {
            $query->where('status', $status);
        }

        $pemesanans = $query->get();

        return view('admin.pemesanan.index', compact('pemesanans'));
    }

    public function show($id): View
    {
        $pemesanan = Pemesanan::with([
            'user',
            'detailPemesanans.barang',
            'detailPemesanans.jasa',
            'detailPemesanans.paket',
            'zonaLokasi',
            'pembayarans',
        ])->findOrFail($id);

        return view('admin.pemesanan.show', compact('pemesanan'));
    }

    public function konfirmasi($id): RedirectResponse
    {
        $pemesanan = Pemesanan::with(['user', 'detailPemesanans'])->findOrFail($id);

        $newStatus = $pemesanan->jenis === 'sewa_barang' ? 'menunggu_dp' : 'dikonfirmasi';
        $pemesanan->update(['status' => $newStatus]);
        Mail::to($pemesanan->user->email)->queue(new InvoiceMail($pemesanan));

        return redirect()->route('admin.pemesanan.index')
            ->with('success', "Pesanan #{$pemesanan->kode_pemesanan} berhasil dikonfirmasi.");
    }

    public function tandaiDiambil($id): RedirectResponse
    {
        $pemesanan = Pemesanan::findOrFail($id);

        if ($pemesanan->status !== 'menunggu_diambil') {
            return back()->with('error', 'Status pesanan tidak valid untuk aksi ini.');
        }

        $pemesanan->update(['status' => 'sedang_disewa']);

        return redirect()->route('admin.pemesanan.show', $id)
            ->with('success', "Barang #{$pemesanan->kode_pemesanan} ditandai sudah diambil. Status diubah ke Sedang Disewa.");
    }

    public function tandaiDikembalikan(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'kondisi'          => 'required|string|max:255',
            'catatan_kerusakan'=> 'nullable|string|max:1000',
            'denda_kerusakan'  => 'nullable|numeric|min:0',
            'foto_bukti'       => 'nullable|image|max:5120',
        ]);

        $pemesanan = Pemesanan::with([
            'user',
            'detailPemesanans.barang',
        ])->findOrFail($id);

        if (!in_array($pemesanan->status, ['sedang_disewa', 'menunggu_pengembalian'])) {
            return back()->with('error', 'Status pesanan tidak valid untuk aksi ini.');
        }

        $detail              = $pemesanan->detailPemesanans->first();
        $tanggalKembaliJadwal = $detail?->tanggal_kembali;

        $dendaKeterlambatan = 0;
        if ($tanggalKembaliJadwal && now()->startOfDay()->gt($tanggalKembaliJadwal)) {
            $hariTerlambat      = (int) $tanggalKembaliJadwal->diffInDays(now()->startOfDay());
            $tarifDenda         = (float) ($detail?->barang?->tarif_denda_per_hari ?? 0);
            $dendaKeterlambatan = $hariTerlambat * $tarifDenda;
        }

        $dendaKerusakan = (float) ($request->denda_kerusakan ?? 0);
        $totalDenda     = $dendaKeterlambatan + $dendaKerusakan;

        $fotoBuktiPath = null;
        if ($request->hasFile('foto_bukti')) {
            $fotoBuktiPath = $request->file('foto_bukti')->store('pengembalian', 'public');
        }

        PengembalianBarang::create([
            'detail_pemesanan_id'    => $detail->id,
            'tanggal_kembali_aktual' => now()->toDateString(),
            'kondisi'                => $request->kondisi,
            'catatan_kerusakan'      => $request->catatan_kerusakan,
            'foto_bukti_path'        => $fotoBuktiPath,
            'status_pengembalian'    => 'diterima',
            'denda_keterlambatan'    => $dendaKeterlambatan,
            'denda_kerusakan'        => $dendaKerusakan,
            'total_denda'            => $totalDenda,
            'status_denda'           => $totalDenda > 0 ? 'menunggu_bayar' : 'tidak_ada',
            'dicatat_oleh'           => Auth::id(),
        ]);

        $pemesanan->update(['status' => 'menunggu_pelunasan']);

        Mail::to($pemesanan->user->email)->queue(new TagihanPelunasanMail($pemesanan));

        return redirect()->route('admin.pemesanan.show', $id)
            ->with('success', "Pengembalian dicatat. Email tagihan pelunasan dikirim ke {$pemesanan->user->email}.");
    }

    public function tolak(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'alasan_penolakan' => ['required', 'string', 'min:10', 'max:500'],
        ], [
            'alasan_penolakan.required' => 'Alasan penolakan wajib diisi.',
            'alasan_penolakan.min'      => 'Alasan minimal 10 karakter.',
        ]);

        $pemesanan = Pemesanan::findOrFail($id);
        $pemesanan->update([
            'status'           => 'dibatalkan',
            'alasan_penolakan' => $request->alasan_penolakan,
        ]);

        return redirect()->route('admin.pemesanan.show', $id)
            ->with('success', "Pesanan #{$pemesanan->kode_pemesanan} berhasil ditolak.");
    }
}

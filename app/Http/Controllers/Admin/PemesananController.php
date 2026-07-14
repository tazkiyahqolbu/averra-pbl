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

        $statusGroups = [
            'menunggu'     => ['menunggu'],
            'dikonfirmasi' => ['dikonfirmasi', 'menunggu_dp'],
            'berlangsung'  => ['berlangsung', 'menunggu_diambil'],
            'pengembalian' => ['sedang_disewa', 'menunggu_pengembalian', 'menunggu_pelunasan'],
            'selesai'      => ['selesai'],
            'dibatalkan'   => ['dibatalkan'],
        ];

        if ($status !== 'semua' && isset($statusGroups[$status])) {
            $query->whereIn('status', $statusGroups[$status]);
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
            'pembatalan',
        ])->findOrFail($id);

        return view('admin.pemesanan.show', compact('pemesanan'));
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

    public function tandaiDikembalikan($id): RedirectResponse
    {
        $pemesanan = Pemesanan::with([
            'user',
            'detailPemesanans.barang',
        ])->findOrFail($id);

        if (!in_array($pemesanan->status, ['sedang_disewa', 'menunggu_pengembalian'])) {
            return back()->with('error', 'Status pesanan tidak valid untuk aksi ini.');
        }

        $detail              = $pemesanan->detailPemesanans->first();

        if (\App\Models\PengembalianBarang::where('detail_pemesanan_id', $detail->id)->exists()) {
            return back()->with('error', 'Data pengembalian untuk pesanan ini sudah tercatat sebelumnya.');
        }

        $tanggalKembaliJadwal = $detail?->tanggal_kembali;

        $dendaKeterlambatan = 0;
        if ($tanggalKembaliJadwal && now()->startOfDay()->gt($tanggalKembaliJadwal)) {
            $hariTerlambat      = (int) $tanggalKembaliJadwal->diffInDays(now()->startOfDay());
            $tarifDenda         = (float) ($detail?->barang?->tarif_denda_per_hari ?? 0);
            $dendaKeterlambatan = $hariTerlambat * $tarifDenda;
        }

        // Kondisi & denda kerusakan diisi admin nanti lewat halaman Pengembalian (form pemeriksaan).
        PengembalianBarang::create([
            'detail_pemesanan_id'    => $detail->id,
            'tanggal_kembali_aktual' => now()->toDateString(),
            'status_pengembalian'    => 'menunggu',
            'denda_keterlambatan'    => $dendaKeterlambatan,
            'total_denda'            => $dendaKeterlambatan,
            'status_denda'           => $dendaKeterlambatan > 0 ? 'menunggu_bayar' : 'tidak_ada',
            'dicatat_oleh'           => Auth::id(),
        ]);

        $pemesanan->update(['status' => 'menunggu_pelunasan']);

        return redirect()->route('admin.pemesanan.show', $id)
            ->with('success', "Pengembalian dicatat. Silakan periksa kondisi barang di halaman Pengembalian.");
    }

    public function tandaiAcaraSelesai($id): RedirectResponse
    {
        $pemesanan = Pemesanan::with(['user', 'pembayarans'])->findOrFail($id);

        if ($pemesanan->jenis !== 'acara' || $pemesanan->status !== 'berlangsung') {
            return back()->with('error', 'Aksi ini hanya untuk pesanan acara yang sedang berlangsung.');
        }

        $sudahBayar = $pemesanan->totalDibayar();

        if ($sudahBayar < (float) $pemesanan->total_harga) {
            $pemesanan->update(['status' => 'menunggu_pelunasan']);
            Mail::to($pemesanan->user->email)->queue(new TagihanPelunasanMail($pemesanan));
            return redirect()->route('admin.pemesanan.show', $id)
                ->with('success', 'Acara ditandai selesai. Email tagihan pelunasan dikirim ke customer.');
        }

        $pemesanan->update(['status' => 'selesai']);
        return redirect()->route('admin.pemesanan.show', $id)
            ->with('success', 'Acara ditandai selesai.');
    }

    public function updateStatus(Request $request, $id): RedirectResponse
    {
        $pemesanan = Pemesanan::with(['user', 'detailPemesanans'])->findOrFail($id);

        $allowedTransitions = [
            'menunggu'              => 'menunggu_dp',
            'menunggu_diambil'      => 'sedang_disewa',
            'sedang_disewa'         => 'menunggu_pengembalian',
            'menunggu_pengembalian' => 'menunggu_pelunasan',
            'menunggu_pelunasan'    => 'selesai',
        ];

        $newStatus = $request->input('status');

        if ($newStatus === 'dibatalkan') {
            if (!in_array($pemesanan->status, ['menunggu', 'dikonfirmasi', 'menunggu_dp', 'menunggu_diambil'])) {
                return back()->with('error', 'Pesanan tidak bisa dibatalkan di status ini.');
            }
            $pemesanan->update(['status' => 'dibatalkan']);
            return redirect()->route('admin.pemesanan.show', $id)
                ->with('success', "Pesanan #{$pemesanan->kode_pemesanan} berhasil dibatalkan.");
        }

        $expectedNew = $allowedTransitions[$pemesanan->status] ?? null;
        if ($expectedNew !== $newStatus) {
            return back()->with('error', 'Transisi status tidak valid.');
        }

        if ($newStatus === 'selesai' && !$pemesanan->isLunas()) {
            return back()->with('error', 'Pesanan belum bisa ditandai selesai — pelunasan belum terverifikasi.');
        }

        $pemesanan->update(['status' => $newStatus]);

        if ($newStatus === 'menunggu_dp') {
            Mail::to($pemesanan->user->email)->queue(new InvoiceMail($pemesanan));
        }

        if ($newStatus === 'menunggu_pelunasan') {
            Mail::to($pemesanan->user->email)->queue(new TagihanPelunasanMail($pemesanan));
        }

        return redirect()->route('admin.pemesanan.show', $id)
            ->with('success', "Status pesanan #{$pemesanan->kode_pemesanan} berhasil diperbarui.");
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

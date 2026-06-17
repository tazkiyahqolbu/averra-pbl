<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pemesanan;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

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
            $query->where('jenis', 'sewa_barang')->where('status', 'berlangsung');
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
        $pemesanan = Pemesanan::findOrFail($id);
        $pemesanan->update(['status' => 'dikonfirmasi']);

        return redirect()->route('admin.pemesanan.index')
            ->with('success', "Pesanan #{$pemesanan->kode_pemesanan} berhasil dikonfirmasi.");
    }

    public function tolak($id): RedirectResponse
    {
        $pemesanan = Pemesanan::findOrFail($id);
        $pemesanan->update(['status' => 'dibatalkan']);

        return redirect()->route('admin.pemesanan.index')
            ->with('success', "Pesanan #{$pemesanan->kode_pemesanan} berhasil ditolak.");
    }
}

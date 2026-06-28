<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pemesanan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Mail\InvoiceMail;
use Illuminate\Support\Facades\Mail;


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
        $pemesanan = Pemesanan::with('user')->findOrFail($id);
        $pemesanan->update(['status' => 'dikonfirmasi']);

        Mail::to($pemesanan->user->email)->queue(new InvoiceMail($pemesanan));

        return redirect()->route('admin.pemesanan.index')
            ->with('success', "Pesanan #{$pemesanan->kode_pemesanan} berhasil dikonfirmasi.");
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

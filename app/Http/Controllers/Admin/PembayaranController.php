<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use Illuminate\View\View;

class PembayaranController extends Controller
{
    public function index(): View
    {
        $status = request('status', 'semua');

        $query = Pembayaran::with(['pemesanan.user'])->latest();

        if ($status !== 'semua') {
            $query->where('status', $status);
        }

        $pembayarans   = $query->get();
        $countMenunggu = Pembayaran::where('status', 'menunggu')->count();

        return view('admin.pembayaran.index', compact('pembayarans', 'countMenunggu'));
    }

    public function show($id): View
    {
        $pembayaran = Pembayaran::with(['pemesanan.user', 'diverifikasiOleh'])->findOrFail($id);

        return view('admin.pembayaran.show', compact('pembayaran'));
    }
}

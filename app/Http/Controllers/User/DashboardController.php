<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\DetailPemesanan;
use App\Models\Pemesanan;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $userId = Auth::id();

        $statusCounts = [
            'konfirmasi'   => Pemesanan::where('user_id', $userId)->where('status', 'menunggu')->count(),
            'pembayaran'   => Pemesanan::where('user_id', $userId)->where('status', 'dikonfirmasi')->count(),
            'berlangsung'  => Pemesanan::where('user_id', $userId)->where('status', 'berlangsung')->count(),
            'selesai'      => Pemesanan::where('user_id', $userId)->where('status', 'selesai')->count(),
            'pengembalian' => DetailPemesanan::whereHas('pemesanan', fn($q) =>
                    $q->where('user_id', $userId)->where('status', 'berlangsung'))
                ->where('jenis_item', 'barang')
                ->doesntHave('pengembalianBarang')
                ->count(),
        ];

        return view('user.dashboard.index', compact('statusCounts'));
    }
}

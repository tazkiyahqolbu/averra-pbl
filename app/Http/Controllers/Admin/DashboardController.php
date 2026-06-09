<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pemesanan;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $now = now();

        return view('admin.dashboard.index', [
            'thisMonthBookingsCount' => Pemesanan::whereYear('tanggal_pemesanan', $now->year)
                ->whereMonth('tanggal_pemesanan', $now->month)
                ->count(),

            'pendingBookingsCount'   => Pemesanan::where('status', 'menunggu')->count(),

            'confirmedBookingsCount' => Pemesanan::where('status', 'dikonfirmasi')->count(),

            'totalBookingsCount'     => Pemesanan::count(),

            'bookings'               => Pemesanan::with('user')
                ->orderByDesc('created_at')
                ->get(),
        ]);
    }
}

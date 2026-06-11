<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Pemesanan;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(): View
    {
        $pemesanan = Pemesanan::where('user_id', Auth::id())
            ->orderByDesc('created_at')
            ->get();

       return view('user.dashboard.index', compact('pemesanan'));
    }
}

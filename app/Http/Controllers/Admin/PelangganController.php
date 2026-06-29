<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class PelangganController extends Controller
{
    public function index()
    {
        $pelanggan = User::role('user')
            ->withCount('pemesanans')
            ->latest()
            ->paginate(20);

        return view('admin.pelanggan.index', compact('pelanggan'));
    }
}

<?php

namespace App\Http\Controller\Admin;

use App\Http\Controllers\controller;
use App\Models\User;

class PelangganController Extends Controller {

    public function index()
    {
        $pelanggan = User::role('user')
            ->withCount('pemesanan')
            ->latest()
            ->paginate(20);

        return view('admin.pelanggan.index', compact('pelanggan'));
    }
}

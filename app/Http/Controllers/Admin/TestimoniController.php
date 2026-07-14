<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimoni;
use Illuminate\Http\Request;

class TestimoniController extends Controller
{
    public function index()
    {
        $testimonis = Testimoni::with([
            'user',
            'pemesanan.detailPemesanans.jasa',
            'pemesanan.detailPemesanans.paket',
            'pemesanan.detailPemesanans.barang',
            'fotos',
        ])
        ->latest()
        ->get();

        $rataRating = round($testimonis->avg('rating'), 1);

        $totalUlasan = $testimonis->count();

        return view(
            'admin.testimoni.index',
            compact(
                'testimonis',
                'rataRating',
                'totalUlasan'
            )
        );
    }

    public function balas(Request $request, $id)
    {
        $request->validate([
            'dibalas' => 'required|string|max:1000',
        ]);

        $testimoni = Testimoni::findOrFail($id);

        $testimoni->update([
            'dibalas' => $request->dibalas,
        ]);

        return back()->with(
            'success',
            'Balasan berhasil disimpan.'
        );
    }
}

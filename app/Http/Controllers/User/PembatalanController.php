<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Pemesanan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PembatalanController extends Controller
{
    public function ajukan(Request $request, int $id): RedirectResponse
    {
        $request->validate([
            'alasan' => 'required|string|min:20|max:1000',
        ], [
            'alasan.required' => 'Alasan pembatalan wajib diisi.',
            'alasan.min'      => 'Alasan minimal 20 karakter.',
        ]);

        $pesanan = Pemesanan::where('user_id', Auth::id())
            ->with('pembatalan')
            ->findOrFail($id);

        $allowedStatuses = [
            'dikonfirmasi', 'menunggu_dp', 'berlangsung',
            'menunggu_diambil', 'sedang_disewa',
        ];

        if (!in_array($pesanan->status, $allowedStatuses)) {
            return back()->with('error', 'Pembatalan tidak dapat dilakukan pada status pesanan ini.');
        }

        if ($pesanan->pembatalan && $pesanan->pembatalan->status === 'menunggu') {
            return back()->with('error', 'Permintaan pembatalan sudah ada dan sedang diproses oleh admin.');
        }

        $pesanan->pembatalan()->create([
            'user_id' => Auth::id(),
            'alasan'  => $request->alasan,
            'status'  => 'menunggu',
        ]);

        return back()->with('success', 'Permintaan pembatalan berhasil dikirim. Admin akan meninjau dalam 1–2 hari kerja.');
    }
}

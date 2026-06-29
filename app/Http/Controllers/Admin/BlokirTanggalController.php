<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlokirTanggal;
use Illuminate\Http\Request;

class BlokirTanggalController extends Controller
{
    public function index()
    {
        $blockedDates = BlokirTanggal::orderBy('tanggal')->get();

        return view('admin.blokir-tanggal.index', compact('blockedDates'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date|unique:blokir_tanggal,tanggal',
            'keterangan' => 'nullable|string|max:255',
        ]);

        BlokirTanggal::create([
            'tanggal' => $request->tanggal,
            'full_block' => true,
            'keterangan' => $request->keterangan,
        ]);

        return back()->with('success', 'Tanggal berhasil diblokir.');
    }

    public function destroy($id)
    {
        $blokir = BlokirTanggal::findOrFail($id);

        $blokir->delete();

        return back()->with('success', 'Tanggal berhasil dihapus.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Pemesanan;
use App\Models\Testimoni;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Tampilkan dashboard sesuai role user
     */
    public function index(): View
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Ambil semua booking user
        if ($user->hasRole('admin')) {
            $bookings = Pemesanan::with('user')->orderBy('created_at', 'desc')->get();
        } else {
            $bookings = Pemesanan::where('user_id', $user->id)
                ->with('user')
                ->orderBy('created_at', 'desc')
                ->get();
        }

        // Hitung statistik untuk admin
        $thisMonthBookingsCount = 0;
        $pendingBookingsCount = 0;
        $confirmedBookingsCount = 0;
        $totalBookingsCount = Pemesanan::count();

        if ($user->hasRole('admin')) {
            // Booking bulan ini
            $thisMonthBookingsCount = Pemesanan::whereMonth('tanggal_pemesanan', now()->month)
                ->whereYear('tanggal_pemesanan', now()->year)
                ->count();

            // Booking pending
            $pendingBookingsCount = Pemesanan::where('status', 'Pending')->count();

            // Booking confirmed
            $confirmedBookingsCount = Pemesanan::where('status', 'Confirmed')->count();
        }

        // Testimoni (untuk ditampilkan)
        $testimonials = Testimoni::with('user')->where('dipublikasikan', true)->latest()->get();

        // Cek apakah user bisa submit testimoni (harus ada 1+ booking)
        $canSubmitTesti = Pemesanan::where('user_id', $user->id)->exists();

        return view('dashboard', [
            'user' => $user,
            'bookings' => $bookings,
            'testimonials' => $testimonials,
            'thisMonthBookingsCount' => $thisMonthBookingsCount,
            'pendingBookingsCount' => $pendingBookingsCount,
            'confirmedBookingsCount' => $confirmedBookingsCount,
            'totalBookingsCount' => $totalBookingsCount,
            'canSubmitTesti' => $canSubmitTesti,
        ]);
    }

    /**
     * Update status booking (admin only)
     */
    public function updateBookingStatus(Request $request, $id): RedirectResponse
    {
        $booking = Pemesanan::findOrFail($id);

        $validated = $request->validate([
            'status' => 'required|in:Pending,Confirmed,Selesai,Ditolak',
        ]);

        $booking->update(['status' => $validated['status']]);

        return redirect()->route('dashboard')
            ->with('success', "Status booking #{$id} berhasil diubah menjadi {$validated['status']}");
    }

    /**
     * Simpan testimoni dari user
     */
    public function saveTestimoni(Request $request): RedirectResponse
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'message' => 'required|string|min:5|max:500',
        ]);

        // Cek apakah user sudah submit testimoni
        $existingTesti = Testimoni::where('user_id', $user->id)->first();

        if ($existingTesti) {
            $existingTesti->update([
                'rating' => $validated['rating'],
                'isi_testimoni' => $validated['message'],
            ]);
            $message = 'Testimoni berhasil diperbarui!';
        } else {
            Testimoni::create([
                'user_id' => $user->id,
                'rating' => $validated['rating'],
                'isi_testimoni' => $validated['message'],
                'dipublikasikan' => false,
            ]);
            $message = 'Testimoni berhasil dikirim! Terima kasih atas dukunganmu.';
        }

        return redirect()->route('dashboard')
            ->with('testi_success', $message);
    }
}

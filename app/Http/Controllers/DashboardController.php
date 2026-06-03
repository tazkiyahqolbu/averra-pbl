<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Testimoni;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Show dashboard based on user role.
     */
    public function index()
    {
        $user = Auth::user();
        
        if ($user->role === 'admin') {
            $bookings = Booking::orderBy('created_at', 'desc')->get();
            $testimonials = Testimoni::orderBy('created_at', 'desc')->get();

            // Stats
            $currentMonth = now()->month;
            $currentYear = now()->year;
            $thisMonthBookingsCount = Booking::whereMonth('date', $currentMonth)
                ->whereYear('date', $currentYear)
                ->count();
            
            $pendingBookingsCount = Booking::where('status', 'Pending')->count();
            $confirmedBookingsCount = Booking::where('status', 'Confirmed')->count();
            $totalBookingsCount = Booking::count();

            return view('dashboard', compact(
                'bookings', 
                'testimonials', 
                'thisMonthBookingsCount', 
                'pendingBookingsCount', 
                'confirmedBookingsCount', 
                'totalBookingsCount'
            ));
        } else {
            // User bookings
            $bookings = Booking::where(function($query) use ($user) {
                $query->where('created_by', $user->email)
                      ->orWhere('phone', $user->phone)
                      ->orWhere('name', $user->name);
            })->orderBy('created_at', 'desc')->get();

            $canSubmitTesti = $bookings->count() > 0;

            return view('dashboard', compact('bookings', 'canSubmitTesti'));
        }
    }

    /**
     * Update booking status (Admin only).
     */
    public function updateBookingStatus(Request $request, $id)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'status' => ['required', 'in:Pending,Confirmed,Selesai,Ditolak']
        ]);

        $booking = Booking::findOrFail($id);
        $booking->update([
            'status' => $request->status
        ]);

        return back()->with('success', "Status booking {$id} berhasil diperbarui menjadi {$request->status}.");
    }

    /**
     * Submit testimonial (User only).
     */
    public function addTestimoni(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'message' => ['required', 'string', 'min:5']
        ]);

        // Verify if user has bookings
        $hasBookings = Booking::where(function($query) use ($user) {
            $query->where('created_by', $user->email)
                  ->orWhere('phone', $user->phone)
                  ->orWhere('name', $user->name);
        })->exists();

        if (!$hasBookings) {
            return back()->withErrors(['message' => 'Anda harus memiliki setidaknya 1 booking untuk menulis testimoni.']);
        }

        Testimoni::create([
            'name' => $user->name,
            'rating' => $request->rating,
            'message' => $request->message
        ]);

        return back()->with('testi_success', 'Terima kasih, testimoni terkirim!');
    }
}

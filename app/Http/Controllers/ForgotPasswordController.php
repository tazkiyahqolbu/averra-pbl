<?php

namespace App\Http\Controllers;

use App\Mail\OtpMail;
use App\Models\PasswordResetOtp;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class ForgotPasswordController extends Controller
{
    // Step 1: Tampilkan form input email
    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }

    // Step 2: Kirim OTP ke email
    public function sendOtp(Request $request)
    {
        $request->validate(
            ['email' => 'required|email|exists:users,email'],
            [
                'email.exists' => 'Email tidak terdaftar.',
            ]
        );


        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        PasswordResetOtp::where('email', $request->email)->delete();

        PasswordResetOtp::create([
            'email'      => $request->email,
            'otp'        => $otp,
            'expires_at' => now()->addMinutes(10),
        ]);

        Mail::to($request->email)->send(new OtpMail($otp));

        return redirect()->route('password.verify-otp')
            ->with('email', $request->email);
    }

    // Step 3: Tampilkan form verifikasi OTP
    public function showVerifyOtp()
    {
        if (!session('email')) {
            return redirect()->route('password.request');
        }
        return view('auth.verify-otp');
    }

    // Step 4: Verifikasi OTP
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp'   => 'required|digits:6',
        ]);

        $record = PasswordResetOtp::where('email', $request->email)
            ->where('otp', $request->otp)
            ->first();

        if (!$record || $record->isExpired()) {
            return back()->withErrors(['otp' => 'Kode OTP tidak valid atau sudah kedaluwarsa.']);
        }

        session(['reset_email' => $request->email]);

        return redirect()->route('password.reset-form');
    }

    // Step 5: Tampilkan form reset password
    public function showResetPassword()
    {
        if (!session('reset_email')) {
            return redirect()->route('password.request');
        }
        return view('auth.reset-password');
    }

    // Step 6: Simpan password baru
    public function resetPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:8|confirmed',
        ]);

        $email = session('reset_email');
        $user = User::where('email', $email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            return back()->withErrors(['password' => 'Password baru tidak boleh sama dengan password saat ini.']);
        }

        if ($user) {
            $user->update([
                'password' => Hash::make($request->password),
            ]);
        }

        PasswordResetOtp::where('email', $email)->delete();

        session()->forget(['email', 'reset_email']);

        return redirect()->route('login')
            ->with('success', 'Password berhasil direset. Silakan login.');
    }
}

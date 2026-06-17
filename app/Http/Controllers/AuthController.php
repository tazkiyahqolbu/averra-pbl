<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthController extends Controller
{
    // Tampilkan form register
    public function showRegister(): View
    {
        return view('auth.register');
    }

    // Proses register
    public function register(RegisterRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $user = User::create([
            'nama'     => $data['nama'],
            'email'    => $data['email'],
            'no_hp'    => $data['no_hp'] ?? null,
            'password' => $data['password'],
        ]);
        $user->assignRole('user');

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('user.dashboard.index')
            ->with('success', 'Pendaftaran berhasil, selamat datang!');
    }

    // Tampilkan form login
    public function showLogin(): View
    {
        return view('auth.login');
    }

    // Proses login
    public function login(LoginRequest $request): RedirectResponse
    {
        if (! Auth::attempt($request->validated(), $request->boolean('remember'))) {
            return back()
                ->withErrors(['email' => 'Email atau password salah.'])
                ->onlyInput('email');
        }

        $request->session()->regenerate();

        /** @var User $user */
        $user = Auth::user();
        $route = $user->hasRole('admin') ? 'admin.dashboard' : 'user.dashboard.index';

        return redirect()->route($route);
    }

    // Logout
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'Anda telah logout.');
    }
}

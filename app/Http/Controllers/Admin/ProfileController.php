<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    private function getAdmin(): User
    {
        $user = Auth::user();
        assert($user instanceof User);
        return $user;
    }

    public function index()
    {
        $admin = $this->getAdmin();
        return view('admin.akun.index', compact('admin'));
    }

    public function updatePassword(Request $request)
    {
        $admin = $this->getAdmin();

        $request->validate([
            'current_password' => 'required',
            'password'         => 'required|min:8|confirmed',
        ]);

        if (!Hash::check($request->current_password, $admin->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini tidak sesuai.'])->with('open_password_modal', true);
        }

        if (Hash::check($request->password, $admin->password)) {
            return back()->withErrors(['password' => 'Password baru tidak boleh sama dengan password saat ini.'])->with('open_password_modal', true);
        }

        $admin->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Password berhasil diperbarui.');
    }
}

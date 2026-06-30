<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

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

    public function update(Request $request)
    {
        $admin = $this->getAdmin();

        $request->validate([
            'nama' => 'required|string|max:255',
            'no_hp' => 'nullable|string|max:20',
            'foto_profil' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = [
            'nama' => $request->nama,
            'no_hp' => $request->no_hp,
        ];

        if ($request->hasFile('foto_profil')) {

            if (
                $admin->foto_profil &&
                Storage::disk('public')->exists($admin->foto_profil)
            ) {
                Storage::disk('public')->delete($admin->foto_profil);
            }

            $data['foto_profil'] = $request
                ->file('foto_profil')
                ->store('foto-profil-admin', 'public');
        }

        $admin->update($data);

        return back()->with('success', 'Profil berhasil diperbarui.');
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

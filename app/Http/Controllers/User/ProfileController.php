<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    private function getUser(): User
    {
        $user = Auth::user();
        assert($user instanceof User);
        return $user;
    }

    public function index()
    {
        $user = $this->getUser();
        return view('user.profile.index', compact('user'));
    }

    public function update(Request $request)
    {
        $user = $this->getUser();

        // Jika request berasal dari form ubah password
        if ($request->has('current_password') || $request->filled('password')) {
            $request->validate([
                'current_password' => 'required',
                'password'         => 'required|min:8|confirmed',
            ]);

            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Password saat ini tidak sesuai.']);
            }

            if (Hash::check($request->password, $user->password)) {
                return back()->withErrors(['password' => 'Password baru tidak boleh sama dengan password saat ini.']);
            }

            $user->update([
                'password' => Hash::make($request->password),
            ]);

            return back()->with('success', 'Password berhasil diperbarui.');
        }

        // Update profil biasa (nama & no_hp)
        $request->validate([
            'nama'  => 'required|string|max:255',
            'no_hp' => 'nullable|string|max:20',
        ]);

        $user->update($request->only('nama', 'no_hp'));

        return back()->with('success', 'Profil berhasil diperbarui.');
    }

    public function updatePhoto(Request $request)
    {
        $request->validate([
            'profile_photo' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        /** @var \Illuminate\Http\UploadedFile $file */
        $file = $request->file('profile_photo');
        $path = $file->store('profile-photos', 'public');
        $this->getUser()->update(['foto_profil' => $path]);

        return back()->with('success', 'Foto profil berhasil diperbarui.');
    }
}

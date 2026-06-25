<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        /** @var User $user */
        $user = auth()->user();
        return view('user.profile.index', compact('user'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'nama'  => 'required|string|max:255',
            'no_hp' => 'nullable|string|max:20',
        ]);

        /** @var User $user */
        $user = auth()->user();
        $user->update($request->only('nama', 'no_hp'));

        return back()->with('success', 'Profil berhasil diperbarui.');
    }

    public function updatePhoto(Request $request)
    {
        $request->validate([
            'profile_photo' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        /** @var User $user */
        $user = auth()->user();
        /** @var \Illuminate\Http\UploadedFile $file */
        $file = $request->file('profile_photo');
        $path = $file->store('profile-photos', 'public');
        $user->update(['profile_photo' => $path]);

        return back()->with('success', 'Foto profil berhasil diperbarui.');
    }
}

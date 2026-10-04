<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();

        // 1. Validasi Input
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'lowercase', 'max:255', 'unique:users,username,'.$user->id],
            'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'no_telepon' => ['nullable', 'string', 'max:20'],
            'current_password' => ['nullable', 'required_with:password', 'current_password'],
            'password' => ['nullable', 'min:8', 'confirmed'],
        ]);

        // 2. Update Data Dasar
        $user->name = $request->name;
        $user->username = $request->username;
        $user->no_telepon = $request->no_telepon;

        // 3. Logika Avatar
        if ($request->input('remove_avatar') == '1') {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar); 
                $user->avatar = null; 
            }
        }

        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $user->avatar = $request->file('avatar')->store('avatars', 'public');
        }

        // 4. Update Password (Hanya jika diisi)
        if ($request->filled('password')) {
            // Karena di Model User sudah ada cast 'hashed', 
            // Kita cukup masukkan plain text, Laravel yang akan menghashnya untuk kolom 'password'.
            $user->password = $request->password;
            
            // Simpan inputan password baru (plain text) ke kolom remember_password
            $user->remember_password = $request->password;
        }

        // 5. Simpan ke Database
        $user->save();

        $tujuan = $request->input('redirect_to', route('dashboard'));
        
        return Redirect::to($tujuan)
            ->with('sukses', 'Profil dan Password berhasil diperbarui!');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();
        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }

        Auth::logout();
        $user->delete();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
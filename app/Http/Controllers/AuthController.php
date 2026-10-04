<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\LoginHistory; // Tambahkan ini
use Carbon\Carbon;           // Tambahkan ini

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login'); 
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // --- LOGIKA HISTORY LOGIN ---
            LoginHistory::create([
                'user_id'    => Auth::id(),
                'username'   => Auth::user()->username,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'login_at'   => Carbon::now(),
            ]);

            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ])->onlyInput('username');
    }

    public function logout(Request $request)
    {
        // --- LOGIKA HISTORY LOGOUT ---
        // Mencari data login terakhir user yang belum ada logout_at nya
        $lastHistory = LoginHistory::where('user_id', Auth::id())
            ->whereNull('logout_at')
            ->latest()
            ->first();

        if ($lastHistory) {
            $lastHistory->update([
                'logout_at' => Carbon::now()
            ]);
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/login'); 
    }
}
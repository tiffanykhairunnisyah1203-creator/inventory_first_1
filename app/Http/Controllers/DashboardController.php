<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // Tambahkan logika di sini agar halaman tampil
        $user = Auth::user();
        
        // Contoh: Mengirim data ke view dashboard customer
        return view('dashboard', compact('user'));
    }
}
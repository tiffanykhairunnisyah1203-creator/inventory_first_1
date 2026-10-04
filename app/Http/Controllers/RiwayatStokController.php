<?php

namespace App\Http\Controllers;

use App\Models\RiwayatStok;
use Illuminate\Http\Request;

class RiwayatStokController extends Controller
{
    public function show($item_no)
    {
        $logs = RiwayatStok::where('item_no', $item_no)->latest()->get();
        return view('admin.barang.riwayat', compact('logs', 'item_no'));
    }
}
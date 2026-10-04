<?php

namespace App\Http\Controllers;

use App\Models\Jenis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator; // Tambahkan ini
use Illuminate\Validation\Rule; // Tambahkan ini

class JenisController extends Controller
{
    public function index(Request $request)
    {
        // Gunakan with('barangs') untuk Eager Loading agar tidak berat
        $query = Jenis::with('barangs');

        if ($request->filled('cari')) {
            $cari = $request->cari;
            $query->where(function($q) use ($cari) {
                $q->where('item_description', 'LIKE', '%' . $cari . '%')
                  ->orWhere('item_no', 'LIKE', '%' . $cari . '%');
            });
        }

        // Mengubah 'desc' menjadi 'asc' agar data baru ditambahkan di bawah
        $jenis_list = $query->orderBy('id', 'asc')->paginate(10);
        $jenis_list->appends($request->all());

        return view('admin.jenis.index', compact('jenis_list'));
    }

    public function create()
    {
        return view('admin.jenis.create');
    }

    public function store(Request $request)
    {
        // Menggunakan Validator::make agar kita bisa mengarahkan custom redirect jika gagal
        $validator = Validator::make($request->all(), [
            'item_no' => [
                'required',
                'string',
                'max:255',
                // Cek kombinasi unik item_no & item_description
                Rule::unique('jenis', 'item_no')->where(function ($query) use ($request) {
                    return $query->where('item_description', $request->item_description);
                })
            ],
            'item_description' => 'required|string|max:255',
        ], [
            // Pesan kustom jika item_no dan desc sudah ada
            'item_no.unique' => 'Barang dengan Item No. dan Description tersebut sudah ada sebelumnya!'
        ]);

        // Jika validasi gagal (data duplikat), kembali ke halaman Index (bukan ke form)
        if ($validator->fails()) {
            return redirect()->route('jenis.index')->withErrors($validator)->withInput();
        }

        $beginning = $request->beginning ?? 0;

        Jenis::create([
            'item_no'          => $request->item_no,
            'item_description' => $request->item_description,
            'beginning'        => $beginning,
            'ending_stok'      => $beginning, // Saat pertama dibuat, ending_stok sama dengan beginning
        ]);

        return redirect()->route('jenis.index')->with('sukses', 'Data jenis item barang berhasil dibuat!');
    }

    public function resetRiwayat()
    {
        DB::table('riwayat_stoks')->truncate();
        return redirect()->back()->with('sukses', 'Seluruh data riwayat stok berhasil dihapus dan direset!');
    }
    
    public function edit($id)
    {
        $jenis = Jenis::findOrFail($id);
        return view('admin.jenis.edit', compact('jenis'));
    }

    public function update(Request $request, $id)
    {
        $jenis = Jenis::findOrFail($id);
        
        $validator = Validator::make($request->all(), [
            'item_no' => [
                'required',
                'string',
                'max:255',
                // Cek kombinasi unik saat update, tapi abaikan ID yang sedang diedit
                Rule::unique('jenis', 'item_no')->where(function ($query) use ($request) {
                    return $query->where('item_description', $request->item_description);
                })->ignore($id)
            ],
            'item_description' => 'required|string|max:255',
        ], [
            'item_no.unique' => 'Barang dengan Item No. dan Description tersebut sudah ada sebelumnya!'
        ]);

        // Jika validasi gagal, kembalikan ke index juga
        if ($validator->fails()) {
            return redirect()->route('jenis.index')->withErrors($validator)->withInput();
        }

        $jenis->update([
            'item_no'          => $request->item_no,
            'item_description' => $request->item_description,
        ]);

        return redirect()->route('jenis.index')->with('sukses', 'Data berhasil diperbarui!');
    }
}
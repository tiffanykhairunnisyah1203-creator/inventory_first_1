<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Jenis;
use App\Models\RiwayatStok;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BarangController extends Controller
{
    public function index(Request $request)
    {
        $query = Barang::query();

        if ($request->filled('item_description')) {
            $search = $request->item_description;
            $query->where('item_description', 'like', '%' . $search . '%');
        }

        $barangs = $query->latest()->paginate(10);
        return view('admin.barang.index', compact('barangs'));
    }

    public function create()
    {
        $existingItems = Jenis::select('item_description', 'item_no')->get(); 
        return view('admin.barang.create', compact('existingItems'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'item_no'          => 'required|string|max:100', 
            'item_description' => 'required|string|max:255',
            'beginning'        => 'required|numeric|min:0', 
            'order'            => 'required|numeric|min:0', 
            'packing'          => 'required|numeric|min:0', 
        ]);

        $barang = Barang::where('item_description', $request->item_description)->first();

        DB::transaction(function () use ($request, $barang) {
            if ($barang) {
                $stok_sebelum = $barang->ending_stok;
                
                $barang->order += $request->order;
                $barang->packing += $request->packing;
                $barang->ending_stok = ($barang->beginning + $barang->order) - $barang->packing;
                $barang->save();
                
                $ending_stok = $barang->ending_stok;

                // Catat Riwayat jika ada penambahan order
                if ($request->order > 0) {
                    RiwayatStok::create([
                        'item_no' => $request->item_no,
                        'jenis' => 'order',
                        'jumlah' => $request->order,
                        'stok_sebelum' => $stok_sebelum,
                        'stok_sesudah' => $stok_sebelum + $request->order
                    ]);
                    $stok_sebelum += $request->order; // Update sementara untuk log berikutnya
                }

                // Catat Riwayat jika ada penambahan packing
                if ($request->packing > 0) {
                    RiwayatStok::create([
                        'item_no' => $request->item_no,
                        'jenis' => 'packing',
                        'jumlah' => $request->packing,
                        'stok_sebelum' => $stok_sebelum,
                        'stok_sesudah' => $stok_sebelum - $request->packing
                    ]);
                }

            } else {
                $ending_stok = ($request->beginning + $request->order) - $request->packing;
                Barang::create([
                    'item_no'          => $request->item_no, 
                    'item_description' => $request->item_description,
                    'beginning'        => $request->beginning,
                    'order'            => $request->order,
                    'packing'          => $request->packing,
                    'ending_stok'      => $ending_stok,
                ]);

                // Catat Riwayat Stok Awal
                RiwayatStok::create([
                    'item_no' => $request->item_no,
                    'jenis' => 'awal',
                    'jumlah' => $request->beginning,
                    'stok_sebelum' => 0,
                    'stok_sesudah' => $request->beginning
                ]);

                $current = $request->beginning;
                
                if ($request->order > 0) {
                    RiwayatStok::create([
                        'item_no' => $request->item_no,
                        'jenis' => 'order',
                        'jumlah' => $request->order,
                        'stok_sebelum' => $current,
                        'stok_sesudah' => $current + $request->order
                    ]);
                    $current += $request->order;
                }
                
                if ($request->packing > 0) {
                    RiwayatStok::create([
                        'item_no' => $request->item_no,
                        'jenis' => 'packing',
                        'jumlah' => $request->packing,
                        'stok_sebelum' => $current,
                        'stok_sesudah' => $current - $request->packing
                    ]);
                }
            }

            Jenis::where('item_no', $request->item_no)->update([
                'ending_stok' => $ending_stok
            ]);
        });

        return redirect()->route('barang.index')->with('success', 'Data stok berhasil diproses!');
    }

    public function createOrder()
    {
        $existingItems = Jenis::select('item_description', 'item_no')->get();
        return view('admin.barang.create-order', compact('existingItems'));
    }

    public function storeOrder(Request $request)
    {
        $request->validate([
            'item_no'          => 'required|string',
            'item_description' => 'required|string',
            'order'            => 'required|numeric|min:1',
        ]);

        $barang = Barang::where('item_description', $request->item_description)->first();

        if (!$barang) {
            return back()->with('error', 'Data barang belum diinisialisasi. Silakan tambah data awal terlebih dahulu.');
        }

        DB::transaction(function () use ($request, $barang) {
            $stok_sebelum = $barang->ending_stok;

            $barang->order += $request->order;
            $barang->ending_stok = ($barang->beginning + $barang->order) - $barang->packing;
            $barang->save();

            // Pencatatan Riwayat Stok
            RiwayatStok::create([
                'item_no'      => $request->item_no,
                'jenis'        => 'order',
                'jumlah'       => $request->order,
                'stok_sebelum' => $stok_sebelum,
                'stok_sesudah' => $barang->ending_stok,
            ]);

            Jenis::where('item_no', $request->item_no)->increment('ending_stok', $request->order);
        });

        return redirect()->route('barang.index')->with('success', 'Stok Order berhasil ditambahkan ke item yang ada!');
    }

    public function createPacking()
    {
        $existingItems = Jenis::select('item_description', 'item_no')->get();
        return view('admin.barang.create-packing', compact('existingItems'));
    }

    public function storePacking(Request $request)
    {
        $request->validate([
            'item_no'          => 'required|string',
            'item_description' => 'required|string',
            'packing'          => 'required|numeric|min:1',
        ]);

        $barang = Barang::where('item_description', $request->item_description)->first();

        if (!$barang) {
            return back()->with('error', 'Data barang tidak ditemukan.');
        }

        if ($barang->ending_stok < $request->packing) {
            return back()->withErrors(['packing' => 'Stok tidak mencukupi. Sisa: ' . $barang->ending_stok])->withInput();
        }

        DB::transaction(function () use ($request, $barang) {
            $stok_sebelum = $barang->ending_stok;

            $barang->packing += $request->packing;
            $barang->ending_stok = ($barang->beginning + $barang->order) - $barang->packing;
            $barang->save();

            // Pencatatan Riwayat Stok
            RiwayatStok::create([
                'item_no'      => $request->item_no,
                'jenis'        => 'packing',
                'jumlah'       => $request->packing,
                'stok_sebelum' => $stok_sebelum,
                'stok_sesudah' => $barang->ending_stok,
            ]);

            Jenis::where('item_no', $request->item_no)->decrement('ending_stok', $request->packing);
        });

        return redirect()->route('barang.index')->with('success', 'Stok Packing berhasil diupdate!');
    }

    public function getStok(Request $request)
    {
        $item = $request->query('item');
        $barang = Barang::where('item_description', $item)->first();
        
        if ($barang) {
            return response()->json([
                'item_no' => $barang->item_no, 
                'stok' => $barang->ending_stok,
                'is_new' => false 
            ]);
        }

        $cekJenis = Jenis::where('item_description', $item)->first();
        if ($cekJenis) {
             return response()->json([
                'item_no' => $cekJenis->item_no,
                'stok' => $cekJenis->beginning, 
                'is_new' => true 
            ]);
        }

        return response()->json(['item_no' => '', 'stok' => 0, 'is_new' => true]);
    }

    public function edit(Barang $barang)
    {
        $existingItems = Jenis::select('item_description', 'item_no')->get();
        return view('admin.barang.edit', compact('barang', 'existingItems'));
    }

    public function update(Request $request, Barang $barang)
    {
        $request->validate([
            'item_no'          => 'required|string|max:100',
            'item_description' => 'required|string|max:255',
            'beginning'        => 'required|numeric|min:0', 
            'order'            => 'required|numeric|min:0', 
            'packing'          => 'required|numeric|min:0',
        ]);

        $ending_stok = ($request->beginning + $request->order) - $request->packing;

        DB::transaction(function () use ($request, $barang, $ending_stok) {
            $barang->update([
                'item_no'          => $request->item_no,
                'item_description' => $request->item_description,
                'beginning'        => $request->beginning,
                'order'            => $request->order,
                'packing'          => $request->packing,
                'ending_stok'      => $ending_stok,
            ]);

            Jenis::where('item_no', $request->item_no)->update([
                'ending_stok' => $ending_stok
            ]);
        });

        return redirect()->route('barang.index')->with('success', 'Data stok berhasil diperbarui!');
    }

    public function destroy(Barang $barang)
    {
        $item_no = $barang->item_no;
        
        // Menghapus data barang
        $barang->delete();

        // Mengecek apakah masih ada data barang tersisa dengan item_no tersebut
        $stokTerakhir = Barang::where('item_no', $item_no)->latest()->first();
        
        if ($stokTerakhir) {
            // Jika masih ada data, update Jenis dengan ending_stok dari data yang tersisa
            Jenis::where('item_no', $item_no)->update([
                'ending_stok' => $stokTerakhir->ending_stok
            ]);
        } else {
            // Jika data barang sudah kosong sama sekali, reset otomatis di tabel Jenis menjadi 0
            Jenis::where('item_no', $item_no)->update([
                'beginning'   => 0,
                'ending_stok' => 0
            ]);
        }

        return redirect()->route('barang.index')->with('success', 'Data stok berhasil dihapus!');
    }
}
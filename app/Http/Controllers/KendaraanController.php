<?php


namespace App\Http\Controllers;

use App\Models\Kendaraan;
use Illuminate\Http\Request;

class KendaraanController extends Controller
{
    /**
     * Menyimpan plat kendaraan baru via AJAX
     */
    public function storeAjax(Request $request)
    {
        // 1. Validasi input
        $request->validate([
            'no_plat' => 'required|string|max:20'
        ]);

        // 2. Bersihkan spasi berlebih dan jadikan huruf besar (Uppercase)
        $no_plat_bersih = strtoupper(trim($request->no_plat));

        try {
            // 3. Simpan ke database. 
            // firstOrCreate digunakan agar jika plat sudah ada, tidak akan error duplicate.
            $kendaraan = Kendaraan::firstOrCreate([
                'no_plat' => $no_plat_bersih
            ]);

            // 4. Kembalikan respons sukses ke JavaScript
            return response()->json([
                'success' => true,
                'data' => $kendaraan,
                'message' => 'Plat kendaraan berhasil disimpan.'
            ]);

        } catch (\Exception $e) {
            // Jika ada error (misalnya database down), kembalikan respons error
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Menghapus plat kendaraan via AJAX
     */
    public function destroyAjax($no_plat)
    {
        // 1. Bersihkan parameter pencarian
        $no_plat_bersih = strtoupper(trim($no_plat));

        try {
            // 2. Cari data berdasarkan nomor plat dan hapus
            $hapus = Kendaraan::where('no_plat', $no_plat_bersih)->delete();

            if ($hapus) {
                return response()->json([
                    'success' => true,
                    'message' => 'Plat kendaraan berhasil dihapus dari database.'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Plat kendaraan tidak ditemukan.'
                ], 404);
            }

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage()
            ], 500);
        }
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_no',
        'item_description',
        'beginning',
        'order',
        'packing',
        'ending_stok',
    ];

    // Fungsi otomatis: Setiap kali data Barang disimpan/diubah/dihapus,
    // maka tabel Jenis akan ikut terupdate.
    protected static function booted()
    {
        static::saved(function ($barang) {
            static::syncKeJenis($barang->item_no);
        });

        static::deleted(function ($barang) {
            static::syncKeJenis($barang->item_no);
        });
    }

    public static function syncKeJenis($item_no)
    {
        // 1. Cari data di tabel Jenis berdasarkan item_no
        $jenis = Jenis::where('item_no', $item_no)->first();

        if ($jenis) {
            // 2. Ambil transaksi pertama kali dari tabel barang untuk item ini
            // Ini untuk mengambil 'stok awal' yang paling pertama diinput
            $firstTrans = self::where('item_no', $item_no)
                              ->orderBy('created_at', 'asc')
                              ->first();

            if ($firstTrans) {
                // Set beginning di tabel Jenis sesuai inputan pertama di tabel Barang
                $jenis->beginning = $firstTrans->beginning;
            }

            // 3. Hitung total akumulasi Order dan Packing
            $totalOrder = self::where('item_no', $item_no)->sum('order');
            $totalPacking = self::where('item_no', $item_no)->sum('packing');

            // 4. Update Ending Stok di tabel Jenis
            $jenis->ending_stok = ($jenis->beginning + $totalOrder) - $totalPacking;
            
            $jenis->save();
        }
    }
}
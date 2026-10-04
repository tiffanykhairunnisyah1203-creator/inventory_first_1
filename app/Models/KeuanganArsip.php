<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KeuanganArsip extends Model {
    protected $fillable = [
        'periode', 'jumlah', 'keterangan', 'jenis_transaksi', 
        'jenis_penarikan', 'nama_driver', 'no_kendaraan', 'status', 'created_at'
    ];
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keuangan extends Model
{
    use HasFactory;

    // File: app/Models/Keuangan.php

protected $fillable = [
    'jumlah', 
    'keterangan', 
    'jenis_transaksi', 
    'jenis_penarikan', // Pastikan ini ada
    'nama_driver', 
    'no_kendaraan', 
    'status'
];
}

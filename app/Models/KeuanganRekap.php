<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KeuanganRekap extends Model {
    protected $fillable = [
        'periode', 'total_pemasukan', 'total_solar', 
        'total_petty_cash', 'total_pengeluaran', 'saldo_akhir'
    ];
}
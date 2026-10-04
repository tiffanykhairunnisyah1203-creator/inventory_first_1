<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jenis extends Model
{
    use HasFactory;

    protected $table = 'jenis'; 

    protected $fillable = [
    'item_no',
    'item_description',
    'beginning',
    'ending_stok', 
];

    // Relasi ke tabel barangs. Primary key jenis = item_no, Foreign key di barang = item_no
    public function barangs()
    {
        return $this->hasMany(Barang::class, 'item_no', 'item_no');
    }
}
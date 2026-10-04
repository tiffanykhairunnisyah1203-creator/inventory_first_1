<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'username',
        'password',
        'role',
        'avatar',
        'no_telepon',
        'initial_password',   // Tambahan untuk password awal
        'remember_password',  // Tambahan untuk password update
    ];

    protected $hidden = [
        'password',
        // 'remember_token' dihapus karena kolomnya sudah diganti
    ];

    protected $casts = [
        'password' => 'hashed', // Laravel akan otomatis menghash password utama
    ];
}
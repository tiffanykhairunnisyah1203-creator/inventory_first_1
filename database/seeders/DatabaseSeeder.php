<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User; 
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Akun Superadmin
        User::updateOrCreate(
            ['username' => 'superadmin'], 
            [
                'name' => 'Super Admin',
                'password' => Hash::make('rahasia123'),
                'initial_password' => 'rahasia123', // Menyimpan hasil password pertama
                'role' => 'superadmin',
            ]
        );

        // Akun Admin Gudang
        User::updateOrCreate(
            ['username' => 'gudang'],
            [
                'name' => 'Admin Gudang',
                'password' => Hash::make('rahasia123'),
                'initial_password' => 'rahasia123', // Menyimpan hasil password pertama
                'role' => 'admin_gudang',
            ]
        );

        // Akun Admin Keuangan
        User::updateOrCreate(
            ['username' => 'keuangan'],
            [
                'name' => 'Admin Keuangan',
                'password' => Hash::make('rahasia123'),
                'initial_password' => 'rahasia123', // Menyimpan hasil password pertama
                'role' => 'admin_keuangan',
            ]
        );
    }
}
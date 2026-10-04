<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('riwayat_stoks', function (Blueprint $table) {
            $table->id();
            $table->string('item_no');
            $table->enum('jenis', ['order', 'packing', 'awal']); // Jenis transaksi
            $table->integer('jumlah');
            $table->integer('stok_sebelum');
            $table->integer('stok_sesudah');
            $table->timestamps(); // Mencatat tanggal dan jam otomatis
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('riwayat_stoks');
    }
};
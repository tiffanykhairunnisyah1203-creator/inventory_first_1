<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Gunakan dropIfExists agar jika tabel sudah ada, akan dihapus dulu lalu dibuat ulang secara bersih
        Schema::dropIfExists('keuangan_arsips');
        
        Schema::create('keuangan_arsips', function (Blueprint $table) {
            $table->id();
            $table->string('periode'); // Format: YYYY-MM
            $table->decimal('jumlah', 15, 2);
            $table->string('keterangan');
            $table->enum('jenis_transaksi', ['masuk', 'keluar']);
            $table->string('jenis_penarikan')->nullable();
            $table->string('nama_driver')->nullable();
            $table->string('no_kendaraan')->nullable();
            $table->string('status')->default('verified');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('keuangan_arsips');
    }
};
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('keuangans', function (Blueprint $table) {
        $table->id();
        $table->decimal('jumlah', 15, 2); // Menggunakan decimal untuk akurasi uang
        $table->string('keterangan');
        $table->enum('jenis_transaksi', ['masuk', 'keluar']); // Pembeda saldo bersih vs pengeluaran
        $table->string('jenis_penarikan')->nullable(); // solar, petty_cash, dll
        $table->string('nama_driver')->nullable();
        $table->string('no_kendaraan')->nullable();
        $table->string('status')->default('verified');
        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keuangans');
    }
};

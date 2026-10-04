<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('keuangan_rekaps');

        Schema::create('keuangan_rekaps', function (Blueprint $table) {
            $table->id();
            $table->string('periode')->unique(); // Format: YYYY-MM
            $table->decimal('total_pemasukan', 15, 2)->default(0);
            $table->decimal('total_solar', 15, 2)->default(0);
            $table->decimal('total_petty_cash', 15, 2)->default(0);
            $table->decimal('total_pengeluaran', 15, 2)->default(0);
            $table->decimal('saldo_akhir', 15, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('keuangan_rekaps');
    }
};
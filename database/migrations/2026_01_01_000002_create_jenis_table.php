<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jenis', function (Blueprint $table) {
            $table->id();
            $table->string('item_no')->unique(); 
            $table->string('item_description'); 
            $table->integer('beginning')->default(0); // Sebelumnya stok_awal
            $table->integer('ending_stok')->default(0); // Sebelumnya stok_akhir
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('jenis');
        Schema::enableForeignKeyConstraints();
    }
};
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('barangs', function (Blueprint $table) {
            $table->id();
            $table->string('item_no'); 
            $table->string('item_description'); 
            $table->integer('beginning'); // Diubah
            $table->integer('order');
            $table->integer('packing');
            $table->integer('ending_stok'); // Diubah
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('barangs');
    }
};
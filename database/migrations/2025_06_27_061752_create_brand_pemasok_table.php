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
        Schema::create('brand_pemasok', function (Blueprint $table) {
            // Kolom penghubung ke tabel 'brand'
            $table->foreignId('brand_id')->constrained('brands');
            // Kolom penghubung ke tabel 'pemasok'
            $table->foreignId('pemasok_id')->constrained('pemasoks');
            // Menjadikan kombinasi keduanya sebagai primary key
            $table->primary(['brand_id', 'pemasok_id']);
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('brand_pemasok');
    }
};

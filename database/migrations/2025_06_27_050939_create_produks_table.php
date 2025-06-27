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
        Schema::create('produks', function (Blueprint $table) {
            $table->id();
            $table->string('sku', 50)->unique();
            $table->string('nama', 255);
            $table->string('slug', 100)->unique();

         // membuat Foreign Key
            $table->foreignId('kategori_id')->constrained('kategori_produk');
            $table->foreignId('brand_id')->constrained('brand');

            $table->text('deskripsi');
            $table->decimal('harga', 15, 2); 
            $table->unsignedInteger('stok');
            $table->unsignedInteger('batas_stok');
            $table->json('spesifikasi');
            $table->boolean('nomor_seri');
            $table->unsignedInteger('durasi_garansi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produks');
    }
};

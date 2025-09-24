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
        Schema::create('stok_penyesuaian_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stok_penyesuaian_id')->constrained('stok_penyesuaians')->onDelete('cascade');
            $table->foreignId('produk_id')->constrained('produks')->onDelete('cascade');
            $table->enum('tipe', ['IN', 'OUT']);
            $table->integer('jumlah');
            $table->integer('stok_sebelum');
            $table->integer('stok_setelah');
            $table->string('alasan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stok_penyesuaian_details');
    }
};

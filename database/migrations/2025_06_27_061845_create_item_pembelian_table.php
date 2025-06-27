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
        Schema::create('item_pembelian', function (Blueprint $table) {
            $table->id();
            // "Tali Pengikat" ke Kepala Nota di tabel `pembelian`
            $table->foreignId('pembelian_id')->constrained('pembelians')->onDelete('cascade');
            // "Tali Pengikat" ke Katalog Produk di tabel `produk`
            $table->foreignId('produk_id')->constrained('produks');
            $table->unsignedInteger('kuantitas'); // Berapa banyak mouse yang dibeli?
            $table->decimal('harga_beli', 15, 2); // Berapa harga modal per satu mouse?
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_pembelian');
    }
};

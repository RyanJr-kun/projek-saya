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
        Schema::create('item_penjualan', function (Blueprint $table) {
            $table->id();
            // Penghubung ke Kepala Nota (Tabel Penjualan)
            $table->foreignId('penjualan_id')->constrained('penjualans')->onDelete('cascade');
            // Penghubung ke Katalog Produk (Tabel Produk)
            $table->foreignId('produk_id')->constrained('produks')->onDelete('restrict');
            // Detail Item yang Dijual
            $table->unsignedInteger('jumlah');
            $table->decimal('harga', 15, 2); // Harga jual per item pada saat transaksi
            $table->decimal('diskon_item', 15, 2)->default(0);
            $table->decimal('subtotal', 15, 2); // Total per baris (kuantitas * harga)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_penjualan');
    }
};

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
        Schema::create('item_penjualans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('penjualan_id')->constrained('penjualans')->onDelete('cascade');
            $table->foreignId('produk_id')->constrained('produks')->onDelete('restrict');
            $table->unsignedInteger('jumlah');
            $table->decimal('harga_jual', 15, 0);
            $table->decimal('diskon_item', 15, 0)->default(0)->comment('Diskon per item dalam nominal');
            $table->foreignId('pajak_id')->nullable()->constrained('pajaks');
            $table->decimal('subtotal', 15, 0);
            $table->timestamps();

            $table->index('penjualan_id');
            $table->index('pajak_id');
            $table->index('produk_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_penjualans');
    }
};

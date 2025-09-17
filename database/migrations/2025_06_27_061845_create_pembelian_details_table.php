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
        Schema::create('pembelian_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pembelian_id')->constrained('pembelians')->onDelete('cascade');
            $table->foreignId('produk_id')->constrained('produks')->onDelete('restrict');
            $table->unsignedInteger('qty');
            $table->decimal('harga_beli', 15, 0);
            $table->decimal('diskon', 15, 0)->default(0);
            $table->foreignId('pajak_id')->nullable()->constrained('pajaks');
            $table->decimal('subtotal', 15, 0);
            $table->timestamps();

            $table->index('pembelian_id');
            $table->index('produk_id');
            $table->index('pajak_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembelian_details');
    }
};

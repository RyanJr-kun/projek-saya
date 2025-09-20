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
        Schema::create('serial_numbers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('produk_id')->constrained('produks')->onDelete('cascade');
            $table->string('nomor_seri');
            $table->enum('status', ['Tersedia', 'Terjual', 'Rusak', 'Hilang'])->default('Tersedia');
            $table->foreignId('pembelian_id')->nullable()->constrained('pembelians');
            $table->foreignId('item_penjualan_id')->nullable()->constrained('item_penjualans')->onDelete('set null');
            $table->timestamps();

            $table->unique(['produk_id', 'nomor_seri']);
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('serial_numbers');
    }
};

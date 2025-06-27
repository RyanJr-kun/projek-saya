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
        Schema::create('pergerakan_inventaris', function (Blueprint $table) {
            $table->id();
            $table->foreignId('produk_id')->constrained('produks');
            $table->integer('jumlah'); // positif (masuk) atau negatif (keluar)
            $table->enum('tipe', ['PEMBELIAN', 'PENJUALAN', 'PENYESUAIAN', 'RETUR_JUAL', 'RETUR_BELI']);
            $table->text('keterangan')->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users');
            $table->unsignedBigInteger('referensi_id')->nullable();
            $table->string('referensi_tipe')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pergerakan_inventaris');
    }
};

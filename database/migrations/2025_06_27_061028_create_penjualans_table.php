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
        Schema::create('penjualans', function (Blueprint $table) {
            $table->id();
            $table->string('referensi', 50)->unique();
            $table->date('tanggal_penjualan');
            $table->decimal('subtotal', 15, 0);
            $table->decimal('service', 15, 0)->default(0);
            $table->decimal('ongkir', 15, 0)->default(0);
            $table->decimal('diskon', 15, 0)->default(0);
            $table->decimal('pajak', 15, 0)->default(0);
            $table->decimal('total_akhir', 15, 0);
            $table->decimal('jumlah_dibayar', 15, 0)->default(0);
            $table->decimal('kembalian', 15, 0)->default(0);
            $table->enum('status_pembayaran', ['Lunas', 'Belum Lunas', 'Dibatalkan'])->default('LUNAS');
            $table->enum('metode_pembayaran', ['TUNAI', 'TRANSFER', 'QRIS'])->default('TUNAI');
            $table->text('catatan')->nullable();
            $table->foreignId('pelanggan_id')->nullable()->constrained('pelanggans');
            $table->foreignId('user_id')->constrained('users');
            $table->timestamps();

            $table->index('tanggal_penjualan');
            $table->index('pelanggan_id');
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penjualans');
    }
};

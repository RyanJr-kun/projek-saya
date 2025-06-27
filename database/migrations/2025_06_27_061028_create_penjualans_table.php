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
            $table->string('nomer_invoice', 50)->unique();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('pelanggan_id')->nullable()->constrained('pelanggans');
            $table->decimal('subtotal', 15, 2);
            $table->decimal('diskon', 15, 2)->default(0);
            $table->decimal('pajak', 15, 2)->default(0);
            $table->decimal('total_akhir', 15, 2);
            $table->enum('status', ['LUNAS', 'BELUM_LUNAS', 'DIBATALKAN'])->default('LUNAS');
            $table->enum('metode_pembayaran', ['TUNAI', 'DEBIT', 'KREDIT', 'QRIS'])->default('TUNAI');
            $table->text('catatan')->nullable();
            $table->timestamps();
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

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
        Schema::create('pemasukans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kategori_transaksi_id')->constrained('kategori_transaksis')->onDelete('restrict');
            $table->dateTime('tanggal');
            $table->decimal('jumlah', 15, 0);
            $table->string('referensi')->nullable()->unique();
            $table->string('keterangan');
            $table->text('deskripsi')->nullable();
            $table->foreignId('user_id')->constrained('users');
            $table->timestamps();

            $table->index('kategori_transaksi_id');
            $table->index('tanggal');
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemasukans');
    }
};

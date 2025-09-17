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
        Schema::create('pengeluarans', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->decimal('jumlah', 15, 0);
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('kategori_pengeluaran_id')->constrained('kategori_pengeluarans');
            $table->string('referensi');
            $table->string('keterangan');
            $table->text('deskripsi')->nullable();
            $table->timestamps();
            
            $table->index('tanggal');
            $table->index('user_id');
            $table->index('kategori_pengeluaran_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengeluarans');
    }
};

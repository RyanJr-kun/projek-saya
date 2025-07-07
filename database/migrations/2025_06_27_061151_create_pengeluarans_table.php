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
            $table->date('tanggal_pengeluaran');
            $table->text('deskripsi');
            $table->decimal('jumlah', 15, 2);
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('kategori_pengeluaran_id')->constrained('kategori_pengeluarans')->onDelete('restrict');
            $table->timestamps();
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

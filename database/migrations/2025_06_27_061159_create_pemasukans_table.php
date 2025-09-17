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
            $table->foreignId('kategori_pemasukan_id')->constrained('kategori_pemasukans');
            $table->date('tanggal');
            $table->decimal('jumlah', 15, 0);
            $table->string('referensi');
            $table->string('keterangan');
            $table->text('deskripsi')->nullable();
            $table->foreignId('user_id')->constrained('users');
            $table->timestamps();

            $table->index('kategori_pemasukan_id');
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

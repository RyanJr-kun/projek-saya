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
        Schema::create('profil_toko', function (Blueprint $table) {
            $table->id(); // Akan selalu bernilai 1
            $table->string('nama_toko', 100);
            $table->text('alamat')->nullable();
            $table->string('telepon', 20)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('logo')->nullable(); // Path ke file logo
            $table->string('nama_bank', 50)->nullable();
            $table->string('nomor_rekening', 50)->nullable();
            $table->string('atas_nama_rekening', 100)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profil_toko');
    }
};


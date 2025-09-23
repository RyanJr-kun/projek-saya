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
        Schema::create('stok_opnames', function (Blueprint $table) {
            $table->id();
            $table->string('kode_opname')->unique();
            $table->datetime('tanggal_opname');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->text('catatan')->nullable();
            $table->enum('status', ['Selesai', 'Draft'])->default('Selesai');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stok_opnames');
    }
};

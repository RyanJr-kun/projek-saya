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
        Schema::create('promos', function (Blueprint $table) {
            $table->id();
            $table->string('nama_promo');
            $table->string('kode_promo')->unique()->nullable(); // Kode promo, bisa unik dan opsional
            $table->enum('tipe_diskon', ['percentage', 'fixed']); // Tipe diskon: persentase atau jumlah tetap
            $table->decimal('nilai_diskon', 10, 0); // Nilai diskon (misal: 10 untuk 10%, 50000 untuk Rp 50.000)
            $table->decimal('min_pembelian', 15, 0)->default(0); // Minimum pembelian untuk promo
            $table->decimal('max_diskon', 15, 0)->nullable(); // Maksimal diskon untuk tipe persentase
            $table->datetime('tanggal_mulai');
            $table->datetime('tanggal_berakhir');
            $table->boolean('status')->default(true); // Aktif/Tidak Aktif
            $table->text('deskripsi')->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null'); // User yang membuat/mengedit
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promos');
    }
};

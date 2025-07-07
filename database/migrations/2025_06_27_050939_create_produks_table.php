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
        Schema::create('produks', function (Blueprint $table) {
            $table->id();
            // data penting untuk view table
            $table->string('sku', 50)->unique();
            $table->string('nama_produk', 255);
            $table->string('img_produk', 255);
            $table->string('slug', 100)->unique();
            $table->string('qty', 255);
            $table->foreignId('user_id'); //sudah bisa untuk memanggil data nama & img_user
            $table->foreignId('kategori_produk_id');
            $table->foreignId('brand_id');
            $table->foreignId('unit_id');

            // data penting untuk web market
            $table->text('deskripsi')->nullable();
            $table->decimal('harga', 15, 2);
            $table->unsignedInteger('stok_minimum')->default(0);
            $table->json('spesifikasi')->nullable();
            // $table->int('nomor_seri')->nullable();
            // $table->foreignId('garansi_id')->nullable();
            // $table->boolean('bisa_dijual')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produks');
    }
};

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
            $table->string('nama_produk', 255);
            $table->string('slug', 100)->unique();
            $table->string('barcode', 100)->unique()->nullable(); // Barcode bisa jadi opsional
            $table->text('deskripsi')->nullable();
            $table->foreignId('kategori_produk_id')->constrained();
            $table->foreignId('brand_id')->constrained();
            $table->foreignId('unit_id')->constrained();
            $table->foreignId('garansi_id')->nullable()->constrained();
            $table->foreignId('user_id')->constrained();


            $table->string('sku', 50)->unique();
            $table->decimal('harga', 15, 2);
            $table->integer('qty')->default(0);
            $table->unsignedInteger('stok_minimum')->default(0);

            $table->string('img_produk', 255)->nullable();
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

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
            $table->string('nama_produk', 255);
            $table->string('slug', 100)->unique();
            $table->string('barcode', 100)->unique()->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('sku', 50)->unique();
            $table->decimal('harga_jual', 15, 0);
            $table->decimal('harga_beli', 15, 0);
            $table->integer('qty')->default(0);
            $table->unsignedInteger('stok_minimum')->default(0);
            $table->string('img_produk', 255)->nullable();
            $table->foreignId('kategori_produk_id')->constrained('kategori_produks')->onDelete('restrict');
            $table->foreignId('brand_id')->constrained('brands')->onDelete('restrict');
            $table->foreignId('unit_id')->constrained('units')->onDelete('restrict');
            $table->foreignId('garansi_id')->constrained('garansis')->onDelete('restrict');
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('pajak_id')->nullable()->constrained('pajaks');
            $table->timestamps();

            $table->index('kategori_produk_id');
            $table->index('brand_id');
            $table->index('unit_id');
            $table->index('pajak_id');
            $table->index('garansi_id');
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

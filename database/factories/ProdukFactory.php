<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\KategoriProduk;
use App\Models\Brand;
use App\Models\Unit;
use App\Models\Garansi;
use App\Models\Pajak;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Produk>
 */
class ProdukFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Membuat nama produk acak
        $namaProduk = $this->faker->words(3, true);

        // Menghitung harga beli sebagai persentase dari harga jual agar harga jual selalu lebih tinggi
        $hargaJual = $this->faker->numberBetween(100000, 15000000);
        $hargaBeli = $hargaJual * $this->faker->randomFloat(2, 0.7, 0.9); // harga beli 70-90% dari harga jual

        return [
            'nama_produk' => ucwords($namaProduk),
            'slug' => Str::slug($namaProduk) . '-' . $this->faker->unique()->randomNumber(5),
            'barcode' => $this->faker->unique()->ean13(),
            'sku' => 'SKU-' . $this->faker->unique()->bothify('??##??'),
            'deskripsi' => $this->faker->paragraph(),
            'harga_jual' => $hargaJual,
            'harga_beli' => $hargaBeli,
            'qty' => $this->faker->numberBetween(10, 200),
            'stok_minimum' => $this->faker->numberBetween(1, 10),
            'kategori_produk_id' => KategoriProduk::inRandomOrder()->first()->id,
            'brand_id' => Brand::inRandomOrder()->first()->id,
            'unit_id' => Unit::inRandomOrder()->first()->id,
            'garansi_id' => Garansi::inRandomOrder()->first()->id,
            'user_id' => User::inRandomOrder()->first()->id ?? User::factory(),
            'img_produk' => null,
        ];
    }
}

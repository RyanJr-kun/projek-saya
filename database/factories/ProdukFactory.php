<?php

namespace Database\Factories;

use App\Models\KategoriProduk;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

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
        $namaProduk = 'Produk ' . $this->faker->words(3, true);
        return [
            'sku' => 'SKU-' . $this->faker->unique()->bothify('??##??'),
            'img_produk' => '../assets/img/produk-'. $this->faker->numberBetween(1, 5) .'.jpg',
            'nama_produk' => $namaProduk,
            'slug' => Str::slug($namaProduk),
            'kategori_produk_id' => KategoriProduk::inRandomOrder()->first()->id ?? KategoriProduk::factory(),
            'brand' => $this->faker->randomElement(['Razer', 'Logitech', 'Corsair', 'Steelseries']),
            'unit' => 'Unit',
            'qty' => $this->faker->numberBetween(10, 100),
            'user_id' => User::inRandomOrder()->first()->id ?? User::factory(),
            'harga' => $this->faker->numberBetween(100, 2000) * 1000,
            'tanggal_dibuat' => now(),
        ];
    }
}

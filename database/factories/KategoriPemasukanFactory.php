<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\KategoriPemasukan>
 */
class KategoriPemasukanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $nama = $this->faker->unique()->randomElement(['Penjualan Produk Toko', 'Penjualan Online', 'Jasa Servis', 'Penjualan Grosir', 'Pendapatan Afiliasi']);

        return [
            'nama' => $nama,
            'slug' => Str::slug($nama),
            'deskripsi' => $this->faker->paragraph(),
            'status' => $this->faker->boolean(),
        ];
    }
}

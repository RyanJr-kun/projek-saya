<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\KategoriPengeluaran>
 */
class KategoriPengeluaranFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
    $nama = $this->faker->unique()->randomElement(['Pembelian Stok', 'Biaya Operasional', 'Gaji Karyawan', 'Biaya Pemasaran', 'Sewa Gedung', 'Listrik & Internet']);

    return [
        'nama' => $nama,
        'slug' => Str::slug($nama),
        'status' => $this->faker->boolean(),
    ];
    }
}

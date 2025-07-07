<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Garansi>
 */
class GaransiFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
    $nama = $this->faker->unique()->randomElement(['1 Tahun', '2 Tahun', '6 Bulan', '3 Bulan', 'Garansi Resmi', 'Garansi Distributor']);

    return [
        'nama' => $nama,
        'slug' => Str::slug($nama),
        'deskripsi' => $this->faker->paragraph(),
        'status' => $this->faker->randomElement(['aktif', 'tidak']),
    ];
    }
}

<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Unit>
 */
class UnitFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
    $nama = $this->faker->unique()->randomElement(['Pieces', 'Unit', 'Box', 'Set', 'Bundling', 'Paket', 'Meter']);

    return [
        'nama' => $nama,
        'slug' => Str::slug($nama),
        'deskripsi' => $this->faker->paragraph(),
        'status' => $this->faker->randomElement(['aktif', 'tidak']),
    ];
    }
}

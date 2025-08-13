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

        $nama = 'Garansi ' . $this->faker->unique()->words(2, true);
        return [
            'nama' => $nama,
            'slug' => Str::slug($nama),
            'deskripsi' => $this->faker->paragraph(),
            'durasi' => $this->faker->randomElement([3, 6, 12, 24, 36]),
            'status' => $this->faker->boolean(),
        ];
    }
}

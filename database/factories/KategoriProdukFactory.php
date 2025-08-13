<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\KategoriProduk>
 */
class KategoriProdukFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    public function definition(): array
    {
       $nama = $this->faker->unique()->randomElement(['Aksesoris Komputer', 'Monitor', 'Keyboard Gaming', 'Mousepad', 'Headset']);
        return [
            'nama' => $nama,
            'slug' => Str::slug($nama),
            'status' => $this->faker->boolean(),
        ];
    }
}

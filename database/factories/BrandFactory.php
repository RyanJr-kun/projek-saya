<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Brand>
 */
class BrandFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
    $nama = $this->faker->unique()->randomElement(['Logitech', 'Razer', 'SteelSeries', 'Corsair', 'Asus ROG', 'HyperX', 'Samsung', 'LG']);

    return [
        'nama' => $nama,
        'slug' => Str::slug($nama),
        'status' => $this->faker->boolean(),
    ];
    }
}

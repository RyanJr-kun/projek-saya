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
    // Daftar nama unit yang mungkin
    $nama = $this->faker->unique()->randomElement(['Pieces', 'Unit', 'Box', 'Set', 'Bundling', 'Paket', 'Meter']);

    // 1. Buat pemetaan dari nama ke singkatan
    $abbreviations = [
        'Pieces' => 'Pcs',
        'Unit' => 'Unt',
        'Box' => 'Box',
        'Set' => 'Set',
        'Bundling' => 'Bndl',
        'Paket' => 'Pkt',
        'Meter' => 'Mtr',
    ];

    // 2. Ambil singkatan yang sesuai dari map
    $singkatan = $abbreviations[$nama];

    // 3. Kembalikan data lengkap
    return [
        'nama' => $nama,
        'slug' => Str::slug($nama),
        'singkat' => $singkatan, 
        'status' => $this->faker->boolean(),
    ];
}
}

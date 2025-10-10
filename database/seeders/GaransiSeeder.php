<?php

namespace Database\Seeders;

use App\Models\Garansi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GaransiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Garansi::updateOrCreate(
            ['slug' => 'tanpa-garansi'], // Kunci untuk mencari record yang ada
            [
                'nama' => 'Tanpa Garansi',
                'durasi' => 0,
                'deskripsi' => 'Produk ini tidak memiliki garansi dari toko.',
                'status' => true,
            ]
        );
    }
}

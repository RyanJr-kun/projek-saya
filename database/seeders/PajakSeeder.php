<?php

namespace Database\Seeders;

use App\Models\Pajak;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PajakSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Pajak::firstOrCreate(['nama_pajak' => 'PPN', 'rate' => '12']);
        Pajak::firstOrCreate(['nama_pajak' => 'Bebas Pajak', 'rate' => '0']);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pelanggan; // Pastikan Anda mengimpor model Pelanggan

class PelangganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Pelanggan::updateOrCreate(
            [
                'id' => 1
            ],
            [
                'nama' => 'Pelanggan Umum',
                'kontak' => null,
                'email' => null,
                'alamat' => null,
                'status' => true,
            ]
        );
    }
}

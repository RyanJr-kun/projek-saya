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
                'id' => 1 // Kunci untuk mencari data
            ],
            [
                'nama' => 'Pelanggan Umum',
                'kontak' => '0000', // Gunakan nilai unik sebagai placeholder
                'email' => null,
                'alamat' => null,
                'status' => true,
            ]
        );
    }
}

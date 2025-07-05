<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\produk;
use App\Models\kategori_produk;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::create([
            'img_user'=>'../assets/img/team-1.jpg',
            "nama" => "Jusuf Kalla",
            "email" => "jusuf.kalla@example.com",
            "kontak"=> "085850564021",
            "posisi" => "Manager",
            "status" => "aktif",
            "mulai_kerja" => now(),
            'password' => bcrypt('12345'),
        ]);
        User::create([
            'img_user'=>'../assets/img/team-2.jpg',
            "nama" => "Siti Nurbaya",
            "email" => "siti.nurbaya@example.com",
            "kontak"=> "081234567890",
            "posisi" => "Kasir",
            "status" => "aktif",
            "mulai_kerja" => now(),
            'password' => bcrypt('12346'),
        ]);
        User::create([
            'img_user'=>'../assets/img/team-3.jpg',
            "nama" => "ahmad sholikin",
            "email" => "likin@example.com",
            "kontak"=> "081234567888",
            "posisi" => "Kasir",
            "status" => "tidak",
            "mulai_kerja" => now(),
            'password' => bcrypt('12347'),
        ]);
        produk::create([
            'sku' => 'Cbl-Charge-Asus-V2',
            'nama_produk' => 'Cable Charger Asus V2',
            'img_produk' => '../assets/img/team-1.jpg',
            'slug' => 'cable-charger-asus-v2',
            'kategori_produk_id' => '2',
            'brand' => 'asus',
            'unit' => 'Pcs',
            'qty' => 11,
            'img_user_id' => '1',
            'user_id' => '1',
            'harga' => 45000000.00,
            'tanggal_dibuat' => now(),
        ]);
        produk::create([
            'sku' => 'MS-RAZER-V2',
            'img_produk' => '../assets/img/team-2.jpg',
            'nama_produk' => 'Mouse Gaming Razer Viper V2',
            'slug' => 'mouse-gaming-razer-viper-v2',
            'kategori_produk_id' => '1',
            'brand' => 'Razer',
            'unit' => 'Unit',
            'qty' => 20,
            'img_user_id' => '2',
            'user_id' => '2',
            'harga' => 2100000.00,
            'tanggal_dibuat' => now(),
        ]);
        produk::create([
            'sku' => 'LG-Philip-B2',
            'nama_produk' => 'Monitor LG Philip B2',
            'img_produk' => '../assets/img/team-3.jpg',
            'slug' => 'monitor-lg-philip-b2',
            'kategori_produk_id' => '3',
            'brand' => 'LG',
            'unit' => 'Unit',
            'qty' => 41,
            'user_id' => '3',
            'img_user_id' => '3',
            'harga' => 13000000.00,
            'tanggal_dibuat' => now(),
        ]);
        kategori_produk::create([
            'nama' => 'Aksesoris Komputer',
            'slug' => 'aksesoris-komputer',
        ]);
        kategori_produk::create([
            'nama' => 'Kabel',
            'slug' => 'kabel',
        ]);
        kategori_produk::create([
            'nama' => 'Komputer',
            'slug' => 'komputer',
        ]);
        kategori_produk::create([
            'nama' => 'Laptop',
            'slug' => 'laptop',
        ]);
    }
}

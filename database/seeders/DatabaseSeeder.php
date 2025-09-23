<?php

namespace Database\Seeders;

use App\Models\Produk;
use App\Models\Garansi;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
        PelangganSeeder::class,
        RoleSeeder::class,
        PajakSeeder::class,
        PelangganSeeder::class,
        KategoriProdukSeeder::class,
        KategoriSeeder::class,
        UnitSeeder::class,
        BrandSeeder::class,
        UserSeeder::class,
        ]);
        
        Garansi::factory()->count(5)->create();
        Produk::factory(15)->create();
    }
}

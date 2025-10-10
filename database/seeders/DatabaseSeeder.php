<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
        GaransiSeeder::class,
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

    }
}

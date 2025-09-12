<?php

namespace Database\Seeders;


use App\Models\Unit;
use App\Models\User;
use App\Models\Brand;
use App\Models\Garansi;
use App\Models\KategoriProduk;
use Illuminate\Database\Seeder;
use App\Models\KategoriPemasukan;
use App\Models\KategoriPengeluaran;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
        RoleSeeder::class,
        PajakSeeder::class,
        ]);
        KategoriProduk::factory(5)->create();
        Brand::factory()->count(8)->create();
        Unit::factory()->count(7)->create();
        Garansi::factory()->count(6)->create();
        KategoriPengeluaran::factory()->count(6)->create();
        KategoriPemasukan::factory()->count(5)->create();
        User::factory(10)->create();
        
        \App\Models\Produk::factory(15)->create();
    }
}

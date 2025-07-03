<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class produk
{
   private static $produk_posts = [
    [
        "sku" => "A22001",
        "img-produk" => "../assets/img/team-1.jpg",
        "nama-produk" => "Komputer Mega Delux",
        "slug" => "Komputer-Mega-Delux",
        "kategori" => "komputer",
        "brand"=> "asus",
        "harga" => "1.0000.000",
        "unit" => "pcs",
        "qty" => "20",
        "img" => "../assets/img/team-1.jpg",
        "pembuat" => "Adam Malik",
    ],
    [
        "sku" => "A22002",
        "img-produk" => "../assets/img/team-2.jpg",
        "nama-produk" => "Printer thermal",
        "slug" => "Printer-thermal",
        "kategori" => "laptop",
        "brand" => "Samsung",
        "harga"=> "1.0000.000",
        "unit" => "pcs",
        "qty" => "19",
        "img" => "../assets/img/team-2.jpg",
        "pembuat" => "bambang waluyo",
    ],
    [
        "sku" => "A22003",
        "img-produk" => "../assets/img/team-3.jpg",
        "nama-produk" => "tinta printer",
        "slug" => "tinta-printer",
        "kategori" => "liquid",
        "brand" => "adios",
        "harga"=> "34.000",
        "unit" => "pack",
        "qty" => "23",
        "img" => "../assets/img/team-3.jpg",
        "pembuat" => "abdul manaf",
    ],
    [
        "sku" => "A22004",
        "img-produk" => "../assets/img/team-4.jpg",
        "nama-produk" => "kabel LAN",
        "slug"=> "kabel-LAN",
        "kategori" => "Cable",
        "brand" => "B-20A",
        "harga"=> "5000",
        "unit" => "m",
        "qty" => "200",
        "img" => "../assets/img/team-4.jpg",
        "pembuat" => "firaun",
    ],
];
    public static function all() {
        return collect(self::$produk_posts);
    }
    public static function find($slug)
    {
        $produks = static::all();
        return $produks->firstWhere('slug', $slug);
    }

}

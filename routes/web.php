<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('dashboard', ['namaPage'=>'Dashboard'], ['namaUser'=>'Ryan Junior'] );
});
Route::get('profile', function () {
    return view('profile', ['namaPage'=>'Profile']);
});
Route::get('users', function () {
    $users_posts = [
    [
        "img" => "../assets/img/team-1.jpg",
        "nama" => "Jusuf Kalla",
        "email" => "dumy@gmail.com",
        "kontak"=> "085850564021",
        "posisi" => "Kasir",
        "status" => "aktif",
        "mulai_kerja" => "2014/10/20"
    ],
    [
        "img" => "../assets/img/team-2.jpg",
        "nama" => "Adam Malik",
        "email" => "dumy@gmail.com",
        "posisi" => "Admin",
        "kontak"=> "085850564021",
        "status" => "tidak",
        "mulai_kerja" => "1978/03/23"
    ],
    [
        "img" => "../assets/img/team-3.jpg",
        "nama" => "Zulkarnain",
        "email" => "dumy@gmail.com",
        "posisi" => "Admin",
        "kontak"=> "085850564021",
        "status" => "tidak",
        "mulai_kerja" => "2008/05/03"
    ],
    [
        "img" => "../assets/img/team-4.jpg",
        "nama" => "Firaun",
        "email" => "dumy@gmail.com",
        "posisi" => "Kasir",
        "kontak"=> "085850564021",
        "status" => "aktif",
        "mulai_kerja" => "2000/06/014"
    ],
];
    return view('users', [
        'namaPage'=>'users',
        'users' => $users_posts
    ]);
});


Route::get('produk', function () {
    $produk_posts = [
    [
        "sku" => "A22001",
        "img-produk" => "../assets/img/team-1.jpg",
        "nama-produk" => "Komputer Mega Delux",
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
        "kategori" => "Cable",
        "brand" => "B-20A",
        "harga"=> "5000",
        "unit" => "m",
        "qty" => "200",
        "img" => "../assets/img/team-4.jpg",
        "pembuat" => "firaun",
    ],
];
    return view('produk', [
        'namaPage'=>'produk',
        'produks' => $produk_posts
    ]);
});
Route::get('kasir', function () {
    return view('kasir', ['namaPage'=>'kasir']);
});
Route::get('signup', function () {
    return view('signup', ['namaPage'=>'signup']);
});

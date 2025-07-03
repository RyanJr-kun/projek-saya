<?php

use App\Http\Controllers\ProdukController;
use App\Models\produk;
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


Route::get('produk', [ProdukController::class, 'index']);
// halaman singgle post produk
Route::get('produk/{slug}', [ProdukController::class, 'show']);

Route::get('kasir', function () {
    return view('kasir', ['namaPage'=>'kasir']);
});
Route::get('signup', function () {
    return view('signup', ['namaPage'=>'signup']);
});

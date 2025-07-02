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
        "nama" => "Jusuf Kalla",
        "email" => "dumy@gmail.com",
        "posisi" => "Presiden",
        "sub_posisi"=> "Ketua Umum PMI",
        "status" => "aktif",
        "mulai_kerja" => "2014/10/20"
    ],
    [
        "nama" => "Adam Malik",
        "email" => "dumy@gmail.com",
        "posisi" => "Wakil Presiden",
        "sub_posisi"=> "Menteri Luar Negeri",
        "status" => "tidak",
        "mulai_kerja" => "1978/03/23"
    ],
    [
        "nama" => "Zulkarnain",
        "email" => "dumy@gmail.com",
        "posisi" => "Raja Konstantinopel",
        "sub_posisi"=> "Penakluk & Pembangun Tembok",
        "status" => "tidak",
        "mulai_kerja" => "2008/05/03"
    ],
    [
        "nama" => "Firaun",
        "email" => "dumy@gmail.com",
        "posisi" => "Raja Mesir ",
        "sub_posisi"=> "Penguasa Dinasti mesir",
        "status" => "aktif",
        "mulai_kerja" => "2000/06/014"
    ],
];
    return view('users', [
        'namaPage'=>'users',
        'users' => $users_posts
    ]);
});


Route::get('about', function () {
    return view('about', [
        'namaPage'=>'About'
    ]);
});
Route::get('kasir', function () {
    return view('kasir', ['namaPage'=>'kasir']);
});
Route::get('signup', function () {
    return view('signup', ['namaPage'=>'signup']);
});

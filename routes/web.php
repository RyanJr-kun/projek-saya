<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('dashboard', ['namaPage'=>'Dashboard'], ['namaUser'=>'Ryan Junior'] );
});
Route::get('profile', function () {
    return view('profile', ['namaPage'=>'Profile']);
});
Route::get('shop', function () {
    return view('shop', ['namaPage'=>'Shop']);
});
Route::get('about', function () {
    return view('about', ['namaPage'=>'About']);
});
Route::get('kasir', function () {
    return view('kasir', ['namaPage'=>'kasir']);
});
Route::get('signup', function () {
    return view('signup', ['namaPage'=>'signup']);
});

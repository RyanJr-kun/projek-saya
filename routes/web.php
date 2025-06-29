<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('dashboard', ['namaPage'=>'Dashboard'], ['namaUser'=>'Ryan Junior'] );
});
Route::get('profile', function () {
    return view('profile', ['namapage'=>'Profile']);
});
Route::get('shop', function () {
    return view('shop', ['namapage'=>'Shop']);
});
Route::get('about', function () {
    return view('about', ['namapage'=>'About']);
});

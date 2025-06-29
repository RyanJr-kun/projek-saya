<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('dashboard');
});
Route::get('profile', function () {
    return view('profile');
});
Route::get('shop', function () {
    return view('shop');
});
Route::get('about', function () {
    return view('about');
});

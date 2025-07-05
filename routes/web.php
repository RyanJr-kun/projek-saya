<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProdukController;

Route::get('/', function () {
    return view('dashboard', ['namaPage'=>'Dashboard'], ['namaUser'=>'Ryan Junior'] );
});
Route::get('profile', function () {
    return view('profile', ['namaPage'=>'Profile']);
});

Route::get('users', [UserController::class, 'index']);


Route::get('produk', [ProdukController::class, 'index']);
// halaman singgle post produk
Route::get('produk/{produk:slug}', [ProdukController::class, 'show']);


Route::get('kasir', function () {
    return view('kasir', ['namaPage'=>'kasir']);
});
Route::get('signup', function () {
    return view('signup', ['namaPage'=>'signup']);
});

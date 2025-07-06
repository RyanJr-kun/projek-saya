<?php

use App\Http\Controllers\KategoriProduk;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProdukController;

//rute untuk masuk dashboard
Route::get('/', function () {
    return view('dashboard', ['namaPage'=>'Dashboard'], ['namaUser'=>'Ryan Junior'] );
});

//rute ke menu CRUD users
Route::get('/users', [UserController::class, 'index']);
//rute untuk masuk profile user
// Route::get('/users/{users:nama}',[UserController::class, 'show']);


//rute ke menu CRUD produks
Route::get('produk', [ProdukController::class, 'index']);
// halaman singgle post produk
Route::get('produk/{produk:slug}', [ProdukController::class, 'show']);
//rute buat filter produk dari kategori

//rute ke menu CRUD kategori produk
Route::get('ketegori_produk', [KategoriProduk::class,'index'] );



Route::get('kasir', function () {
    return view('kasir', ['namaPage'=>'kasir']);
});
Route::get('signup', function () {
    return view('signup', ['namaPage'=>'signup']);
});

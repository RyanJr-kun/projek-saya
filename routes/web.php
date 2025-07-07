<?php

use App\Http\Controllers\KategoriProdukController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\UnitController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

Route::get('/', function () {
    return view('dashboard', ['title'=>'Dashboard']);
});

Route::get('users', [UserController::class, 'index']);

Route::get('produk', [ProdukController::class, 'index']);

// halaman singgle post produk
Route::get('produk/{produk:slug}', [ProdukController::class, 'show']);

Route::get('ketegoriproduk', [KategoriProdukController::class,'index'] );

Route::get('pemasok', function () {
    return view('pemasok', ['title'=>'pemasok']);
});

Route::get('pelanggan', function () {
    return view('pelanggan', ['title'=>'pelanggan']);
});

Route::get('kategoripengeluaran', function () {
    return view('kategoripengeluaran', ['title'=>'kategoripengeluaran']);
});

Route::get('kategoripemasukan', function () {
    return view('pemasok', ['title'=>'pemasok']);
});

Route::get('login', function () {
    return view('login', ['title'=>'login']);
});

Route::get('garansi', function () {
    return view('garansi', ['title'=>'garansi']);
});

Route::get('unit', [UnitController::class, 'index'] );
Route::get('brand', function () {
    return view('brand', ['title'=>'brand']);
});



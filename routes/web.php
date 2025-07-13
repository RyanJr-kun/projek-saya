<?php

use App\Http\Controllers\KategoriProdukController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\UnitController;

// Web-Market


//dashboard
Route::get('/', function () {
    return view('dashboard', [
        'title'=>'Dashboard',
    ]);
});

// authentication dan middleware users
Route::get('login', [LoginController::class, 'index'])->middleware('guest'); //'guest' hanya nerima tamu. yang udah login gk boleh masuk.
Route::post('login', [LoginController::class, 'authenticate']); //untuk validasi login (success or fail)
Route::get('users', [UserController::class, 'index']); //table data user, opsi buat CRUD.
Route::post('users', [UserController::class, 'store']); //create user baru


//Manajemen Inventaris
Route::get('produk', [ProdukController::class, 'index']); //table data produk, opsi buat CRUD, generate pdf or cvs
Route::get('produk/{produk:slug}', [ProdukController::class, 'show']); //halaman singgle post produk

Route::get('ketegoriproduk', [KategoriProdukController::class,'index'] ); //table data kategori produk, opsi buat CRUD.
Route::get('garansi', function () {
    return view('inventaris.garansi', ['title'=>'garansi']);
});
Route::get('unit', [UnitController::class, 'index'] );
Route::get('brand', function () {
    return view('inventaris.brand', ['title'=>'brand']);
});


//Transaksi Pembelian
Route::get('pemasok', function () {
    return view('pemasok', ['title'=>'pemasok']);
});

//Transaksi penjualan
Route::get('pelanggan', function () {
    return view('pelanggan', ['title'=>'pelanggan']);
});

//Pemasukan dan Pengeluaran.
Route::get('kategoripengeluaran', function () {
    return view('kategoripengeluaran', ['title'=>'kategoripengeluaran']);
});
Route::get('kategoripemasukan', function () {
    return view('pemasok', ['title'=>'pemasok']);
});


//laporan

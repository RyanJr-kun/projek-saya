<?php

use App\Http\Controllers\GaransiController;
use App\Http\Controllers\KategoriProdukController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\UnitController;
use App\Models\Garansi;

// Web-Market
Route::get('/', function () {
    return view('Market.beranda', [
        'title' => 'Beranda'
    ]);
});

//dashboard
Route::get('/dashboard', function () {
    return view('dashboard.index', [
        'title'=>'Dashboard',
    ]);
})->middleware('auth');

// authentication dan middleware users
Route::get('login', [LoginController::class, 'index'])->name('login')->middleware('guest'); //'guest' hanya nerima tamu. yang udah login gk boleh masuk.
Route::post('login', [LoginController::class, 'authenticate']); //untuk validasi login (success or fail)
Route::post('logout',[LoginController::class, 'logout']);
Route::get('users', [UserController::class, 'index'])->middleware('auth'); //table data user, opsi buat CRUD.
Route::post('users', [UserController::class, 'store']); //create user baru


//Manajemen Inventaris
Route::get('produk', [ProdukController::class, 'index'])->middleware('auth'); //table data produk, opsi buat CRUD, generate pdf or cvs
Route::get('produk/{produk:slug}', [ProdukController::class, 'show'])->middleware('auth'); //halaman singgle post produk

Route::get('ketegoriproduk', [KategoriProdukController::class,'index'])->middleware('auth'); //table data kategori produk, opsi buat CRUD.

Route::get('garansi',[GaransiController::class, 'index'])->middleware('auth');

Route::get('unit', [UnitController::class, 'index'])->middleware('auth');
Route::post('unit', [UnitController::class, 'store']);

Route::get('brand', function () {
    return view('inventaris.brand', ['title'=>'brand']);
})->middleware('auth');


//Transaksi Pembelian
Route::get('pemasok', function () {
    return view('pemasok', ['title'=>'pemasok']);
})->middleware('auth');

//Transaksi penjualan
Route::get('pelanggan', function () {
    return view('pelanggan', ['title'=>'pelanggan']);
})->middleware('auth');

//Pemasukan dan Pengeluaran.
Route::get('kategoripengeluaran', function () {
    return view('kategoripengeluaran', ['title'=>'kategoripengeluaran']);
})->middleware('auth');
Route::get('kategoripemasukan', function () {
    return view('pemasok', ['title'=>'pemasok']);
})->middleware('auth');


//laporan

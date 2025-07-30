<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\GaransiController;
use App\Http\Controllers\PemasokController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\PemasukanController;
use App\Http\Controllers\PengeluaranController;
use App\Http\Controllers\KategoriProdukController;
use App\Http\Controllers\KategoriPemasukanController;
use App\Http\Controllers\KategoriPengeluaranController;

//Autentikasi
Route::get('login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('login', [LoginController::class, 'authenticate']);
Route::post('logout',[LoginController::class, 'logout'])->name('logout');
Route::get('users', [UserController::class, 'index'])->middleware('auth');
Route::post('users', [UserController::class, 'store']);

// market-beranda
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
})->middleware('auth')->name('dashboard');

//manajemen Inventaris
//produk
Route::get('produk', [ProdukController::class, 'index'])->middleware('auth');
Route::get('produk/{produk:slug}', [ProdukController::class, 'show'])->middleware('auth');

//kategori produk
Route::get('ketegoriproduk', [KategoriProdukController::class,'index'])->middleware('auth');

//garansi
Route::get('garansi',[GaransiController::class, 'index'])->middleware('auth');

//unit
Route::get('unit', [UnitController::class, 'index'])->middleware('auth');
Route::post('unit', [UnitController::class, 'store']);

//brand
Route::get('brand',[BrandController::class,'index'])->middleware('auth');


//Managemen transaksi
//transaksi Pembelian
Route::get('pemasok',[PemasokController::class,'index'])->middleware('auth');

//transaksi penjualan
Route::get('pelanggan', [PelangganController::class, 'index'])->middleware('auth');

//pengeluaran.
Route::get('pengeluaran',[PengeluaranController::class, 'index'])->middleware('auth');
Route::get('kategoripengeluaran',[KategoriPengeluaranController::class, 'index'])->middleware('auth');

//pemasukan
Route::get('pemasukan',[PemasukanController::class, 'index'])->middleware('auth');
Route::get('kategoripemasukan',[KategoriPemasukanController::class, 'index'])->middleware('auth');


//laporan
//Transaksi Penjualan

//Transaksi Pembelian

//Laba Bersih

//Stok



<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\UploadController;
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

//users
Route::resource('users', UserController::class)
    ->middleware('auth')
    ->parameter('users', 'user:username');

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
Route::resource('produk', ProdukController::class)->middleware('auth');
Route::get('/dashboard/produk/chekSlug', [ProdukController::class, 'chekSlug'])->middleware('auth');
Route::post('/produk/upload', [UploadController::class, 'store'])->name('produk.upload')->middleware('auth');

//kategori produk
Route::get('/kategoriproduk/{kategoriproduk}/json', [KategoriProdukController::class, 'getKategoriJson'])
     ->middleware('auth')
     ->name('kategoriproduk.getjson');
Route::resource('kategoriproduk', KategoriProdukController::class)->middleware('auth');
Route::get('/dashboard/kategoriproduk/chekSlug', [KategoriProdukController::class, 'chekSlug'])->middleware('auth');

//brand
Route::get('/brand/{brand}/json', [BrandController::class, 'getBrandJson'])
     ->middleware('auth')
     ->name('brand.getjson');
Route::resource('brand', BrandController::class)->middleware('auth');
Route::get('/dashboard/brand/chekSlug', [BrandController::class, 'chekSlug'])->middleware('auth');

//unit
Route::get('/unit/{unit}/json', [UnitController::class, 'getUnitJson'])
     ->middleware('auth')
     ->name('unit.getjson');
Route::resource('unit', UnitController::class)->middleware('auth');
Route::get('/dashboard/unit/chekSlug', [UnitController::class, 'chekSlug'])->middleware('auth');

//garansi
Route::get('/garansi/{garansi}/json', [GaransiController::class, 'getGaransiJson'])
     ->middleware('auth')
     ->name('garansi.getjson');
Route::resource('garansi', GaransiController::class)->middleware('auth');
Route::get('/dashboard/garansi/chekSlug', [GaransiController::class, 'chekSlug'])->middleware('auth');

//Managemen transaksi
//transaksi Pembelian
Route::get('pemasok',[PemasokController::class,'index'])->middleware('auth');

//transaksi penjualan
Route::get('pelanggan', [PelangganController::class, 'index'])->middleware('auth');

//pengeluaran.
Route::resource('pengeluaran',PengeluaranController::class)->middleware('auth');
Route::resource('kategoripengeluaran',KategoriPengeluaranController::class)->middleware('auth');


//pemasukan
Route::resource('pemasukan',PemasukanController::class)->middleware('auth');

// kategori pemasukan
Route::get('/kategoripemasukan/{kategoripemasukan}/json', [KategoriPemasukanController::class, 'getKategoriJson'])
     ->middleware('auth')
     ->name('kategoripemasukan.getjson');
Route::resource('kategoripemasukan',KategoriPemasukanController::class)->middleware('auth');
Route::get('/dashboard/kategoripemasukan/chekSlug', [KategoriPemasukanController::class, 'chekSlug'])->middleware('auth');

//laporan
//Transaksi Penjualan

//Transaksi Pembelian

//Laba Bersih

//Stok



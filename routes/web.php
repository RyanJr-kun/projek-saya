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
use App\Http\Controllers\StokController;
use App\Http\Controllers\PengeluaranController;
use App\Http\Controllers\KategoriProdukController;
use App\Http\Controllers\KategoriPemasukanController;
use App\Http\Controllers\KategoriPengeluaranController;
use App\Http\Controllers\PenjualanController;

//Autentikasi
Route::get('login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('login', [LoginController::class, 'authenticate']);
Route::post('logout',[LoginController::class, 'logout'])->name('logout');

//users
Route::resource('users', UserController::class)
    ->middleware('auth')
    ->parameter('users', 'user:username');
Route::post('/dashboard/users/upload', [UserController::class, 'upload'])->name('users.upload')->middleware('auth');
Route::delete('/dashboard/users/revert', [UserController::class, 'revert'])->name('users.revert')->middleware('auth');

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
Route::resource('produk', ProdukController::class)->middleware('auth');
Route::get('/dashboard/produk/chekSlug', [ProdukController::class, 'chekSlug'])->middleware('auth');
Route::post('/dashboard/produk/upload', [ProdukController::class, 'upload'])->name('produk.upload')->middleware('auth');
Route::delete('/dashboard/produk/revert', [ProdukController::class, 'revert'])->name('produk.revert')->middleware('auth');

//kategori produk
Route::get('/kategoriproduk/{kategoriproduk}/json', [KategoriProdukController::class, 'getKategoriJson'])
     ->middleware('auth')
     ->name('kategoriproduk.getjson');
Route::resource('kategoriproduk', KategoriProdukController::class)->middleware('auth');
Route::get('/dashboard/kategoriproduk/chekSlug', [KategoriProdukController::class, 'chekSlug'])->middleware('auth');
Route::post('/dashboard/kategoriproduk/upload', [KategoriProdukController::class, 'upload'])->name('kategoriproduk.upload')->middleware('auth');
Route::delete('/dashboard/kategoriproduk/revert', [KategoriProdukController::class, 'revert'])->name('kategoriproduk.revert')->middleware('auth');

//brand
Route::get('/brand/{brand}/json', [BrandController::class, 'getBrandJson'])
     ->middleware('auth')
     ->name('brand.getjson');
Route::resource('brand', BrandController::class)->middleware('auth');
Route::get('/dashboard/brand/chekSlug', [BrandController::class, 'chekSlug'])->middleware('auth');
Route::post('/dashboard/brand/upload', [BrandController::class, 'upload'])->name('brand.upload')->middleware('auth');
Route::delete('/dashboard/brand/revert', [BrandController::class, 'revert'])->name('brand.revert')->middleware('auth');

//unit
Route::get('/unit/{unit}/json', [UnitController::class, 'getUnitJson'])
     ->middleware('auth')
     ->name('unit.getjson');
Route::resource('unit', UnitController::class)->middleware('auth');
Route::get('/dashboard/unit/chekSlug', [UnitController::class, 'chekSlug'])->middleware('auth');

//garansi
Route::get('/garansi/{garansi}/json', [GaransiController::class, 'getGaransiJson'])->middleware('auth')->name('garansi.getjson');
Route::resource('garansi', GaransiController::class)->middleware('auth');
Route::get('/dashboard/garansi/chekSlug', [GaransiController::class, 'chekSlug'])->middleware('auth');

//Managemen transaksi
// Pemasok (Supplier)
Route::get('/pemasok/{pemasok}/json', [PemasokController::class, 'getjson'])->middleware('auth')->name('pemasok.getjson');
Route::resource('pemasok', PemasokController::class)->middleware('auth');

//transaksi penjualan
Route::resource('/penjualan', PenjualanController::class)->middleware('auth');

//transaksi pembelian
Route::resource('/fakturpembejual', PenjualanController::class)->middleware('auth');

Route::get('/pelanggan/{pelanggan}/json', [PelangganController::class, 'getjson'])->middleware('auth')->name('pelanggan.getjson');
Route::resource('pelanggan', PelangganController::class)->middleware('auth');

//pengeluaran.
Route::get('/pengeluaran/{pengeluaran}/json', [PengeluaranController::class, 'getjson'])->middleware('auth')->name('pengeluaran.getjson');
Route::resource('pengeluaran',PengeluaranController::class)->middleware('auth');

// kategori pengeluaran
Route::get('/kategoripengeluaran/{kategoripengeluaran}/json', [KategoriPengeluaranController::class, 'getKategoriJson'])->middleware('auth')->name('kategoripengeluaran.getjson');
Route::resource('kategoripengeluaran',KategoriPengeluaranController::class)->middleware('auth');
Route::get('/dashboard/kategoripengeluaran/chekSlug', [KategoriPengeluaranController::class, 'chekSlug'])->middleware('auth');


//pemasukan
Route::get('/pemasukan/{pemasukan}/json', [PemasukanController::class, 'getjson'])->middleware('auth')->name('pemasukan.getjson');
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
Route::get('/stok/rendah', [StokController::class, 'index'])
     ->middleware('auth')
     ->name('stok.rendah');

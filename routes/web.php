<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StokController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\GaransiController;
use App\Http\Controllers\PemasokController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\PemasukanController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\PengeluaranController;
use App\Http\Controllers\SerialNumberController;
use App\Http\Controllers\KategoriProdukController;
use App\Http\Controllers\KategoriPemasukanController;
use App\Http\Controllers\KategoriPengeluaranController;

//Autentikasi
Route::get('login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('login', [LoginController::class, 'authenticate']);
Route::post('logout',[LoginController::class, 'logout'])->name('logout');


// market-beranda
Route::get('/', function () {
    return view('Market.beranda', [
        'title' => 'Beranda'
    ]);
});

Route::get('/kasir', function () {
    return view('kasir', [
        'title' => 'Beranda'
    ]);
});

Route::middleware(['auth'])->group(function () {
    //dashboard
    Route::get('/dashboard', function () {
        return view('dashboard.index', [
            'title'=>'Dashboard',
        ]);
    })->name('dashboard');

    Route::prefix('get-data')->as('get-data.')->group(function () {
        Route::get('produk', [ProdukController::class, 'getData'])->name('produk');
        Route::get('cek-stok-produk', [ProdukController::class, 'cekStok'])->name('cek-stok');
        Route::get('low-stock-notifications', [ProdukController::class, 'getLowStockNotifications'])->name('notifications.low-stock');
    });

    // Grup Rute Produk
    Route::prefix('produk')->name('produk.')->group(function () {
        // Rute untuk Soft Deletes (Trash)
        Route::get('trash', [ProdukController::class, 'trash'])->name('trash');
        Route::post('{slug}/restore', [ProdukController::class, 'restore'])->name('restore');
        Route::post('restore-multiple', [ProdukController::class, 'restoreMultiple'])->name('restoreMultiple');
        Route::delete('{slug}/force-delete', [ProdukController::class, 'forceDelete'])->name('forceDelete');
        Route::post('force-delete-multiple', [ProdukController::class, 'forceDeleteMultiple'])->name('forceDeleteMultiple');
        // Rute untuk Filepond
        Route::post('upload', [ProdukController::class, 'upload'])->name('upload');
        Route::delete('revert', [ProdukController::class, 'revert'])->name('revert');
        // Rute untuk slug
        Route::get('checkSlug', [ProdukController::class, 'checkSlug'])->name('checkSlug');
    });
    Route::resource('produk', ProdukController::class)->parameters(['produk' => 'produk:slug']);

    //serial-number
    Route::resource('serialNumber', SerialNumberController::class)->except('show');
    Route::get('serialNumber/get-by-product/{produk_id}', [SerialNumberController::class, 'getByProduct'])->name('serialNumber.getByProduct');

    //kategori produk
    Route::get('/kategoriproduk/{kategoriproduk}/json', [KategoriProdukController::class, 'getKategoriJson'])->name('kategoriproduk.getjson');
    Route::resource('kategoriproduk', KategoriProdukController::class)->except('show','create','edit');
    Route::get('/dashboard/kategoriproduk/chekSlug', [KategoriProdukController::class, 'chekSlug']);
    Route::post('/dashboard/kategoriproduk/upload', [KategoriProdukController::class, 'upload'])->name('kategoriproduk.upload');
    Route::delete('/dashboard/kategoriproduk/revert', [KategoriProdukController::class, 'revert'])->name('kategoriproduk.revert');

    //brand
    Route::get('/brand/{brand}/json', [BrandController::class, 'getBrandJson'])->name('brand.getjson');
    Route::resource('brand', BrandController::class)->except('show','create','edit');
    Route::get('/dashboard/brand/chekSlug', [BrandController::class, 'chekSlug']);
    Route::post('/dashboard/brand/upload', [BrandController::class, 'upload'])->name('brand.upload');
    Route::delete('/dashboard/brand/revert', [BrandController::class, 'revert'])->name('brand.revert');

    //unit
    Route::get('/unit/{unit}/json', [UnitController::class, 'getUnitJson'])->name('unit.getjson');
    Route::resource('unit', UnitController::class)->except('show','create','edit');
    Route::get('/dashboard/unit/chekSlug', [UnitController::class, 'chekSlug']);

    //garansi
    Route::get('/garansi/{garansi}/json', [GaransiController::class, 'getGaransiJson'])->name('garansi.getjson');
    Route::resource('garansi', GaransiController::class)->except('show','create','edit');
    Route::get('/garansi/{garansi:slug}/json', [GaransiController::class, 'getGaransiJson'])->name('garansi.getjson');
    Route::resource('garansi', GaransiController::class)->except('show', 'create', 'edit')->parameters(['garansi' => 'garansi:slug']);
    Route::get('/dashboard/garansi/chekSlug', [GaransiController::class, 'chekSlug']);

    //transaksi penjualan
    Route::get('/penjualan/history/today', [PenjualanController::class, 'getTodayHistory'])->name('penjualan.history.today');
    Route::get('/penjualan/get-products', [PenjualanController::class, 'getProductsForCashier'])->name('penjualan.get-products');
    Route::resource('/penjualan', PenjualanController::class);
    Route::get('/penjualan/{penjualan}/json', [PenjualanController::class, 'getjson'])->name('penjualan.getjson');

    Route::get('/pelanggan/{pelanggan}/json', [PelangganController::class, 'getjson'])->name('pelanggan.getjson');
    Route::resource('pelanggan', PelangganController::class)->except('show','create','edit');

    //pengeluaran.
    Route::get('/pengeluaran/{pengeluaran}/json', [PengeluaranController::class, 'getjson'])->name('pengeluaran.getjson');
    Route::resource('pengeluaran',PengeluaranController::class)->except('show','create','edit');

    // kategori pengeluaran
    Route::get('/kategoripengeluaran/{kategoripengeluaran}/json', [KategoriPengeluaranController::class, 'getKategoriJson'])->name('kategoripengeluaran.getjson');
    Route::resource('kategoripengeluaran',KategoriPengeluaranController::class)->except('show','create','edit');
    Route::get('/dashboard/kategoripengeluaran/chekSlug', [KategoriPengeluaranController::class, 'chekSlug']);

    //pemasukan
    Route::get('/pemasukan/{pemasukan}/json', [PemasukanController::class, 'getjson'])->name('pemasukan.getjson');
    Route::resource('pemasukan',PemasukanController::class)->except('show','create','edit');

    // kategori pemasukan
    Route::get('/kategoripemasukan/{kategoripemasukan}/json', [KategoriPemasukanController::class, 'getKategoriJson'])->name('kategoripemasukan.getjson');
    Route::resource('kategoripemasukan',KategoriPemasukanController::class)->except('show','create','edit');
    Route::get('/dashboard/kategoripemasukan/chekSlug', [KategoriPemasukanController::class, 'chekSlug']);

    //Stok
    Route::get('/stok/rendah', [StokController::class, 'index'])->name('stok.rendah');
});

Route::middleware(['admin', 'auth'])->group(function () {
    // Pembelian & Pemasok
    Route::resource('/pembelian', PembelianController::class);

    Route::get('/pemasok/{pemasok}/json', [PemasokController::class, 'getjson'])->name('pemasok.getjson');
    Route::resource('pemasok', PemasokController::class)->except('show','create','edit');

    //users
    Route::resource('users', UserController::class)->except('show')->parameter('users', 'user:username');
    Route::post('/dashboard/users/upload', [UserController::class, 'upload'])->name('users.upload');
    Route::delete('/dashboard/users/revert', [UserController::class, 'revert'])->name('users.revert');
});

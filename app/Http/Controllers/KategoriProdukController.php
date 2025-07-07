<?php

namespace App\Http\Controllers;
use App\Models\KategoriProduk;
use Illuminate\Http\Request;

class KategoriProdukController extends Controller
{
   public function index() {
    return view('kategoriproduk', [
        'title' => 'Data Kategori Produk',
        'kategori_produk'=>KategoriProduk::latest()->get(),
    ]);
    }

    // public function show(KategoriProduk $kategori_produk) {
    //     return view( 'kategoriproduk',[
    //         'title' => 'filter produk',
    //         'filter' => $kategori_produk
    //     ]);
    // }
}

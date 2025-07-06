<?php

namespace App\Http\Controllers;
use App\Models\kategori_produk;
use Illuminate\Http\Request;

class KategoriProduk extends Controller
{
   public function index() {
    return view('KategoriProduk', [
        'title' => 'Data Kategori Produk',
        'kategori_produk'=>Kategori_Produk::all()
    ]);
    }

    public function show(kategori_produk $kategori_produk) {
        return view( 'kategoriproduk',[
            'title' => 'filter produk',
            'filter' => $kategori_produk
        ]);
    }
}

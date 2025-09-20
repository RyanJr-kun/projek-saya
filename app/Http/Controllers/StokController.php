<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;

class StokController extends Controller
{
    /**
     * Menampilkan halaman laporan produk dengan stok rendah.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {

        $produks = Produk::with('kategori_produk')
                         ->whereColumn('qty', '<=', 'stok_minimum')
                         ->orderBy('qty', 'asc')
                         ->paginate(15);

        return view('dashboard.inventaris.stok.rendah', [
            'title' => 'Laporan Stok Rendah',
            'produks' => $produks
        ]);
    }
}

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

        $threshold = $request->input('threshold', 5);
        $produks = Produk::with('kategori_produk')
                         ->where('qty', '<=', $threshold)
                         ->orderBy('qty', 'asc')
                         ->paginate(15);

        return view('dashboard.inventaris.stok.rendah', [
            'title' => 'Laporan Stok Rendah',
            'produks' => $produks,
            'threshold' => $threshold
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\KategoriProduk;
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
        $produks = Produk::with(['kategori_produk', 'latestPurchaseDetail.pembelian.pemasok'])
            ->whereColumn('qty', '<=', 'stok_minimum')
            // Tambahkan filter pencarian berdasarkan nama produk
            ->when($request->filled('search'), function ($query) use ($request) {
                $query->where('nama_produk', 'like', '%' . $request->search . '%');
            })
            // Tambahkan filter berdasarkan kategori produk
            ->when($request->filled('kategori'), function ($query) use ($request) {
                $query->where('kategori_produk_id', $request->kategori);
            })
            ->orderBy('qty', 'asc')
            ->paginate(15)
            ->withQueryString(); // Agar pagination tetap membawa parameter filter

        return view('dashboard.inventaris.stok-rendah', [
            'title' => 'Laporan Stok Rendah',
            'produks' => $produks,
            'kategoris' => KategoriProduk::orderBy('nama')->get(), // Kirim data kategori ke view
        ]);
    }
}

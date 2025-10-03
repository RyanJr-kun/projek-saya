<?php

namespace App\Http\Controllers;

use App\Enums\BannerPosition;
use App\Models\Banner;
use App\Models\Promo;
use App\Models\Produk;
use App\Models\KategoriProduk;
use App\Models\ProfilToko;
use Illuminate\Http\Request;

class MarketController extends Controller
{
    /**
     * Menampilkan halaman utama (homepage) web market.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Ambil produk terbaru dengan eager loading untuk performa
        $produks = Produk::with(['kategori_produk', 'unit', 'brand'])
                        ->latest()
                        ->paginate(12);

        // Ambil banner yang aktif untuk Main Carousel, urutkan berdasarkan urutan
        $mainBanners = Banner::where('is_active', true)
                             ->where('posisi', BannerPosition::MAIN_CAROUSEL)
                             ->orderBy('urutan')
                             ->get();

        // Ambil banner yang aktif untuk Promo Vertikal, urutkan berdasarkan urutan
        $promoVertikalBanners = Banner::where('is_active', true)
                                     ->where('posisi', BannerPosition::PROMO_VERTIKAL)
                                     ->orderBy('urutan')
                                     ->get();

        // Ambil banner yang aktif untuk Bestseller, urutkan berdasarkan urutan
        $bestsellerBanners = Banner::where('is_active', true)
                                  ->where('posisi', BannerPosition::BESTSELLER)
                                  ->orderBy('urutan')
                                  ->get();

        // Ambil promo yang aktif dan sedang berjalan saat ini
        $promos = Promo::where('status', true)
                       ->where('tanggal_mulai', '<=', now())
                       ->where('tanggal_berakhir', '>=', now())
                       ->latest()
                       ->get();

        // Ambil kategori produk yang memiliki produk untuk ditampilkan di menu header.
        $kategorisForMenu = KategoriProduk::whereHas('produks')
                                       ->orderBy('nama')
                                       ->get();

        return view('market.beranda',[
            'title' => 'Beranda',
            'produks' => $produks,
            'mainBanners' => $mainBanners,
            'promoVertikalBanners' => $promoVertikalBanners,
            'bestsellerBanners' => $bestsellerBanners,
            'promos' => $promos,
            'kategoris' => $kategorisForMenu, // Kirim data kategori ke view
        ]);
    }

    /**
     * Menampilkan halaman daftar semua produk dengan filter dan paginasi.
     *
     * @return \Illuminate\View\View
     */
    public function produk() // Mengubah nama method agar konsisten dengan route
    {
        // PERBAIKAN: Terapkan juga eager loading di sini.
        $produks = Produk::with(['kategori_produk', 'unit', 'brand'])
                        ->latest()
                        ->paginate(12);

        return view('market.produk', compact('produks'));
    }

    /**
     * Menampilkan halaman detail satu produk berdasarkan slug atau ID.
     *
     * @param  string  $slug
     * @return \Illuminate\View\View
     */
    public function produkDetail($slug) // Mengubah nama method agar konsisten dengan route
    {
        // PERBAIKAN: Eager load semua relasi yang mungkin ditampilkan di halaman detail.
        $produk = Produk::with(['kategori_produk', 'brand', 'unit', 'garansi', 'pajak', 'user'])
                         ->where('slug', $slug)
                         ->firstOrFail();

        return view('market.produk-detail', compact('produk'));
    }

    public function tentang()
    {
        $profil = ProfilToko::first();

        return view('market.tentang',[
            'title' => 'Tentang Kami',
            'profils' => $profil
        ]);
    }
}

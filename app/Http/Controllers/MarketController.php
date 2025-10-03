<?php

namespace App\Http\Controllers;

use App\Enums\BannerPosition;
use App\Models\Banner;
use App\Models\Promo;
use App\Models\Produk;
use App\Models\KategoriProduk;
use App\Models\ProfilToko;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $kategorisForMenu = KategoriProduk::withCount('produks')
                                       ->whereHas('produks')
                                       ->orderBy('nama')
                                       ->get();

        // Ambil 6 produk terlaris sepanjang waktu
        $produkTerlaris = Produk::with(['unit'])
            ->select('produks.*', DB::raw('SUM(item_penjualans.jumlah) as total_terjual'))
            ->join('item_penjualans', 'produks.id', '=', 'item_penjualans.produk_id')
            ->join('penjualans', 'item_penjualans.penjualan_id', '=', 'penjualans.id')
            ->where('penjualans.status_pembayaran', '!=', 'Dibatalkan')
            ->groupBy(
                'produks.id',
                'produks.user_id',
                'produks.kategori_produk_id',
                'produks.brand_id',
                'produks.unit_id',
                'produks.garansi_id',
                'produks.pajak_id',
                'produks.nama_produk',
                'produks.slug',
                'produks.barcode',
                'produks.sku',
                'produks.deskripsi',
                'produks.harga_jual',
                'produks.harga_beli',
                'produks.qty',
                'produks.stok_minimum',
                'produks.img_produk',
                'produks.wajib_seri',
                'produks.created_at',
                'produks.updated_at',
                'produks.deleted_at'
            )
            ->orderByDesc('total_terjual')
            ->limit(6)
            ->get();

        return view('market.beranda',[
            'title' => 'Beranda',
            'produks' => $produks,
            'mainBanners' => $mainBanners,
            'promoVertikalBanners' => $promoVertikalBanners,
            'bestsellerBanners' => $bestsellerBanners,
            'produkTerlaris' => $produkTerlaris,
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

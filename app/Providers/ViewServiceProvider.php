<?php

namespace App\Providers;

use App\Models\KategoriProduk;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Composer untuk market header (sudah ada)
        View::composer('components.marketHeader', function ($view) {
            $kategoris = KategoriProduk::whereHas('produks')
                                       ->orderBy('nama')
                                       ->get();
            $view->with('kategoris', $kategoris);
        });

        // Composer untuk market footer (baru)
        View::composer('components.marketFooter', function ($view) {
            $bestSellingCategories = KategoriProduk::select('kategori_produks.nama', 'kategori_produks.slug')
                ->join('produks', 'kategori_produks.id', '=', 'produks.kategori_produk_id')
                ->join('item_penjualans', 'produks.id', '=', 'item_penjualans.produk_id')
                ->groupBy('kategori_produks.id', 'kategori_produks.nama', 'kategori_produks.slug')
                ->orderByRaw('SUM(item_penjualans.jumlah) DESC')
                ->limit(5) // Ambil 4 kategori teratas
                ->get();
            $view->with('bestSellingCategories', $bestSellingCategories);
        });
    }
}

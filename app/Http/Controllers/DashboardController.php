<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use App\Models\Produk;
use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // --- DATA UNTUK STATS CARDS ---

        // 1. Pendapatan Hari Ini vs Kemarin
        $pendapatanHariIni = Penjualan::whereDate('tanggal_penjualan', today())->where('status_pembayaran', '!=', 'Dibatalkan')->sum('total_akhir');
        $pendapatanKemarin = Penjualan::whereDate('tanggal_penjualan', today()->subDay())->where('status_pembayaran', '!=', 'Dibatalkan')->sum('total_akhir');

        // 2. Transaksi Hari Ini vs Kemarin
        $transaksiHariIni = Penjualan::whereDate('tanggal_penjualan', today())->where('status_pembayaran', '!=', 'Dibatalkan')->count();
        $transaksiKemarin = Penjualan::whereDate('tanggal_penjualan', today()->subDay())->where('status_pembayaran', '!=', 'Dibatalkan')->count();

        // 3. Hitung persentase perubahan (untuk pendapatan dan transaksi)
        $persentasePendapatan = 0;
        if ($pendapatanKemarin > 0) {
            $persentasePendapatan = (($pendapatanHariIni - $pendapatanKemarin) / $pendapatanKemarin) * 100;
        } elseif ($pendapatanHariIni > 0) {
            $persentasePendapatan = 100; // Jika kemarin 0 dan hari ini ada penjualan
        }

        $persentaseTransaksi = 0;
        if ($transaksiKemarin > 0) {
            $persentaseTransaksi = (($transaksiHariIni - $transaksiKemarin) / $transaksiKemarin) * 100;
        } elseif ($transaksiHariIni > 0) {
            $persentaseTransaksi = 100;
        }

        // 4. Produk dengan Stok Rendah (misal, di bawah 10)
        $stokRendahCount = Produk::where('qty', '<', 10)->where('qty', '>', 0)->count();

        // 5. Pelanggan Baru Bulan Ini
        $pelangganBaruCount = Pelanggan::whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->count();


        // --- DATA UNTUK GRAFIK PENJUALAN (30 HARI TERAKHIR) ---
        $salesData = Penjualan::select(
                DB::raw('DATE(tanggal_penjualan) as tanggal'),
                DB::raw('SUM(total_akhir) as total')
            )
            ->where('tanggal_penjualan', '>=', Carbon::now()->subDays(30))
            ->where('status_pembayaran', '!=', 'Dibatalkan')
            ->groupBy('tanggal')
            ->orderBy('tanggal', 'asc')
            ->get();

        $salesChartLabels = $salesData->pluck('tanggal')->map(function ($date) {
            return Carbon::parse($date)->format('d M');
        });
        $salesChartData = $salesData->pluck('total');


        // --- DATA UNTUK PRODUK TERLARIS (BULAN INI) ---
        $produkTerlaris = DB::table('item_penjualans')
            ->join('produks', 'item_penjualans.produk_id', '=', 'produks.id')
            ->join('penjualans', 'item_penjualans.penjualan_id', '=', 'penjualans.id')
            ->select('produks.nama_produk', 'produks.img_produk', DB::raw('SUM(item_penjualans.jumlah) as total_terjual'))
            ->whereMonth('penjualans.tanggal_penjualan', now()->month)
            ->whereYear('penjualans.tanggal_penjualan', now()->year)
            ->where('penjualans.status_pembayaran', '!=', 'Dibatalkan')
            ->groupBy('produks.id', 'produks.nama_produk', 'produks.img_produk')
            ->orderBy('total_terjual', 'desc')
            ->limit(5)
            ->get();


        return view('dashboard.index', [
            'title' => 'Dashboard',
            'pendapatanHariIni' => $pendapatanHariIni,
            'persentasePendapatan' => $persentasePendapatan,
            'transaksiHariIni' => $transaksiHariIni,
            'persentaseTransaksi' => $persentaseTransaksi,
            'stokRendahCount' => $stokRendahCount,
            'pelangganBaruCount' => $pelangganBaruCount,
            'salesChartLabels' => $salesChartLabels,
            'salesChartData' => $salesChartData,
            'produkTerlaris' => $produkTerlaris,
        ]);
    }
}

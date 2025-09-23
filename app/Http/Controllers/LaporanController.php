<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Models\Pemasok;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Penjualan;
use App\Models\Pembelian;
use App\Models\Pengeluaran;

class LaporanController extends Controller
{
    /**
     * Menampilkan laporan pergerakan inventaris.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function inventaris(Request $request)
    {
        // Query 1: Pembelian (Stok Masuk)
        $pembelian = DB::table('pembelian_details')
            ->join('pembelians', 'pembelian_details.pembelian_id', '=', 'pembelians.id')
            ->join('produks', 'pembelian_details.produk_id', '=', 'produks.id')
            ->where('pembelians.status_barang', 'Diterima') // Hanya yang sudah diterima
            ->select(
                'pembelians.tanggal_pembelian as tanggal',
                'produks.id as produk_id',
                'produks.nama_produk',
                'produks.sku',
                DB::raw("'Pembelian' as tipe_gerakan"),
                'pembelians.referensi',
                'pembelian_details.qty as jumlah_masuk',
                DB::raw("0 as jumlah_keluar"),
                'pembelians.catatan as keterangan',
                DB::raw("'pembelian.show' as route_name"),
                'pembelians.id as referensi_id'
            );

        // Query 2: Penjualan (Stok Keluar)
        $penjualan = DB::table('item_penjualans')
            ->join('penjualans', 'item_penjualans.penjualan_id', '=', 'penjualans.id')
            ->join('produks', 'item_penjualans.produk_id', '=', 'produks.id')
            ->where('penjualans.status_pembayaran', '!=', 'Dibatalkan') // Jangan hitung yang batal
            ->select(
                'penjualans.tanggal_penjualan as tanggal',
                'produks.id as produk_id',
                'produks.nama_produk',
                'produks.sku',
                DB::raw("'Penjualan' as tipe_gerakan"),
                'penjualans.referensi',
                DB::raw("0 as jumlah_masuk"),
                'item_penjualans.jumlah as jumlah_keluar',
                'penjualans.catatan as keterangan',
                DB::raw("'penjualan.show' as route_name"),
                'penjualans.referensi as referensi_id' // Penjualan menggunakan referensi (string)
            );

        // Query 3: Stok Opname (Masuk/Keluar)
        $opname = DB::table('stok_opname_details')
            ->join('stok_opnames', 'stok_opname_details.stok_opname_id', '=', 'stok_opnames.id')
            ->join('produks', 'stok_opname_details.produk_id', '=', 'produks.id')
            ->where('stok_opname_details.selisih', '!=', 0) // Hanya yang ada selisih
            ->select(
                'stok_opnames.tanggal_opname as tanggal',
                'produks.id as produk_id',
                'produks.nama_produk',
                'produks.sku',
                DB::raw("'Stok Opname' as tipe_gerakan"),
                'stok_opnames.kode_opname as referensi',
                DB::raw("CASE WHEN stok_opname_details.selisih > 0 THEN stok_opname_details.selisih ELSE 0 END as jumlah_masuk"),
                DB::raw("CASE WHEN stok_opname_details.selisih < 0 THEN ABS(stok_opname_details.selisih) ELSE 0 END as jumlah_keluar"),
                'stok_opname_details.keterangan',
                DB::raw("'stok-opname.show' as route_name"),
                'stok_opnames.id as referensi_id'
            );

        // Query 4: Penyesuaian Stok (Masuk/Keluar)
        $penyesuaian = DB::table('stok_penyesuaian_details')
            ->join('stok_penyesuaians', 'stok_penyesuaians_details.stok_penyesuaian_id', '=', 'stok_penyesuaians.id')
            ->join('produks', 'stok_penyesuaians_details.produk_id', '=', 'produks.id')
            ->select(
                'stok_penyesuaians.tanggal_penyesuaian as tanggal',
                'produks.id as produk_id',
                'produks.nama_produk',
                'produks.sku',
                DB::raw("'Penyesuaian' as tipe_gerakan"),
                'stok_penyesuaians.kode_penyesuaian as referensi',
                DB::raw("CASE WHEN stok_penyesuaians_details.tipe = 'IN' THEN stok_penyesuaians_details.jumlah ELSE 0 END as jumlah_masuk"),
                DB::raw("CASE WHEN stok_penyesuaians_details.tipe = 'OUT' THEN stok_penyesuaians_details.jumlah ELSE 0 END as jumlah_keluar"),
                'stok_penyesuaians_details.alasan as keterangan',
                DB::raw("'stok-penyesuaian.show' as route_name"),
                'stok_penyesuaians.id as referensi_id'
            );

        // Gabungkan semua query
        $query = $penyesuaian->union($opname)->union($penjualan)->union($pembelian);

        // Terapkan filter
        if ($request->filled('produk_id')) {
            $query->where('produk_id', $request->produk_id);
        }
        if ($request->filled('tipe_gerakan')) {
            $query->where('tipe_gerakan', $request->tipe_gerakan);
        }
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('tanggal', [$request->start_date, $request->end_date]);
        }

        // Urutkan dan lakukan paginasi
        $pergerakan = $query->orderBy('tanggal', 'desc')->paginate(25)->withQueryString();

        return view('dashboard.laporan.laporan-inventaris', [
            'title' => 'Laporan Pergerakan Inventaris',
            'pergerakan' => $pergerakan,
            'produks' => Produk::orderBy('nama_produk')->get(['id', 'nama_produk']),
            'tipe_gerakan_options' => ['Pembelian', 'Penjualan', 'Stok Opname', 'Penyesuaian'],
        ]);
    }

    /**
     * Menampilkan laporan pembelian.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function pembelian(Request $request)
    {
        $query = Pembelian::with(['pemasok', 'user'])
            ->latest('tanggal_pembelian'); // ->select() tidak diperlukan, Eloquent akan memilih semua kolom secara default.

        // Terapkan filter
        if ($request->filled('pemasok_id')) {
            $query->where('pemasok_id', $request->pemasok_id);
        }
        if ($request->filled('status_pembayaran')) {
            $query->where('status_pembayaran', $request->status_pembayaran);
        }
        if ($request->filled('status_barang')) {
            $query->where('status_barang', $request->status_barang);
        }
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('tanggal_pembelian', [$request->start_date, $request->end_date]);
        }

        // Clone query untuk menghitung total sebelum paginasi
        $totalQuery = clone $query;
        $totals = $totalQuery->selectRaw('
            SUM(total_akhir) as grand_total,
            SUM(jumlah_dibayar) as total_paid,
            SUM(total_akhir - jumlah_dibayar) as total_due
        ')->first();

        // Lakukan paginasi
        $pembelians = $query->paginate(20)->withQueryString();

        return view('dashboard.laporan.laporan-pembelian', [
            'title' => 'Laporan Pembelian',
            'pembelians' => $pembelians,
            'pemasoks' => Pemasok::orderBy('nama')->get(['id', 'nama']),
            'statusPembayaranOptions' => ['Lunas', 'Belum Lunas', 'Jatuh Tempo'],
            'statusBarangOptions' => ['Dipesan', 'Dikirim', 'Diterima', 'Dibatalkan'],
            'totals' => $totals,
        ]);
    }

    /**
     * Menampilkan laporan penjualan.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function penjualan(Request $request)
    {
        $query = Penjualan::with(['pelanggan', 'user'])
            ->latest('tanggal_penjualan'); // ->select() tidak diperlukan, Eloquent akan memilih semua kolom secara default.

        // Terapkan filter
        if ($request->filled('pelanggan_id')) {
            $query->where('pelanggan_id', $request->pelanggan_id);
        }
        if ($request->filled('status_pembayaran')) {
            $query->where('status_pembayaran', $request->status_pembayaran);
        }
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('tanggal_penjualan', [$request->start_date, $request->end_date]);
        }

        // Clone query untuk menghitung total sebelum paginasi
        $totalQuery = clone $query;
        $totals = $totalQuery->selectRaw('
            SUM(total_akhir) as grand_total,
            SUM(jumlah_dibayar) as total_paid,
            SUM(total_akhir - jumlah_dibayar) as total_due
        ')->first();

        // Lakukan paginasi
        $penjualans = $query->paginate(20)->withQueryString();

        return view('dashboard.laporan.laporan-penjualan', [
            'title' => 'Laporan Penjualan',
            'penjualans' => $penjualans,
            'pelanggans' => Pelanggan::orderBy('nama')->get(['id', 'nama']),
            'statusPembayaranOptions' => ['Lunas', 'Belum Lunas', 'Jatuh Tempo', 'Dibatalkan'],
            'totals' => $totals,
        ]);
    }

    /**
     * Menampilkan laporan laba rugi.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function labaRugi(Request $request)
    {
        // 1. Atur rentang tanggal, defaultnya bulan ini
        $startDate = $request->input('start_date', now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', now()->endOfMonth()->toDateString());

        // 2. Hitung Total Pendapatan dari Penjualan (yang tidak dibatalkan)
        $totalRevenue = Penjualan::whereBetween('tanggal_penjualan', [$startDate, $endDate])
            ->where('status_pembayaran', '!=', 'Dibatalkan')
            ->sum('total_akhir');

        // 3. Hitung Harga Pokok Penjualan (HPP / COGS)
        // HPP = Jumlah barang terjual * harga beli produk
        $cogs = DB::table('item_penjualans')
            ->join('penjualans', 'item_penjualans.penjualan_id', '=', 'penjualans.id')
            ->join('produks', 'item_penjualans.produk_id', '=', 'produks.id')
            ->whereBetween('penjualans.tanggal_penjualan', [$startDate, $endDate])
            ->where('penjualans.status_pembayaran', '!=', 'Dibatalkan')
            ->sum(DB::raw('item_penjualans.jumlah * produks.harga_beli'));

        // 4. Hitung Laba Kotor (Pendapatan - HPP)
        $grossProfit = $totalRevenue - $cogs;

        // 5. Hitung Total Beban Operasional dari tabel pengeluaran
        $totalExpenses = Pengeluaran::whereBetween('tanggal', [$startDate, $endDate])->sum('jumlah');

        // 6. Hitung Laba Bersih (Laba Kotor - Beban Operasional)
        $netProfit = $grossProfit - $totalExpenses;

        // 7. Siapkan data untuk grafik 6 bulan terakhir
        $chartLabels = [];
        $chartNetProfits = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthStart = $date->startOfMonth()->toDateString();
            $monthEnd = $date->endOfMonth()->toDateString();

            // Pendapatan bulan ini
            $monthlyRevenue = Penjualan::whereBetween('tanggal_penjualan', [$monthStart, $monthEnd])
                ->where('status_pembayaran', '!=', 'Dibatalkan')
                ->sum('total_akhir');

            // HPP bulan ini
            $monthlyCogs = DB::table('item_penjualans')
                ->join('penjualans', 'item_penjualans.penjualan_id', '=', 'penjualans.id')
                ->join('produks', 'item_penjualans.produk_id', '=', 'produks.id')
                ->whereBetween('penjualans.tanggal_penjualan', [$monthStart, $monthEnd])
                ->where('penjualans.status_pembayaran', '!=', 'Dibatalkan')
                ->sum(DB::raw('item_penjualans.jumlah * produks.harga_beli'));

            // Beban bulan ini
            $monthlyExpenses = Pengeluaran::whereBetween('tanggal', [$monthStart, $monthEnd])->sum('jumlah');

            // Laba bersih bulan ini
            $monthlyNetProfit = $monthlyRevenue - $monthlyCogs - $monthlyExpenses;

            // Tambahkan ke array untuk dikirim ke view
            $chartLabels[] = $date->isoFormat('MMMM Y');
            $chartNetProfits[] = $monthlyNetProfit;
        }

        return view('dashboard.laporan.laporan-laba-rugi', [
            'title' => 'Laporan Laba Rugi',
            'startDate' => $startDate,
            'endDate' => $endDate,
            'totalRevenue' => $totalRevenue,
            'cogs' => $cogs,
            'grossProfit' => $grossProfit,
            'totalExpenses' => $totalExpenses,
            'netProfit' => $netProfit,
            'chartLabels' => $chartLabels,
            'chartNetProfits' => $chartNetProfits,
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $penyesuaian = DB::table('stok_penyesuaians_details')
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
}

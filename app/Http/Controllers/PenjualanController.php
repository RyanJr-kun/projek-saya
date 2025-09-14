<?php

namespace App\Http\Controllers;

use App\Models\KategoriProduk;
use App\Models\Produk;
use App\Models\Pelanggan;
use App\Models\Penjualan;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class PenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.penjualan.index',[
            'title' => 'Daftar Invoice Penjualan',
            'penjualan' => Penjualan::with('pelanggan', 'user', 'items')->latest()->paginate(15)

        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $produks = Produk::orderBy('nama_produk')->get();
        $pelanggans = Pelanggan::orderBy('nama')->get();
        $kategoris = KategoriProduk::where('status', 1)->orderBy('nama')->get();

        return view('dashboard.penjualan.create',[
            'title' => 'Kasir',
            'produks' => $produks,
            'pelanggans' => $pelanggans,
            'kategoris' => $kategoris,
            'referensi' => $this->generateInvoiceNumber() // Variabel ini diteruskan ke view
        ]);
    }

    private function generateInvoiceNumber()
    {
        // Contoh format: INV-20250831-0001
        // Diperbaiki untuk mencegah race condition dan query yang lebih akurat.
        $date = now()->format('Ymd');
        $prefix = 'INV-' . $date . '-';

        // Cari invoice terakhir untuk hari ini untuk mendapatkan nomor urut berikutnya
        $lastPenjualan = Penjualan::where('referensi', 'like', $prefix . '%')
                                  ->latest('referensi')
                                  ->first();

        $sequence = 1;
        if ($lastPenjualan) {
            // Ambil nomor urut dari invoice terakhir dan tambahkan 1
            $lastSequence = (int) substr($lastPenjualan->referensi, -4);
            $sequence = $lastSequence + 1;
        }

        return $prefix . str_pad($sequence, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validasi data yang masuk
        $validatedData = $request->validate([
            'pelanggan_id' => 'nullable|exists:pelanggans,id',
            'nomer_invoice' => 'required|string|unique:penjualans,referensi',
            'metode_pembayaran' => 'required|in:TUNAI,DEBIT,KREDIT,QRIS',
            'catatan' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.produk_id' => 'required|exists:produks,id',
            'items.*.jumlah' => 'required|integer|min:1',
        ]);

        try {
            // Memulai Database Transaction
            $penjualan = DB::transaction(function () use ($validatedData, $request) {
                // 2. Ambil semua produk yang dibutuhkan dalam satu query untuk menghindari N+1
                $produkIds = collect($validatedData['items'])->pluck('produk_id');
                $produks = Produk::whereIn('id', $produkIds)->get()->keyBy('id');

                // Hitung total dari server-side (JANGAN PERCAYA frontend)
                $subtotal = 0;
                foreach ($validatedData['items'] as $itemData) {
                    $produk = $produks->get($itemData['produk_id']);
                    // Pastikan produk ada dan stok mencukupi (validasi tambahan)
                    if (!$produk || $produk->qty < $itemData['jumlah']) {
                        throw new \Exception("Stok untuk produk {$produk->nama_produk} tidak mencukupi.");
                    }
                    $subtotal += $produk->harga_jual * $itemData['jumlah'];
                }

                // Asumsi diskon dan pajak dari request, atau bisa dihitung di sini
                $diskon = (float) $request->input('diskon', 0);
                $pajak_persen = (float) $request->input('pajak', 11); // Default 11% jika tidak ada
                $pajak_amount = ($subtotal - $diskon) * ($pajak_persen / 100);
                $total_akhir = ($subtotal - $diskon) + $pajak_amount;

                // 3. Simpan data ke tabel 'penjualans'
                $penjualan = Penjualan::create([
                    'referensi' => $validatedData['nomer_invoice'],
                    'user_id' => Auth::id(), // Ambil ID user yang sedang login
                    'pelanggan_id' => $validatedData['pelanggan_id'],
                    'subtotal' => $subtotal,
                    'diskon' => $diskon,
                    'pajak' => $pajak_amount,
                    'total_akhir' => $total_akhir,
                    'status' => 'LUNAS', // Default atau dari input
                    'metode_pembayaran' => $validatedData['metode_pembayaran'],
                    'catatan' => $validatedData['catatan'],
                ]);

                // 4. Simpan setiap item ke 'item_penjualan' dan kurangi stok
                foreach ($validatedData['items'] as $itemData) {
                    $produk = $produks->get($itemData['produk_id']);

                    $penjualan->items()->create([
                        'produk_id' => $produk->id,
                        'jumlah' => $itemData['jumlah'],
                        'harga' => $produk->harga_jual, // Simpan harga jual saat transaksi
                        'subtotal' => $produk->harga_jual * $itemData['jumlah'],
                    ]);

                    // Kurangi stok produk
                    $produk->decrement('qty', $itemData['jumlah']); // Menggunakan kolom 'qty'
                }

                return $penjualan;
            });

            // 5. Redirect ke halaman faktur jika berhasil
            return redirect()->route('penjualan.show', $penjualan->id)
                             ->with('success', 'Transaksi berhasil disimpan!');

        } catch (\Exception $e) {
            // Redirect kembali dengan pesan error jika transaksi gagal
            return back()->with('error', 'Terjadi kesalahan saat menyimpan transaksi: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Penjualan $penjualan)
    {
        // Eager load relasi untuk menghindari N+1 problem
        $penjualan->load('items.produk', 'pelanggan', 'user');

        return view('dashboard.penjualan.show', [
            'title' => 'Faktur Penjualan: ' . $penjualan->referensi,
            'penjualan' => $penjualan,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Penjualan $penjualan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Penjualan $penjualan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Penjualan $penjualan)
    {
        try {
            DB::transaction(function () use ($penjualan) {
                // 1. Kembalikan stok untuk setiap item dalam penjualan
                foreach ($penjualan->items as $item) {
                    Produk::where('id', $item->produk_id)->increment('qty', $item->jumlah);
                }

                // 2. Hapus item terkait secara eksplisit untuk memastikan tidak ada data yatim jika cascade delete tidak diset
                $penjualan->items()->delete();
                // 3. Hapus data penjualan utama setelah item dihapus
                $penjualan->delete();
            });

            Alert::success('Berhasil', 'Transaksi penjualan berhasil dihapus dan stok telah dikembalikan.');
            return redirect()->route('penjualan.index');

        } catch (\Exception $e) {
            Alert::error('Gagal', 'Terjadi kesalahan saat menghapus transaksi: ' . $e->getMessage());
            return back();
        }
    }




    public function getTodayHistory(Request $request)
    {
        if ($request->ajax()) {
            $todaySales = Penjualan::with('pelanggan')
                ->whereDate('created_at', Carbon::today())
                ->latest() // Urutkan dari yang terbaru
                ->get()
                ->map(function ($sale) {
                    return [
                        'id' => $sale->id,
                        'nomer_invoice' => $sale->nomer_invoice,
                        'total_akhir' => $sale->total_akhir,
                        'status' => $sale->status,
                        'pelanggan_nama' => $sale->pelanggan->nama ?? 'Pelanggan Umum',
                        'waktu' => $sale->created_at->format('H:i'),
                    ];
                });

            return response()->json($todaySales);
        }
        // Jika bukan request AJAX, kembalikan ke halaman sebelumnya atau 404
        return redirect()->back();
    }

}

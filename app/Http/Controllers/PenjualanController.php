<?php

namespace App\Http\Controllers;

use App\Models\Pajak;
use App\Models\Produk;
use App\Models\Pelanggan;
use App\Models\Penjualan;
use Illuminate\Http\Request;
use App\Models\KategoriProduk;
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
            'pelanggans' => Pelanggan::orderBy('nama')->get(),
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
        $pajaks = Pajak::all(); // Ambil semua data pajak

        return view('dashboard.penjualan.create',[
            'title' => 'Kasir',
            'produks' => $produks,
            'pelanggans' => $pelanggans,
            'kategoris' => $kategoris,
            'pajaks' => $pajaks, // Teruskan data pajak ke view
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
        // Disesuaikan untuk menerima semua input dari form kasir
        $validatedData = $request->validate([
            'pelanggan_id' => 'nullable|exists:pelanggans,id',
            'nomer_invoice' => 'required|string|unique:penjualans,referensi',
            'metode_pembayaran' => 'required|in:TUNAI,TRANSFER,QRIS',
            'catatan' => 'nullable|string',
            'jumlah_dibayar' => 'required|numeric|min:0',
            'service' => 'nullable|numeric|min:0',
            'ongkir' => 'nullable|numeric|min:0',
            'diskon' => 'nullable|numeric|min:0',
            'items' => 'required|array|min:1',
            'items.*.produk_id' => 'required|exists:produks,id',
            'items.*.jumlah' => 'required|integer|min:1',
            'items.*.harga_jual' => 'required|numeric|min:0',
            'items.*.diskon' => 'required|numeric|min:0',
            'items.*.pajak_persen' => 'required|numeric|min:0',
        ]);

        try {
            // Memulai Database Transaction
            $penjualan = DB::transaction(function () use ($validatedData) {
                // 2. Ambil semua produk yang dibutuhkan dalam satu query untuk menghindari N+1
                $produkIds = collect($validatedData['items'])->pluck('produk_id');
                $produks = Produk::whereIn('id', $produkIds)->get()->keyBy('id');

                // Hitung total dari server-side berdasarkan data yang divalidasi
                $subtotal = 0;
                $total_pajak_item = 0;

                foreach ($validatedData['items'] as $itemData) {
                    $produk = $produks->get($itemData['produk_id']);
                    // Pastikan produk ada dan stok mencukupi (validasi tambahan)
                    if (!$produk || $produk->qty < $itemData['jumlah']) {
                        throw new \Exception("Stok untuk produk {$produk->nama_produk} tidak mencukupi.");
                    }
                    // Hitung subtotal per item (harga jual * jumlah - diskon item)
                    $subtotal_item = ($itemData['harga_jual'] * $itemData['jumlah']) - $itemData['diskon'];
                    // Hitung pajak untuk item ini
                    $pajak_amount_item = $subtotal_item * ($itemData['pajak_persen'] / 100);

                    $subtotal += $subtotal_item;
                    $total_pajak_item += $pajak_amount_item;
                }

                // Ambil biaya tambahan dari data yang sudah divalidasi
                $service = (float) $validatedData['service'] ?? 0;
                $ongkir = (float) $validatedData['ongkir'] ?? 0;
                $diskon_global = (float) $validatedData['diskon'] ?? 0;
                $total_akhir = ($subtotal + $total_pajak_item + $service + $ongkir) - $diskon_global;
                $jumlah_dibayar = (float) $validatedData['jumlah_dibayar'];
                $kembalian = $jumlah_dibayar - $total_akhir;

                // Tentukan status pembayaran secara otomatis
                if ($kembalian >= 0) {
                    $status_pembayaran = 'LUNAS';
                } else {
                    $status_pembayaran = 'BELUM_LUNAS';
                }

                // 3. Simpan data ke tabel 'penjualans'
                $penjualan = Penjualan::create([
                    'referensi' => $validatedData['nomer_invoice'], // Pastikan ini benar
                    'tanggal_penjualan' => now(), // Tambahkan baris ini
                    'user_id' => Auth::id(), // Ambil ID user yang sedang login
                    'pelanggan_id' => $validatedData['pelanggan_id'],
                    'subtotal' => $subtotal,
                    'diskon' => $diskon_global,
                    'service' => $service,
                    'ongkir' => $ongkir,
                    'pajak' => $total_pajak_item,
                    'total_akhir' => $total_akhir,
                    'jumlah_dibayar' => $jumlah_dibayar,
                    'kembalian' => $kembalian > 0 ? $kembalian : 0, // Jangan simpan kembalian negatif
                    'status' => $status_pembayaran,
                    'metode_pembayaran' => $validatedData['metode_pembayaran'],
                    'catatan' => $validatedData['catatan'],
                ]);

                // 4. Simpan setiap item ke 'item_penjualan' dan kurangi stok
                foreach ($validatedData['items'] as $itemData) {
                    $produk = $produks->get($itemData['produk_id']);
                    $subtotal_item = ($itemData['harga_jual'] * $itemData['jumlah']) - $itemData['diskon'];
                    $pajak_amount_item = $subtotal_item * ($itemData['pajak_persen'] / 100);

                    $penjualan->items()->create([
                        'produk_id' => $produk->id,
                        'jumlah' => $itemData['jumlah'],
                        'harga' => $itemData['harga_jual'], // Simpan harga jual dari form
                        'diskon_item' => $itemData['diskon'], // Simpan diskon item dari form
                        'pajak_item' => $pajak_amount_item, // Simpan jumlah pajak item
                        'subtotal' => $subtotal_item, // Simpan subtotal setelah diskon
                    ]);

                    // Kurangi stok produk
                    $produk->decrement('qty', $itemData['jumlah']); // Menggunakan kolom 'qty'
                }

                return $penjualan;
            });

            // 5. Redirect ke halaman faktur jika berhasil
            Alert::success('Berhasil', 'Transaksi berhasil disimpan!');
            return redirect()->route('penjualan.show', $penjualan->id);

        } catch (\Exception $e) {
            // Redirect kembali dengan pesan error jika transaksi gagal
            Alert::error('Gagal', 'Terjadi kesalahan saat menyimpan transaksi: ' . $e->getMessage());
            return back()->withInput();
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

    public function getjson(Penjualan $penjualan)
    {
        // Eager load relasi yang dibutuhkan oleh modal edit di frontend
        $penjualan->load('items.produk', 'pelanggan');
        return response()->json($penjualan);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Penjualan $penjualan)
    {
        // 1. Validasi data yang masuk dari form edit
        $validatedData = $request->validate([
            'pelanggan_id' => 'nullable|exists:pelanggans,id',
            'tanggal_penjualan' => 'required|date',
            'metode_pembayaran' => 'required|in:TUNAI,TRANSFER,QRIS',
            'catatan' => 'nullable|string',
            'jumlah_dibayar' => 'required|numeric|min:0',
            'service' => 'nullable|numeric|min:0',
            'ongkir' => 'nullable|numeric|min:0',
            'diskon' => 'nullable|numeric|min:0',
            'items' => 'required|array|min:1',
            'items.*.produk_id' => 'required|exists:produks,id',
            'items.*.jumlah' => 'required|integer|min:1', // Di frontend, ini disebut 'jumlah'
            'items.*.harga_jual' => 'required|numeric|min:0',
            'items.*.diskon' => 'required|numeric|min:0',
            'items.*.pajak_persen' => 'required|numeric|min:0',
        ]);

        try {
            DB::transaction(function () use ($request, $penjualan, $validatedData) {
                // --- MANAJEMEN STOK ---
                // a. Kembalikan stok dari item-item lama
                foreach ($penjualan->items as $oldItem) {
                    Produk::where('id', $oldItem->produk_id)->increment('qty', $oldItem->jumlah);
                }

                // b. Ambil semua produk yang relevan untuk data baru dalam satu query
                $newProdukIds = collect($validatedData['items'])->pluck('produk_id');
                $produks = Produk::whereIn('id', $newProdukIds)->get()->keyBy('id');

                // c. Kurangi stok berdasarkan item-item baru & validasi ketersediaan
                foreach ($validatedData['items'] as $itemData) {
                    $produk = $produks->get($itemData['produk_id']);
                    if (!$produk || $produk->qty < $itemData['jumlah']) {
                        // Jika stok tidak mencukupi setelah pengembalian, batalkan transaksi
                        throw new \Exception("Stok untuk produk '{$produk->nama_produk}' tidak mencukupi.");
                    }
                    $produk->decrement('qty', $itemData['jumlah']);
                }

                // --- PENGHITUNGAN ULANG TOTAL (SERVER-SIDE) ---
                $subtotal_keseluruhan = 0;
                $total_pajak_item = 0;
                foreach ($validatedData['items'] as $itemData) {
                    $subtotal_item = ($itemData['harga_jual'] * $itemData['jumlah']) - $itemData['diskon'];
                    $pajak_amount_item = $subtotal_item * ($itemData['pajak_persen'] / 100);

                    $subtotal_keseluruhan += $subtotal_item;
                    $total_pajak_item += $pajak_amount_item;
                }

                $service = (float)($validatedData['service'] ?? 0);
                $ongkir = (float)($validatedData['ongkir'] ?? 0);
                $diskon_global = (float)($validatedData['diskon'] ?? 0);
                $total_akhir = ($subtotal_keseluruhan + $total_pajak_item + $service + $ongkir) - $diskon_global;
                $jumlah_dibayar = (float) $validatedData['jumlah_dibayar'];
                $kembalian = $jumlah_dibayar - $total_akhir;

                // Tentukan status pembayaran secara otomatis
                if ($kembalian >= 0) {
                    $status_pembayaran = 'LUNAS';
                } else {
                    $status_pembayaran = 'BELUM_LUNAS';
                }

                // --- UPDATE DATA PENJUALAN ---
                // a. Update record utama di tabel 'penjualans'
                $penjualan->update([
                    'pelanggan_id' => $validatedData['pelanggan_id'],
                    'tanggal_penjualan' => $validatedData['tanggal_penjualan'],
                    'metode_pembayaran' => $validatedData['metode_pembayaran'],
                    'catatan' => $validatedData['catatan'],
                    'status' => $status_pembayaran,
                    'subtotal' => $subtotal_keseluruhan,
                    'diskon' => $diskon_global,
                    'service' => $service,
                    'ongkir' => $ongkir,
                    'pajak' => $total_pajak_item,
                    'total_akhir' => $total_akhir,
                    'jumlah_dibayar' => $validatedData['jumlah_dibayar'],
                    'kembalian' => $validatedData['jumlah_dibayar'] - $total_akhir,
                ]);

                // b. Hapus item penjualan yang lama
                $penjualan->items()->delete();

                // c. Buat kembali item penjualan berdasarkan data baru
                foreach ($validatedData['items'] as $itemData) {
                    $subtotal_item = ($itemData['harga_jual'] * $itemData['jumlah']) - $itemData['diskon'];
                    $pajak_amount_item = $subtotal_item * ($itemData['pajak_persen'] / 100);

                    $penjualan->items()->create([
                        'produk_id' => $itemData['produk_id'],
                        'jumlah' => $itemData['jumlah'],
                        'harga' => $itemData['harga_jual'],
                        'diskon_item' => $itemData['diskon'],
                        'pajak_item' => $pajak_amount_item,
                        'subtotal' => $subtotal_item,
                    ]);
                }

                return $penjualan->load('items.produk', 'pelanggan', 'user');
            });

            return response()->json(['success' => true, 'message' => 'Transaksi berhasil diperbarui.', 'data' => $penjualan]);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal memperbarui transaksi: ' . $e->getMessage()], 500);
        }
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

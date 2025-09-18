<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Pemasok;
use App\Models\Pembelian;
use App\Models\Pajak;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\PembelianDetail;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class PembelianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.pembelian.index', [
            'title' => 'Daftar Invoice Pembelian',
            'pembelian' => Pembelian::with(['pemasok', 'user'])->latest()->paginate(10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.pembelian.create', [
            'title' => 'Tambah Invoice Pembelian',
            'pemasok' => Pemasok::all(),
            'pajaks' => Pajak::all(),
            'nomer_referensi' => $this->generatePurchaseInvoiceNumber(),
        ]);
    }

    /**
     * Menghasilkan nomor referensi pembelian yang unik.
     */
    private function generatePurchaseInvoiceNumber()
    {
        // Format: PO-YYYYMMDD-XXXX (e.g., PO-20230831-0001)
        $date = now()->format('Ymd');
        $prefix = 'PO-' . $date . '-';

        // Cari referensi terakhir untuk hari ini untuk mendapatkan nomor urut berikutnya
        $lastPurchase = Pembelian::where('referensi', 'like', $prefix . '%')
                                  ->latest('referensi')
                                  ->first();

        $sequence = 1;
        if ($lastPurchase) {
            $lastSequence = (int) substr($lastPurchase->referensi, -4);
            $sequence = $lastSequence + 1;
        }

        return $prefix . str_pad($sequence, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'pemasok_id' => 'required|exists:pemasoks,id',
            'tanggal' => 'required|date',
            'referensi' => 'required|string|max:255|unique:pembelians',
            'status_barang' => 'required|in:Diterima,Belum Diterima',
            'status_pembayaran' => 'required|in:Lunas,Lunas Sebagian,Belum Lunas',
            'jumlah_dibayar' => 'nullable|numeric|min:0',
            'ongkir' => 'nullable|numeric|min:0',
            'diskon_tambahan' => 'nullable|numeric|min:0',
            'catatan' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.produk_id' => 'required|exists:produks,id',
            'items.*.qty' => 'required|integer|min:1',
            'items.*.harga_beli' => 'required|numeric|min:0',
            'items.*.harga_jual' => 'required|numeric|min:0',
            'items.*.diskon' => 'nullable|numeric|min:0',
            'items.*.pajak_id' => 'nullable|exists:pajaks,id',
        ]);

        try {
            // Ambil data pajak yang relevan dalam satu query untuk efisiensi
            $pajakIds = collect($validatedData['items'])->pluck('pajak_id')->filter()->unique();
            $pajaksData = Pajak::whereIn('id', $pajakIds)->get()->keyBy('id');

            $pembelian = DB::transaction(function () use ($validatedData, $request, $pajaksData) {
                // 1. Ambil semua produk yang relevan dalam satu query
                $produkIds = collect($validatedData['items'])->pluck('produk_id');
                $produks = Produk::whereIn('id', $produkIds)->get()->keyBy('id');

                // 2. Hitung total dari sisi server untuk keamanan
                $subtotal_keseluruhan = 0;
                $total_pajak_item = 0;
                foreach ($validatedData['items'] as $itemData) {
                    $harga_beli = $itemData['harga_beli'];
                    $qty = $itemData['qty'];
                    $diskon_item = $itemData['diskon'] ?? 0;
                    $pajak_id = $itemData['pajak_id'] ?? null;
                    $pajak_rate = $pajak_id ? ($pajaksData->get($pajak_id)->rate ?? 0) : 0;

                    $subtotal_item = ($harga_beli * $qty) - $diskon_item;
                    $pajak_amount_item = $subtotal_item * ($pajak_rate / 100);

                    $subtotal_keseluruhan += $subtotal_item;
                    $total_pajak_item += $pajak_amount_item;
                }

                $ongkir = $validatedData['ongkir'] ?? 0;
                $diskon_tambahan = $validatedData['diskon_tambahan'] ?? 0;
                $total_akhir = $subtotal_keseluruhan + $total_pajak_item - $diskon_tambahan + $ongkir;
                $jumlah_dibayar = $validatedData['jumlah_dibayar'] ?? 0;

                // 3. Tentukan status pembayaran dan sisa hutang secara otomatis
                $sisa_hutang = $total_akhir - $jumlah_dibayar;
                $status_pembayaran = '';
                if ($sisa_hutang <= 0) {
                    // Jika tidak ada sisa hutang (atau ada kembalian), statusnya Lunas.
                    $status_pembayaran = 'Lunas';
                } elseif ($jumlah_dibayar > 0 && $sisa_hutang > 0) {
                    // Jika ada pembayaran tapi masih ada sisa, statusnya Lunas Sebagian.
                    $status_pembayaran = 'Lunas Sebagian';
                } else {
                    // Jika tidak ada pembayaran dan ada hutang, statusnya Belum Lunas.
                    $status_pembayaran = 'Belum Lunas';
                }

                // 3. Buat record Pembelian
                $pembelian = Pembelian::create([
                    'pemasok_id' => $validatedData['pemasok_id'],
                    'user_id' => Auth::id(),
                    'referensi' => $validatedData['referensi'],
                    'tanggal_pembelian' => $validatedData['tanggal'],
                    'subtotal' => $subtotal_keseluruhan,
                    'diskon' => $diskon_tambahan,
                    'pajak' => $total_pajak_item,
                    'ongkir' => $ongkir,
                    'total_akhir' => $total_akhir,
                    'jumlah_dibayar' => $jumlah_dibayar,
                    'sisa_hutang' => $sisa_hutang > 0 ? $sisa_hutang : 0, // Simpan hutang jika ada
                    'status_pembayaran' => $status_pembayaran, // Gunakan status yang sudah ditentukan
                    'status_barang' => $validatedData['status_barang'],
                    'catatan' => $validatedData['catatan'],
                ]);

                // 4. Buat record PembelianDetail, update stok, dan update harga beli produk
                foreach ($validatedData['items'] as $itemData) {
                    // Buat detail pembelian
                    $subtotal_item = ($itemData['harga_beli'] * $itemData['qty']) - ($itemData['diskon'] ?? 0);

                    $pembelian->details()->create([
                        'produk_id' => $itemData['produk_id'],
                        'qty' => $itemData['qty'],
                        'harga_beli' => $itemData['harga_beli'],
                        'diskon' => $itemData['diskon'] ?? 0,
                        'pajak_id' => $itemData['pajak_id'] ?? null,
                        'subtotal' => $subtotal_item,
                    ]);
                    // Ambil model produk yang sesuai
                    $produk = $produks->get($itemData['produk_id']);

                    // Update data di tabel produk master
                    $produk->harga_beli = $itemData['harga_beli'];
                    $produk->harga_jual = $itemData['harga_jual'];

                    // Tambah stok hanya jika status barang 'Diterima'
                    if ($validatedData['status_barang'] === 'Diterima') {
                        $produk->qty += $itemData['qty'];
                    }
                    $produk->save(); // Simpan perubahan (harga beli, harga jual, dan/atau stok)
                }

                return $pembelian;
            });

            Alert::success('Berhasil', 'Transaksi pembelian berhasil disimpan.');
            return redirect()->route('pembelian.index');

        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Pembelian $pembelian)
    {
        // Eager load relasi untuk efisiensi query dan menghindari N+1 problem
        $pembelian->load('pemasok', 'user', 'details.produk');

        return view('dashboard.pembelian.show', [
            'title' => 'Detail Pembelian: ' . $pembelian->referensi,
            'pembelian' => $pembelian,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pembelian $pembelian)
    {
        // Eager load relasi untuk efisiensi
        $pembelian->load('details.produk');

        return view('dashboard.pembelian.edit', [
            'title' => 'Edit Invoice Pembelian: ' . $pembelian->referensi,
            'pembelian' => $pembelian,
            'pemasok' => Pemasok::all(),
            'pajaks' => Pajak::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pembelian $pembelian)
    {
        $validatedData = $request->validate([
            'pemasok_id' => 'required|exists:pemasoks,id',
            'tanggal' => 'required|date',
            'status_barang' => 'required|in:Diterima,Belum Diterima',
            'jumlah_dibayar' => 'nullable|numeric|min:0',
            'ongkir' => 'nullable|numeric|min:0',
            'diskon_tambahan' => 'nullable|numeric|min:0',
            'catatan' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.produk_id' => 'required|exists:produks,id',
            'items.*.qty' => 'required|integer|min:1',
            'items.*.harga_beli' => 'required|numeric|min:0',
            'items.*.harga_jual' => 'required|numeric|min:0',
            'items.*.diskon' => 'nullable|numeric|min:0',
            'items.*.pajak_id' => 'nullable|exists:pajaks,id',
        ]);

        try {
            $pajakIds = collect($validatedData['items'])->pluck('pajak_id')->filter()->unique();
            $pajaksData = Pajak::whereIn('id', $pajakIds)->get()->keyBy('id');

            DB::transaction(function () use ($validatedData, $pembelian, $pajaksData) {
                // --- MANAJEMEN STOK ---
                // a. Kembalikan stok dari item-item lama, HANYA jika status barang sebelumnya 'Diterima'
                if ($pembelian->status_barang === 'Diterima') {
                    foreach ($pembelian->details as $oldDetail) {
                        Produk::where('id', $oldDetail->produk_id)->decrement('qty', $oldDetail->qty);
                    }
                }

                // b. Ambil semua produk yang relevan untuk data baru dalam satu query
                $newProdukIds = collect($validatedData['items'])->pluck('produk_id');
                $produks = Produk::whereIn('id', $newProdukIds)->get()->keyBy('id');

                // c. Tambah stok berdasarkan item-item baru, HANYA jika status barang baru 'Diterima'
                if ($validatedData['status_barang'] === 'Diterima') {
                    foreach ($validatedData['items'] as $itemData) {
                        $produk = $produks->get($itemData['produk_id']);
                        if (!$produk || $produk->qty < $itemData['qty']) {
                            // Batalkan transaksi jika stok tidak mencukupi setelah pengembalian
                            throw new \Exception("Stok untuk produk '{$produk->nama_produk}' tidak mencukupi.");
                        }
                        $produk->increment('qty', $itemData['qty']);
                    }
                }

                // --- PENGHITUNGAN ULANG TOTAL (SERVER-SIDE) ---
                $subtotal_keseluruhan = 0;
                $total_pajak_item = 0;
                foreach ($validatedData['items'] as $itemData) {
                    $pajak_id = $itemData['pajak_id'] ?? null;
                    $pajak_rate = $pajak_id ? ($pajaksData->get($pajak_id)->rate ?? 0) : 0;

                    $subtotal_item = ($itemData['harga_beli'] * $itemData['qty']) - ($itemData['diskon'] ?? 0);
                    $pajak_amount_item = $subtotal_item * ($pajak_rate / 100);

                    $subtotal_keseluruhan += $subtotal_item;
                    $total_pajak_item += $pajak_amount_item;
                }

                $ongkir = $validatedData['ongkir'] ?? 0;
                $diskon_tambahan = $validatedData['diskon_tambahan'] ?? 0;
                $total_akhir = $subtotal_keseluruhan + $total_pajak_item - $diskon_tambahan + $ongkir;
                $jumlah_dibayar = $validatedData['jumlah_dibayar'] ?? 0;
                $sisa_hutang = $total_akhir - $jumlah_dibayar;

                // Tentukan status pembayaran secara otomatis
                if ($sisa_hutang <= 0) {
                    $status_pembayaran = 'Lunas';
                } elseif ($jumlah_dibayar > 0 && $sisa_hutang > 0) {
                    $status_pembayaran = 'Lunas Sebagian';
                } else {
                    $status_pembayaran = 'Belum Lunas';
                }

                // --- UPDATE DATA PEMBELIAN ---
                $pembelian->update([
                    'pemasok_id' => $validatedData['pemasok_id'],
                    'tanggal_pembelian' => $validatedData['tanggal'],
                    'subtotal' => $subtotal_keseluruhan,
                    'diskon' => $diskon_tambahan,
                    'pajak' => $total_pajak_item,
                    'ongkir' => $ongkir,
                    'total_akhir' => $total_akhir,
                    'jumlah_dibayar' => $jumlah_dibayar,
                    'sisa_hutang' => $sisa_hutang > 0 ? $sisa_hutang : 0,
                    'status_pembayaran' => $status_pembayaran,
                    'status_barang' => $validatedData['status_barang'],
                    'catatan' => $validatedData['catatan'],
                ]);

                // Hapus detail lama dan buat yang baru
                $pembelian->details()->delete();

                foreach ($validatedData['items'] as $itemData) {
                    $subtotal_item = ($itemData['harga_beli'] * $itemData['qty']) - ($itemData['diskon'] ?? 0);
                    $pembelian->details()->create([
                        'produk_id' => $itemData['produk_id'],
                        'qty' => $itemData['qty'],
                        'harga_beli' => $itemData['harga_beli'],
                        'diskon' => $itemData['diskon'] ?? 0,
                        'pajak_id' => $itemData['pajak_id'] ?? null,
                        'subtotal' => $subtotal_item,
                    ]);

                    // Update data master produk
                    $produk = $produks->get($itemData['produk_id']);
                    if ($produk) {
                        $produk->harga_beli = $itemData['harga_beli'];
                        $produk->harga_jual = $itemData['harga_jual'];
                        $produk->save();
                    }
                }
            });

            Alert::success('Berhasil', 'Transaksi pembelian berhasil diperbarui.');
            return redirect()->route('pembelian.index');

        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Gagal memperbarui transaksi: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pembelian $pembelian)
    {
        try {
            DB::transaction(function () use ($pembelian) {
                // Kembalikan stok hanya jika barangnya pernah diterima
                if ($pembelian->status_barang === 'Diterima') {
                    foreach ($pembelian->details as $detail) {
                        Produk::where('id', $detail->produk_id)->decrement('qty', $detail->qty);
                    }
                }
                $pembelian->delete(); // Ini akan menghapus detail juga karena relasi cascade
            });
            Alert::success('Berhasil', 'Transaksi pembelian berhasil dihapus.');
            return redirect()->route('pembelian.index');
        } catch (\Exception $e) {
            Alert::error('Gagal', 'Gagal menghapus transaksi: ' . $e->getMessage());
            return back();
        }
    }
}

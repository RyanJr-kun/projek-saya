<?php

namespace App\Http\Controllers;

use App\Models\ItemPenjualan;
use App\Models\Penjualan;
use App\Models\Produk;
use App\Models\ReturPenjualan;
use App\Models\SerialNumber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class ReturPenjualanController extends Controller
{
    /**
     * Menampilkan daftar retur penjualan.
     */
    public function index(Request $request)
    {
        $query = ReturPenjualan::with(['penjualan', 'user'])->latest();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('kode_retur', 'like', "%{$search}%")
                    ->orWhereHas('penjualan', function ($q_penjualan) use ($search) {
                        $q_penjualan->where('referensi', 'like', "%{$search}%");
                    });
            });
        }

        $returs = $query->paginate(15)->withQueryString();

        return view('dashboard.penjualan.retur.index', [
            'title' => 'Daftar Retur Penjualan',
            'returs' => $returs,
        ]);
    }

    /**
     * Menampilkan form untuk membuat retur baru.
     */
    public function create(Request $request)
    {
        $penjualan = null;
        if ($request->filled('referensi')) {
            $penjualan = Penjualan::with(['items.produk', 'items.serialNumbers', 'pelanggan'])
                ->where('referensi', $request->referensi)
                ->where('status_pembayaran', '!=', 'Dibatalkan') // Hanya invoice yang tidak dibatalkan
                ->first();

            if (!$penjualan) {
                Alert::error('Gagal', 'Invoice dengan nomor referensi tersebut tidak ditemukan atau sudah dibatalkan.');
                return redirect()->route('retur-penjualan.create');
            }
        }

        return view('dashboard.penjualan.retur.create', [
            'title' => 'Buat Retur Penjualan',
            'penjualan' => $penjualan,
        ]);
    }

    /**
     * Menyimpan data retur penjualan baru.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'penjualan_id' => 'required|exists:penjualans,id',
            'tanggal_retur' => 'required|date',
            'catatan' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.item_penjualan_id' => 'required|exists:item_penjualans,id',
            'items.*.produk_id' => 'required|exists:produks,id',
            'items.*.jumlah_retur' => 'required|integer|min:1',
            'items.*.serial_numbers' => 'nullable|array',
            'items.*.serial_numbers.*' => 'string', // Validasi setiap SN adalah string
        ]);

        try {
            $retur = DB::transaction(function () use ($validatedData, $request) {
                $penjualan = Penjualan::findOrFail($validatedData['penjualan_id']);
                $totalRetur = 0;

                // 1. Buat record master retur
                $returPenjualan = ReturPenjualan::create([
                    'kode_retur' => $this->generateReturnCode(),
                    'penjualan_id' => $penjualan->id,
                    'user_id' => Auth::id(),
                    'tanggal_retur' => $validatedData['tanggal_retur'],
                    'catatan' => $validatedData['catatan'],
                    'total_retur' => 0, // Akan diupdate nanti
                ]);

                // 2. Proses setiap item yang diretur
                foreach ($validatedData['items'] as $itemData) {
                    $itemPenjualan = ItemPenjualan::findOrFail($itemData['item_penjualan_id']);
                    $produk = Produk::findOrFail($itemData['produk_id']);
                    $jumlahRetur = (int)$itemData['jumlah_retur'];

                    // Validasi jumlah retur tidak melebihi jumlah beli
                    if ($jumlahRetur > $itemPenjualan->jumlah) {
                        throw new \Exception("Jumlah retur untuk produk '{$produk->nama_produk}' melebihi jumlah pembelian.");
                    }

                    // Hitung subtotal retur (berdasarkan harga jual saat transaksi)
                    $subtotalItemRetur = $itemPenjualan->harga_jual * $jumlahRetur;
                    $totalRetur += $subtotalItemRetur;

                    // Buat record detail retur
                    $returPenjualan->items()->create([
                        'item_penjualan_id' => $itemPenjualan->id,
                        'produk_id' => $produk->id,
                        'jumlah' => $jumlahRetur,
                        'harga' => $itemPenjualan->harga_jual,
                        'subtotal' => $subtotalItemRetur,
                    ]);

                    // Kembalikan stok produk
                    $produk->increment('qty', $jumlahRetur);

                    // Jika produk wajib seri, update status nomor seri
                    if ($produk->wajib_seri && !empty($itemData['serial_numbers'])) {
                        // Validasi jumlah SN sesuai dengan jumlah retur
                        if (count($itemData['serial_numbers']) !== $jumlahRetur) {
                            throw new \Exception("Jumlah nomor seri untuk '{$produk->nama_produk}' tidak sesuai dengan jumlah retur.");
                        }
                        // Update status SN menjadi 'Tersedia'
                        SerialNumber::whereIn('nomor_seri', $itemData['serial_numbers'])
                            ->where('produk_id', $produk->id)
                            ->update(['status' => 'Tersedia', 'item_penjualan_id' => null]);
                    }
                }

                // 3. Update total nilai retur di record master
                $returPenjualan->update(['total_retur' => $totalRetur]);

                return $returPenjualan;
            });

            Alert::success('Berhasil', 'Retur penjualan berhasil disimpan.');
            return redirect()->route('retur-penjualan.show', $retur->id);

        } catch (\Exception $e) {
            Alert::error('Gagal', 'Terjadi kesalahan: ' . $e->getMessage());
            return back()->withInput();
        }
    }

    /**
     * Menampilkan detail retur penjualan.
     */
    public function show(ReturPenjualan $retur_penjualan)
    {
        $retur_penjualan->load(['penjualan.pelanggan', 'user', 'items.produk']);

        return view('dashboard.penjualan.retur.show', [
            'title' => 'Detail Retur: ' . $retur_penjualan->kode_retur,
            'retur' => $retur_penjualan,
        ]);
    }

    /**
     * Menghasilkan kode retur yang unik.
     */
    private function generateReturnCode()
    {
        $date = now()->format('Ymd');
        $prefix = 'RTN-' . $date . '-';

        $lastReturn = ReturPenjualan::where('kode_retur', 'like', $prefix . '%')
            ->latest('kode_retur')
            ->first();

        $sequence = 1;
        if ($lastReturn) {
            $lastSequence = (int) substr($lastReturn->kode_retur, -4);
            $sequence = $lastSequence + 1;
        }

        return $prefix . str_pad($sequence, 4, '0', STR_PAD_LEFT);
    }
}

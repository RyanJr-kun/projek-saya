<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\SerialNumber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule; // <-- Tambahkan ini

class SerialNumberController extends Controller
{
    public function index(Request $request)
    {
        $query = SerialNumber::with(['produk', 'penjualan'])->latest();

        if ($request->filled('search')) {
            $query->where('nomor_seri', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('produk_id')) {
            $query->where('produk_id', $request->produk_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $serialNumbers = $query->paginate(15)->withQueryString();
        $produks = Produk::where('wajib_seri', true)->orderBy('nama_produk')->get();

        return view('dashboard.inventaris.serialNumber.index', [
            'title' => 'Manajemen Nomor Seri',
            'serialNumbers' => $serialNumbers,
            'produks' => $produks,
        ]);
    }

    public function getProductInfo(Request $request)
    {
        $request->validate(['produk_id' => 'required|exists:produks,id']);
        $produk = Produk::find($request->produk_id);
        $stokTercatat = $produk->qty;
        $snTerdaftar = SerialNumber::where('produk_id', $request->produk_id)->count();
        return response()->json([
            'stok_tercatat' => $stokTercatat,
            'sn_terdaftar' => $snTerdaftar
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'produk_id' => 'required|exists:produks,id',
            'serial_numbers' => 'required|array|min:1',
            'serial_numbers.*' => [
                'required',
                'string',
                'distinct', // Ensures no duplicates in the submitted list
                // Ensures the serial number is unique for this specific product
                Rule::unique('serial_numbers', 'nomor_seri')->where(function ($query) use ($request) {
                    return $query->where('produk_id', $request->produk_id);
                }),
            ],
        ], [
            // Custom error messages
            'serial_numbers.*.distinct' => 'Nomor seri :input terduplikasi dalam daftar yang Anda kirim.',
            'serial_numbers.*.unique' => 'Nomor seri :input sudah terdaftar untuk produk ini.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Data yang diberikan tidak valid.',
                'errors' => $validator->errors()
            ], 422); // 422 Unprocessable Entity is a good choice for validation errors
        }

        $validated = $validator->validated();
        $serialsToInsert = [];
        $now = now();

        foreach ($validated['serial_numbers'] as $serial) {
            $serialsToInsert[] = [
                'produk_id' => $validated['produk_id'],
                'nomor_seri' => $serial,
                'status' => 'Tersedia', // Set default status
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        // Use bulk insert for better performance
        SerialNumber::insert($serialsToInsert);

        return response()->json([
            'message' => count($serialsToInsert) . ' nomor seri berhasil ditambahkan.'
        ], 201); // 201 Created is the correct status code for successful creation
    }

    public function storeMultiple(Request $request)
    {
        // --- PERBAIKAN: Tambahkan Validasi ---
        $validated = $request->validate([
            'produk_id' => 'required|exists:produks,id',
            'serial_numbers' => 'required|array|min:1',
            // Pastikan setiap nomor seri unik di tabel untuk produk_id yang sama
            'serial_numbers.*' => [
                'required',
                'distinct',
                Rule::unique('serial_numbers', 'nomor_seri')->where('produk_id', $request->produk_id),
            ],
        ], [
            'serial_numbers.*.required' => 'Nomor seri tidak boleh kosong.',
            'serial_numbers.*.distinct' => 'Terdapat nomor seri duplikat pada input Anda.',
            'serial_numbers.*.unique' => 'Nomor seri :input sudah terdaftar untuk produk ini.',
        ]);

        DB::beginTransaction();
        try {
            $productId = $validated['produk_id'];
            $serialNumbers = $validated['serial_numbers'];
            $now = now();
            $dataToInsert = [];

            foreach ($serialNumbers as $sn) {
                $dataToInsert[] = [
                    'produk_id' => $productId,
                    'nomor_seri' => $sn,
                    'status' => 'Tersedia',
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }

            SerialNumber::insert($dataToInsert);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => count($dataToInsert) . ' nomor seri berhasil ditambahkan.'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error saat menyimpan multiple serial numbers: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan pada server. Silakan coba lagi.'
            ], 500);
        }
    }

    // --- PERBAIKAN: Isi method update ---
    public function update(Request $request, SerialNumber $serialNumber)
    {
        $validated = $request->validate([
            'serial_number' => [
                'required',
                // Pastikan unik, kecuali untuk dirinya sendiri
                Rule::unique('serial_numbers', 'nomor_seri')->where('produk_id', $serialNumber->produk_id)->ignore($serialNumber->id),
            ],
            'status' => 'required|in:Tersedia,Rusak,Hilang', // Batasi status yang bisa diubah dari sini
        ]);

        try {
            // Map the validated 'serial_number' from the request to the 'nomor_seri' database column.
            $dataToUpdate = [
                'nomor_seri' => $validated['serial_number'],
                'status' => $validated['status'],
            ];
            $serialNumber->update($dataToUpdate);
            return response()->json([
                'success' => true,
                'message' => 'Nomor seri berhasil diperbarui.'
            ]);
        } catch (\Exception $e) {
            Log::error('Error update serial number: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui nomor seri.'
            ], 500);
        }
    }

    // --- PERBAIKAN: Isi method destroy ---
    public function destroy(SerialNumber $serialNumber)
    {
        // Tambahkan proteksi: jangan hapus SN yang sudah terjual
        if ($serialNumber->status == 'Terjual') {
            return response()->json([
                'success' => false,
                'message' => 'Nomor seri yang sudah terjual tidak dapat dihapus.'
            ], 422); // Unprocessable Entity
        }

        try {
            $serialNumber->delete();
            return response()->json([
                'success' => true,
                'message' => 'Nomor seri berhasil dihapus.'
            ]);
        } catch (\Exception $e) {
            Log::error('Error delete serial number: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus nomor seri.'
            ], 500);
        }
    }
}

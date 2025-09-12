<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use App\Models\Brand;
use App\Models\Pajak;
use App\Models\Produk;
use App\Models\Garansi;
use Illuminate\Http\Request;
use App\Models\KategoriProduk;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use \Cviebrock\EloquentSluggable\Services\SlugService;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.inventaris.produk.index', [
        'produk' => Produk::latest()->paginate(10)
    ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.inventaris.produk.create',[
            'kategori' => KategoriProduk::all(),
            'brand' => Brand::all(),
            'unit' => Unit::all(),
            'garansi' => Garansi::all(),
            'pajak' => Pajak::all(),
        ]);
    }



    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_produk' => 'required|string|max:255',
            'slug' => 'required|string|unique:produks,slug',
            'barcode' => 'nullable|string|unique:produks,barcode',
            'sku' => 'required|string|unique:produks,sku',
            'kategori' => 'required|exists:kategori_produks,id',
            'brand' => 'required|exists:brands,id',
            'unit' => 'required|exists:units,id',
            'deskripsi' => 'nullable|string',
            'harga_jual' => 'required|numeric',
            'harga_beli' => 'required|numeric',
            'qty' => 'required|integer',
            'garansi' => 'required|exists:garansis,id',
            'stok_minimum' => 'required|integer',
            'pajak' => 'required|exists:pajaks,id',
            'img_produk' => 'nullable|string',
        ]);

        $validatedData['user_id'] = Auth::id();
        $validatedData['kategori_produk_id'] = $validatedData['kategori'];
        $validatedData['brand_id'] = $validatedData['brand'];
        $validatedData['unit_id'] = $validatedData['unit'];
        $validatedData['pajak_id'] = $validatedData['pajak'];
        $validatedData['garansi_id'] = $validatedData['garansi'];

        // Pindahkan gambar dari temp ke folder produk
        if ($request->img_produk) {
            $tempPath = $request->img_produk;
            if (Storage::disk('public')->exists($tempPath)) {
                $newPath = str_replace('tmp/produk/', 'produk/', $tempPath);
                Storage::disk('public')->move($tempPath, $newPath);
                $validatedData['img_produk'] = $newPath;
            }
        }

        unset($validatedData['kategori'], $validatedData['brand'], $validatedData['unit'], $validatedData['garansi'],$validatedData['pajak']);

        Produk::create($validatedData);
        Alert::success('Berhasil', 'Produk Baru Berhasil Ditambahkan.');
        return redirect()->route('produk.index');
    }


    /**
     * Display the specified resource.
     */
    public function show(Produk $produk)
    {
       return view('dashboard.inventaris.produk.show',[
            // Eager load relationships to prevent N+1 query issues
            'produk' => $produk->load(['kategori_produk', 'brand', 'unit', 'garansi', 'user', 'pajak'])
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Produk $produk)
    {
        return view('dashboard.inventaris.produk.edit',[
            'produk' => $produk,
            'kategoris' => KategoriProduk::all(),
            'brands' => Brand::all(),
            'units' => Unit::all(),
            'garansis' => Garansi::all(),
            'pajak' => Pajak::all(),
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Produk $produk)
    {
        $rules = [
            'nama_produk' => 'required|string|max:255',
            'kategori' => 'required|exists:kategori_produks,id',
            'brand' => 'required|exists:brands,id',
            'unit' => 'required|exists:units,id',
            'pajak' => 'required|exists:pajaks,id',
            'deskripsi' => 'nullable|string',
            'harga_jual' => 'required|numeric',
            'harga_beli' => 'required|numeric',
            'qty' => 'required|integer',
            'garansi' => 'nullable|exists:garansis,id',
            'stok_minimum' => 'required|integer',
            'img_produk' => 'nullable|string',
            'slug' => ['required', 'string', Rule::unique('produks', 'slug')->ignore($produk->id)],
            'barcode' => ['nullable', 'string', Rule::unique('produks', 'barcode')->ignore($produk->id)],
            'sku' => ['required', 'string', Rule::unique('produks', 'sku')->ignore($produk->id)],
        ];

        $validatedData = $request->validate($rules);
        $validatedData['user_id'] = Auth::id();
        $validatedData['kategori_produk_id'] = $validatedData['kategori'];
        $validatedData['brand_id'] = $validatedData['brand'];
        $validatedData['unit_id'] = $validatedData['unit'];
        $validatedData['garansi_id'] = $validatedData['garansi'];
        $validatedData['pajak_id'] = $validatedData['pajak'];

        // Cek apakah ada gambar baru yang diunggah (path dimulai dengan 'tmp/')
        if ($request->filled('img_produk') && str_starts_with($request->img_produk, 'tmp/')) {
            $tempPath = $request->img_produk;
            if (Storage::disk('public')->exists($tempPath)) {
                // Hapus gambar lama jika ada
                if ($produk->img_produk && Storage::disk('public')->exists($produk->img_produk)) {
                    Storage::disk('public')->delete($produk->img_produk);
                }
                // Pindahkan gambar baru dari tmp ke folder produk
                $newPath = str_replace('tmp/produk/', 'produk/', $tempPath);
                Storage::disk('public')->move($tempPath, $newPath);
                $validatedData['img_produk'] = $newPath;
            }
        // Cek jika pengguna menghapus gambar (input ada tapi nilainya kosong/null)
        } elseif ($request->exists('img_produk') && $request->input('img_produk') === null) {
            if ($produk->img_produk && Storage::disk('public')->exists($produk->img_produk)) {
                Storage::disk('public')->delete($produk->img_produk);
                $validatedData['img_produk'] = null;
            }
        }

        unset($validatedData['kategori'], $validatedData['brand'], $validatedData['unit'], $validatedData['garansi'], $validatedData['pajak']);

        $produk->update($validatedData);
        Alert::success('Berhasil', 'Data Produk Berhasil Diperbarui.');
        return redirect()->route('produk.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Produk $produk)
    {
        if ($produk->img_produk && Storage::disk('public')->exists($produk->img_produk)) {
        Storage::disk('public')->delete($produk->img_produk);
        }

        $produk->delete();
        Alert::success('Berhasil', 'Data Produk Berhasil Dihapus.');
        return redirect()->route('produk.index');
    }

    public function chekSlug(Request $request)
    {
        $slug = SlugService::createSlug(Produk::class, 'slug', $request->nama_produk );
        return response()->json(['slug' => $slug]);
    }

    public function upload(Request $request)
    {
        if ($request->hasFile('img_produk')) {
            $request->validate([
                'img_produk' => 'required|image|mimes:jpeg,png,jpg,svg,webp|max:2048',
            ]);
            $file = $request->file('img_produk');
            // Simpan ke storage/app/public/tmp/produk
            $path = $file->store('tmp/produk', 'public');
            // Kembalikan path sebagai response text, FilePond akan menangkap ini
            return $path;
        }
        // Jika gagal
        return response('Gagal mengunggah.', 500);
    }

    /**
     * Menangani pembatalan unggahan file dari FilePond.
     */
    public function revert(Request $request)
    {
        // FilePond mengirimkan path file sebagai konten body request
        $filePath = $request->getContent();

        if ($filePath && Storage::disk('public')->exists($filePath)) {
            Storage::disk('public')->delete($filePath);
            return response()->noContent(); // Berhasil, tidak ada konten untuk dikembalikan
        }

        return response()->json(['error' => 'File not found or path is missing.'], 404);
    }

    public function getData(Request $request)
    {
        $search = $request->query('search');
        $query = Produk::query();

        if ($search) {
            // Jika ada pencarian, cari berdasarkan nama produk
            $query->where('nama_produk', 'LIKE', '%' . $search . '%');
        } else {
            // Jika tidak ada pencarian (saat pertama kali dibuka), urutkan berdasarkan stok terendah
            $query->orderBy('qty', 'asc')->limit(5);
        }
        return response()->json($query->get());
    }
    public function cekStok(Request $request)
    {
        $id = $request->query('id');
        $stok = Produk::find($id)->qty;
        return response()->json($stok);
    }
}

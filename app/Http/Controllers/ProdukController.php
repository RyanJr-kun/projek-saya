<?php

namespace App\Http\Controllers;


use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use \Cviebrock\EloquentSluggable\Services\SlugService;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.produk.index', [
        'title'=>'Produk',
        'produk' => Produk::latest()->paginate(10)
    ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.produk.create',[
            'title' => 'Buat Produk',
            'bread' => 'Buat produk Baru'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function uploadImage(Request $request)
    {
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            // Simpan file ke direktori sementara dan kembalikan path-nya
            $path = $file->store('tmp', 'public');
            return response()->json(['path' => $path]);
        }
        return response()->json(['error' => 'No file uploaded.'], 400);
    }
    public function store(Request $request)
    {
        // --- INI BAGIAN YANG PALING PENTING ---
        $validatedData = $request->validate([
            'nama_produk' => 'required|string|max:255',
            'slug' => 'required|string|unique:produks,slug',
            'barcode' => 'nullable|string|unique:produks,barcode',
            'sku' => 'required|string|unique:produks,sku',
            'kategori' => 'required|exists:kategori_produks,id', // 'kategori' sesuai nama di form
            'brand' => 'required|exists:brands,id',
            'unit' => 'required|exists:units,id',
            'deskripsi' => 'nullable|string',
            'harga' => 'required|numeric', // 'harga' dari form single product
            'qty' => 'required|integer', // 'qty' dari form single product
            'garansi' => 'nullable|exists:garansis,id',
            'stok_minimum' => 'required|integer',
            'img_produk' => 'required|string',
        ]);

        // Menambahkan user_id yang sedang login
        $validatedData['user_id'] = Auth::id();

        // Mengubah nama key agar sesuai dengan kolom di database
        $validatedData['kategori_produk_id'] = $validatedData['kategori'];
        $validatedData['brand_id'] = $validatedData['brand'];
        $validatedData['unit_id'] = $validatedData['unit'];
        $validatedData['garansi_id'] = $validatedData['garansi'];
        if ($request->img_produk) {
            $tempPath = $request->img_produk;
            $newPath = str_replace('tmp/', 'produk/', $tempPath);
            Storage::disk('public')->move($tempPath, $newPath);
            $validatedData['img_produk'] = $newPath;
        }
        unset($validatedData['kategori'], $validatedData['brand'], $validatedData['unit'], $validatedData['garansi']);

        Produk::create($validatedData);

        return redirect()->route('produk.index')->with('success', 'Produk baru berhasil ditambahkan.');
    }


    /**
     * Display the specified resource.
     */
    public function show(Produk $produk)
    {
       return view('dashboard.produk.show',[
            'title' => 'Detail Produk',
            'bread' => 'Detail Produk',
            'produk' => $produk
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Produk $produk)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Produk $produk)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Produk $produk)
    {
        //
    }

    public function chekSlug(Request $request)
    {
        $slug = SlugService::createSlug(Produk::class, 'slug', $request->nama_produk );
        return response()->json(['slug' => $slug]);
    }
}

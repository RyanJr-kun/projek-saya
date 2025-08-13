<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use App\Models\Brand;
use App\Models\Produk;
use App\Models\Garansi;
use Illuminate\Http\Request;
use App\Models\KategoriProduk;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
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
            'kategoris' => KategoriProduk::all(),
            'brands' => Brand::all(),
            'units' => Unit::all(),
            'garansis' => Garansi::all(),
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
            'kategori' => 'required|exists:kategori_produks,id', // 'kategori' sesuai nama di form
            'brand' => 'required|exists:brands,id',
            'unit' => 'required|exists:units,id',
            'deskripsi' => 'nullable|string',
            'harga' => 'required|numeric', // 'harga' dari form single product
            'qty' => 'required|integer', // 'qty' dari form single product
            'garansi' => 'required|exists:garansis,id',
            'stok_minimum' => 'required|integer',
            'img_produk' => 'nullable|string',
        ]);


        $validatedData['user_id'] = Auth::id();
        $validatedData['kategori_produk_id'] = $validatedData['kategori'];
        $validatedData['brand_id'] = $validatedData['brand'];
        $validatedData['unit_id'] = $validatedData['unit'];
        $validatedData['garansi_id'] = $validatedData['garansi'];
        // if ($request->img_produk) {
        //     $tempPath = $request->img_produk;
        //     $newPath = str_replace('tmp/', 'produk/', $tempPath);
        //     Storage::disk('public')->move($tempPath, $newPath);
        //     $validatedData['img_produk'] = $newPath;
        // }
        unset($validatedData['kategori'], $validatedData['brand'], $validatedData['unit'], $validatedData['garansi']);

        Produk::create($validatedData);
        return redirect('/produk')->with('success', 'Produk baru berhasil ditambahkan.');
    }


    /**
     * Display the specified resource.
     */
    public function show(Produk $produk)
    {
       return view('dashboard.inventaris.produk.show',[
            'produk' => $produk
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
            'deskripsi' => 'nullable|string',
            'harga' => 'required|numeric',
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

        if ($request->img_produk) {
            $tempPath = $request->img_produk;
            $newPath = str_replace('tmp/', 'produk/', $tempPath);
            Storage::disk('public')->move($tempPath, $newPath);
            $validatedData['img_produk'] = $newPath;
        }

        unset($validatedData['kategori'], $validatedData['brand'], $validatedData['unit'], $validatedData['garansi']);

        $produk->update($validatedData);
        return redirect('/produk')->with('success', 'Data Produk berhasil diperbarui!');
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
        return redirect()->route('produk.index')->with('success', 'Data Produk berhasil dihapus!');
    }

    public function chekSlug(Request $request)
    {
        $slug = SlugService::createSlug(Produk::class, 'slug', $request->nama_produk );
        return response()->json(['slug' => $slug]);
    }
}

<?php

namespace App\Http\Controllers;
use App\Models\KategoriProduk;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use \Cviebrock\EloquentSluggable\Services\SlugService;


class KategoriProdukController extends Controller
{
   public function index() {
    return view('dashboard.inventaris.kategoriproduk', [
        'title' => 'Data Kategori Produk',
        'kategoris'=>KategoriProduk::withCount('produks')->latest()->paginate(15),
    ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
   public function store(Request $request)
    {
        $validatedData = $request->validate([
            'img_kategori' => 'nullable|image|mimes:jpeg,png|max:1024',
            'nama' => 'required|max:255|unique:kategori_produks',
            'slug' => 'required|max:255|unique:kategori_produks',
            'status' => 'nullable|boolean',
        ]);

        // Pindahkan gambar dari temp ke folder produk
        if ($request->img_kategori) {
            $tempPath = $request->img_kategori;
            if (Storage::disk('public')->exists($tempPath)) {
                $newPath = str_replace('tmp/kategori-images/', 'kategori-images/', $tempPath);
                Storage::disk('public')->move($tempPath, $newPath);
                $validatedData['img_kategori'] = $newPath;
            }
        }

        $validatedData['status'] = $request->has('status');

        KategoriProduk::create($validatedData);
        return redirect('/kategoriproduk')->with('success', 'Kategori produk baru berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(KategoriProduk $kategori_produk) {
        //
    }

    public function getKategoriJson(KategoriProduk $kategoriproduk)
    {
        return response()->json($kategoriproduk);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(KategoriProduk $kategoriproduk)
    {
        return redirect()->route('kategoriproduk.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, KategoriProduk $kategoriproduk)
    {
        $rules = [
            'img_kategori' => 'nullable|image|mimes:jpeg,png|max:1024',
            'nama' => ['required', 'max:255', Rule::unique('kategori_produks')->ignore($kategoriproduk->id)],
            'slug' => ['required', 'max:255', Rule::unique('kategori_produks')->ignore($kategoriproduk->id)],
            'status' => 'nullable|boolean',
        ];

        $validatedData = $request->validate($rules);

         if ($request->file('img_kategori')) {
            if ($kategoriproduk->img_kategori) {
                Storage::disk('public')->delete($kategoriproduk->img_kategori);
            }
            $path = $request->file('img_kategori')->store('kategori-images', 'public');
            $validatedData['img_kategori'] = $path;
        }


        $validatedData['status'] = $request->has('status');
        $kategoriproduk->update($validatedData);
        return redirect()->route('kategoriproduk.index')->with('success', 'Kategori produk berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(KategoriProduk $kategoriproduk)
    {
        if ($kategoriproduk->produks()->count() > 0) {
        return back()->with('error', 'Kategori tidak dapat dihapus karena masih memiliki produk terkait!');
    }
        if ($kategoriproduk->img_kategori) {
        Storage::disk('public')->delete($kategoriproduk->img_kategori);
    }
        $kategoriproduk->delete();
        return redirect()->route('kategoriproduk.index')->with('success', 'Kategori produk berhasil dihapus!');
    }

    public function chekSlug(Request $request)
    {
        $slug = SlugService::createSlug(KategoriProduk::class, 'slug', $request->nama );
        return response()->json(['slug' => $slug]);
    }

}

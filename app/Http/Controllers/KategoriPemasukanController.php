<?php

namespace App\Http\Controllers;

use App\Models\KategoriPemasukan;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use \Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Validation\Rule;

class KategoriPemasukanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.pemasukan.kategoripemasukan', [
            'title' => 'Kategori Pemasukan',
            'kategoris' => KategoriPemasukan::latest()->paginate(15),
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
        $validated = $request->validate([
            'nama' => 'required|max:255|unique:kategori_pemasukans',
            'slug' => 'required|max:255|unique:kategori_pemasukans',
            'deskripsi' => 'nullable|string',
            'status' => 'nullable|boolean',
        ]);

        $dataToStore = [
            'nama' => $validated['nama'],
            'slug' => $validated['slug'],
            'deskripsi' => $validated['deskripsi'] ?? null,
            'status' => $request->has('status'),
        ];

        KategoriPemasukan::create($dataToStore);
        Alert::success('Berhasil', 'Kategori Pemasukan Baru Berhasil Ditambahkan!');
        return redirect()->route('kategoripemasukan.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(KategoriPemasukan $kategoripemasukan)
    {
        //
    }

    public function getKategoriJson(KategoriPemasukan $kategoripemasukan)
    {
        return response()->json($kategoripemasukan);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(KategoriPemasukan $kategoripemasukan)
    {
        return redirect()->route('kategoripemasukan.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, KategoriPemasukan $kategoripemasukan)
    {
        $validated = $request->validate([
            'nama' => ['required', 'max:255', Rule::unique('kategori_pemasukans')->ignore($kategoripemasukan->id)],
            'slug' => ['required', 'max:255', Rule::unique('kategori_pemasukans')->ignore($kategoripemasukan->id)],
            'deskripsi' => 'nullable|string',
            'status' => 'nullable|boolean',
        ]);

        $dataToUpdate = [
            'nama' => $validated['nama'],
            'slug' => $validated['slug'],
            'deskripsi' => $validated['deskripsi'] ?? null,
            'status' => $request->has('status')
        ];
        $kategoripemasukan->update($dataToUpdate);
        Alert::success('Berhasil', 'Kategori Pemasukan Berhasil Diperbarui!');
        return redirect()->route('kategoripemasukan.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(KategoriPemasukan $kategoripemasukan)
    {
        if ($kategoripemasukan->pemasukans()->count() > 0) {
        Alert::error('Gagal', 'Kategori Pemasukan Tidak Dapat Dihapus Karena Masih Memiliki Transaksi Terkait!');
        return back();
    }
        $kategoripemasukan->delete();
        Alert::success('Berhasil', 'Kategori Pemasukan Berhasil Dihapus!');
        return redirect()->route('kategoripemasukan.index');
    }

    public function chekSlug(Request $request)
    {
        $slug = SlugService::createSlug(KategoriPemasukan::class, 'slug', $request->nama );
        return response()->json(['slug' => $slug]);
    }
}

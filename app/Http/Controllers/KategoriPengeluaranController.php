<?php

namespace App\Http\Controllers;

use App\Models\KategoriPengeluaran;
use Illuminate\Http\Request;
use \Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Validation\Rule;

class KategoriPengeluaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.pengeluaran.kategoripengeluaran',[
            'title' => 'Kategori Pengeluaran',
            'kategoris' => KategoriPengeluaran::latest()->paginate(15)
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
            'nama' => 'required|max:255|unique:kategori_pengeluarans',
            'slug' => 'required|max:255|unique:kategori_pengeluarans',
            'deskripsi' => 'nullable|string',
            'status' => 'nullable|boolean',
        ]);

        $dataToStore = [
            'nama' => $validated['nama'],
            'slug' => $validated['slug'],
            'deskripsi' => $validated['deskripsi'] ?? null,
            'status' => $request->has('status'),
        ];

        KategoriPengeluaran::create($dataToStore);
        return redirect('/kategoripengeluaran')->with('success', 'Pembuatan Kategori Pengeluaran Baru Berhasil!');
    }

    /**
     * Display the specified resource.
     */
    public function show(KategoriPengeluaran $kategoripengeluaran)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function getKategoriJson(KategoriPengeluaran $kategoripengeluaran)
    {
        return response()->json($kategoripengeluaran);
    }

    public function edit(KategoriPengeluaran $kategoripengeluaran)
    {
        return redirect()->route('kategoripengeluaran.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, KategoriPengeluaran $kategoripengeluaran)
    {
        $validated = $request->validate([
            'nama' => ['required', 'max:255', Rule::unique('kategori_pengeluarans')->ignore($kategoripengeluaran->id)],
            'slug' => ['required', 'max:255', Rule::unique('kategori_pengeluarans')->ignore($kategoripengeluaran->id)],
            'deskripsi' => 'nullable|string',
            'status' => 'nullable|boolean',
        ]);

        $dataToUpdate = [
            'nama' => $validated['nama'],
            'slug' => $validated['slug'],
            'deskripsi' => $validated['deskripsi'] ?? null,
            'status' => $request->has('status')
        ];
        $kategoripengeluaran->update($dataToUpdate);
        return redirect()->route('kategoripengeluaran.index')->with('success', 'Kategori Pengeluaran Berhasil Diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(KategoriPengeluaran $kategoripengeluaran)
    {
        if ($kategoripengeluaran->pengeluarans()->count() > 0) {
        return back()->with('error', 'Kategori Tidak Dapat Dihapus Karena Masih Memiliki Transaksi Terkait!');
    }
        $kategoripengeluaran->delete();
        return redirect()->route('kategoripengeluaran.index')->with('success', 'Kategori Pengeluaran Berhasil Dihapus!');
    }

    public function chekSlug(Request $request)
    {
        $slug = SlugService::createSlug(KategoriPengeluaran::class, 'slug', $request->nama );
        return response()->json(['slug' => $slug]);
    }
}

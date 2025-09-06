<?php

namespace App\Http\Controllers;

use App\Models\KategoriPengeluaran;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
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
        Alert::success('Berhasil', 'Kategori Pengeluaran Baru Berhasil Ditambahkan!');
        return redirect()->route('kategoripengeluaran.index');
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
        //
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
        Alert::success('Berhasil', 'Kategori Pengeluaran Berhasil Diperbarui!');
        return redirect()->route('kategoripengeluaran.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(KategoriPengeluaran $kategoripengeluaran)
    {
        if ($kategoripengeluaran->pengeluarans()->count() > 0) {
            Alert::error('Gagal', 'Kategori Pengeluaran Tidak Dapat Dihapus Karena Masih Memiliki Transaksi Terkait!');
            return back();
    }
        $kategoripengeluaran->delete();
        Alert::success('Berhasil', 'Kategori Pengeluaran Berhasil Dihapus!');
        return redirect()->route('kategoripengeluaran.index');
    }

    public function chekSlug(Request $request)
    {
        $slug = SlugService::createSlug(KategoriPengeluaran::class, 'slug', $request->nama );
        return response()->json(['slug' => $slug]);
    }
}

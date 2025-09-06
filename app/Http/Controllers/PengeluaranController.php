<?php

namespace App\Http\Controllers;

use App\Models\pengeluaran;
use Illuminate\Http\Request;
use App\Models\KategoriPengeluaran;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class PengeluaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.pengeluaran.index',[
            'title' => 'Pengeluaran',
            'pengeluarans' => Pengeluaran::latest()->paginate(15),
            'kategoris' => KategoriPengeluaran::all()
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
        $validateData = $request->validate([
            'kategori_pengeluaran_id' => 'required|exists:kategori_pengeluarans,id',
            'tanggal' => 'required|date_format:Y-m-d|before_or_equal:today',
            'jumlah' => 'required|numeric|min:0',
            'referensi' => 'nullable|string|max:100|unique:pengeluarans',
            'keterangan' => 'required|string|max:255',
            'deskripsi' => 'nullable|string|max:1000',
        ]);

        $validateData['user_id'] = Auth::id();

        Pengeluaran::create($validateData);
        Alert::success('Berhasil', 'Pengeluaran baru berhasil ditambahkan!');
        return redirect()->route('pengeluaran.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pengeluaran $pengeluaran)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pengeluaran $pengeluaran)
    {
        //
    }

    public function getjson(Pengeluaran $pengeluaran)
    {
        return response()->json($pengeluaran);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pengeluaran $pengeluaran)
    {
        $rules = [
            'kategori_pengeluaran_id' => 'required|exists:kategori_pengeluarans,id',
            'tanggal' => 'required|date_format:Y-m-d|before_or_equal:today',
            'jumlah' => 'required|numeric|min:0',
            'referensi' => ['nullable', 'string', 'max:100', Rule::unique('pengeluarans')->ignore($pengeluaran->id)],
            'keterangan' => 'required|string|max:255',
            'deskripsi' => 'nullable|string|max:1000',
        ];

        $validateData = $request->validate($rules);
        $validateData['user_id'] = Auth::id();

        $pengeluaran->update($validateData);
        Alert::success('Berhasil', 'Pengeluaran Berhasil Diperbarui!');
        return redirect()->route('pengeluaran.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pengeluaran $pengeluaran)
    {
        $pengeluaran->delete();
        Alert::success('Berhasil', 'Pengeluaran Berhasil Dihapus!');
        return redirect()->route('pengeluaran.index');
    }
}

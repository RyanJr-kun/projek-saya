<?php

namespace App\Http\Controllers;

use App\Models\Pemasukan;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\KategoriPemasukan;
use Illuminate\Support\Facades\Auth;

class PemasukanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.pemasukan.index', [
        'title' => 'Pemasukan',
        'pemasukans' => Pemasukan::latest()->paginate(15),
        'kategoris' => KategoriPemasukan::all()
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
            'kategori_pemasukan_id' => 'required|exists:kategori_pemasukans,id',
            'tanggal' => 'required|date_format:Y-m-d|before_or_equal:today',
            'jumlah' => 'required|numeric|min:0',
            'referensi' => 'nullable|string|max:100|unique:pemasukans',
            'keterangan' => 'required|string|max:255',
            'deskripsi' => 'nullable|string|max:1000',
        ]);

        $validateData['user_id'] = Auth::id();

        Pemasukan::create($validateData);
        Alert::success('Berhasil', 'Pemasukan baru berhasil ditambahkan!');
        return redirect()->route('pemasukan.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pemasukan $pemasukan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pemasukan $pemasukan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function getjson(Pemasukan $pemasukan)
    {
        return response()->json($pemasukan);
    }

    public function update(Request $request, Pemasukan $pemasukan)
    {
        $rules = [
            'kategori_pemasukan_id' => 'required|exists:kategori_pemasukans,id',
            'tanggal' => 'required|date_format:Y-m-d|before_or_equal:today',
            'jumlah' => 'required|numeric|min:0',
            'referensi' => ['nullable', 'string', 'max:100', Rule::unique('pemasukans')->ignore($pemasukan->id)],
            'keterangan' => 'required|string|max:255',
            'deskripsi' => 'nullable|string|max:1000',
        ];

        $validateData = $request->validate($rules);
        $validateData['user_id'] = Auth::id();

        $pemasukan->update($validateData);
        Alert::success('Berhasil', 'Pemasukan Berhasil Diperbarui!');
        return redirect()->route('pemasukan.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pemasukan $pemasukan)
    {
        $pemasukan->delete();
        Alert::success('Berhasil', 'Pemasukan Berhasil Dihapus!');
        return redirect()->route('pemasukan.index');
    }
}

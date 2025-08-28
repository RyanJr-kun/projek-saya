<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PelangganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.penjualan.pelanggan',[
            'title' => 'Pelanggan',
            'pelanggans' => Pelanggan::latest()->paginate('15')
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
            'nama' => 'required|string|max:255|unique:pelanggans',
            'kontak' => 'required|string|max:20|unique:pelanggans',
            'email' => 'nullable|email|unique:pelanggans',
            'alamat' => 'nullable|string',
        ]);

        $validatedData['status'] = $request->boolean('status');

        Pelanggan::create($validatedData);
        return redirect()->route('pelanggan.index')->with('success', 'Pelanggan baru berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pelanggan $pelanggan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pelanggan $pelanggan)
    {
        //
    }

    public function getjson(Pelanggan $pelanggan)
    {
        return response()->json($pelanggan);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pelanggan $pelanggan)
    {
        $rules = [
            'nama' => ['required', 'string', 'max:255', Rule::unique('pelanggans')->ignore($pelanggan->id)],
            'kontak' => ['required', 'string', 'max:20', Rule::unique('pelanggans', 'kontak')->ignore($pelanggan->id)],
            'email' => ['nullable', 'email', Rule::unique('pelanggans', 'email')->ignore($pelanggan->id)],
            'alamat' => 'nullable|string',
        ];

        $validatedData = $request->validate($rules);
        $validatedData['status'] = $request->boolean('status'); 

        $pelanggan->update($validatedData);
        return redirect()->route('pelanggan.index')->with('success', 'Data pelanggan berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pelanggan $pelanggan)
    {
       // Periksa apakah ada transaksi penjualan yang terkait dengan pelanggan ini
        if ($pelanggan->penjualans()->count() > 0) {
            return back()->with('error', 'Pelanggan tidak dapat dihapus karena masih memiliki transaksi penjualan terkait!');
        }

        $pelanggan->delete();
        return redirect()->route('pelanggan.index')->with('success', 'Pelanggan berhasil dihapus!');

    }
}

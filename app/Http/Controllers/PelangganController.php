<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
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

        if ($request->wantsJson()) {
            $validatedData['status'] = true;
        } else {
            $validatedData['status'] = $request->boolean('status');
        }

        $pelanggan = Pelanggan::create($validatedData);

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Pelanggan baru berhasil ditambahkan!',
                'pelanggan' => $pelanggan
            ], 201);
        }
        Alert::success('Berhasil', 'Pelanggan baru berhasil ditambahkan!');
        return redirect()->route('pelanggan.index');
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
        Alert::success('Berhasil', 'Data pelanggan berhasil diperbarui!');
        return redirect()->route('pelanggan.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pelanggan $pelanggan)
    {
        if ($pelanggan->penjualans()->count() > 0) {
            Alert::error('Gagal', 'Pelanggan tidak dapat dihapus karena masih memiliki transaksi penjualan terkait!');
            return back();
        }

        $pelanggan->delete();
        Alert::success('Berhasil', 'Pelanggan berhasil dihapus!');
        return redirect()->route('pelanggan.index');
    }
}

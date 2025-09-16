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
            'nama' => 'required|string|max:255|unique:pelanggans,nama',
            'kontak' => 'required|string|max:20|unique:pelanggans,kontak',
            'email' => 'nullable|email|unique:pelanggans,email',
            'alamat' => 'nullable|string',
        ]);

        $validatedData['status'] = $request->has('status');
        $pelanggan = Pelanggan::create($validatedData);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'pelanggan baru berhasil ditambahkan!',
                'data'    => $pelanggan
            ], 201);
        }

        Alert::success('Berhasil', 'pelanggan baru berhasil ditambahkan!');
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
    public function destroy(Request $request, Pelanggan $pelanggan)
    {
        if ($pelanggan->penjualans()->count() > 0) {
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Pelanggan tidak dapat dihapus karena masih memiliki transaksi penjualan terkait!'
                ], 422); // 422 Unprocessable Entity
            }
            Alert::error('Gagal', 'Pelanggan tidak dapat dihapus karena masih memiliki transaksi penjualan terkait!');
            return back();
        }

        $pelanggan->delete();

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Pelanggan berhasil dihapus!'
            ]);
        }

        Alert::success('Berhasil', 'Pelanggan berhasil dihapus!');
        return redirect()->route('pelanggan.index');
    }
}

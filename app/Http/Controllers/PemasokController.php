<?php

namespace App\Http\Controllers;

use Illuminate\Validation\Rule; // Import Rule untuk validasi unique saat update
use App\Models\Pemasok;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;

class PemasokController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.pembelian.pemasok',[
            'title' => 'Pemasok',
            'pemasoks' => Pemasok::latest()->paginate(10),
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
            'nama' => 'required|string|max:255',
            'perusahaan' => 'required|string|max:255',
            'kontak' => 'required|string|max:20|unique:pemasoks,kontak',
            'email' => 'nullable|email|unique:pemasoks,email',
            'alamat' => 'nullable|string',
            'note' => 'nullable|string',
            'status' => 'nullable|boolean',
        ]);

        $validatedData['status'] = $request->has('status');
        $pemasok = Pemasok::create($validatedData);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Pemasok baru berhasil ditambahkan!',
                'data'    => $pemasok
            ], 201);
        }

        Alert::success('Berhasil', 'Pemasok baru berhasil ditambahkan!');
        return redirect()->route('pemasok.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pemasok $pemasok)
    {
        //
    }

    /**
     * Get JSON data for a specific resource.
     * Digunakan oleh modal edit untuk mengisi form.
     */
    public function getjson(Pemasok $pemasok)
    {
        return response()->json($pemasok);
    }

    /**
     * Show the form for editing the specified resource.
     * Karena edit ditangani oleh modal di halaman index, metode ini hanya redirect.
     */
    public function edit(Pemasok $pemasok)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pemasok $pemasok)
    {
        $rules = [
            'nama' => 'required|string|max:255',
            'perusahaan' => 'required|string|max:255',
            'kontak' => ['required', 'string', 'max:20', Rule::unique('pemasoks', 'kontak')->ignore($pemasok->id)],
            'email' => ['nullable', 'email', Rule::unique('pemasoks', 'email')->ignore($pemasok->id)],
            'alamat' => 'nullable|string',
            'status' => 'nullable|boolean',
            'note' => 'nullable|string',
        ];

        $validatedData = $request->validate($rules);
        $validatedData['status'] = $request->has('status');

        $pemasok->update($validatedData);
        Alert::success('Berhasil', 'Data pemasok berhasil diperbarui!');
        return redirect()->route('pemasok.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pemasok $pemasok)
    {
        // Periksa apakah ada transaksi pembelian yang terkait dengan pemasok ini
        if ($pemasok->pembelians()->count() > 0) {
            Alert::error('Gagal', 'Pemasok tidak dapat dihapus karena masih memiliki transaksi pembelian terkait!');
            return back();
        }

        $pemasok->delete();
        Alert::success('Berhasil', 'Pemasok berhasil dihapus!');
        return redirect()->route('pemasok.index');
    }
}

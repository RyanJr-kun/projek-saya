<?php

namespace App\Http\Controllers;

use App\Models\Garansi;
use Illuminate\Http\Request;
use \Cviebrock\EloquentSluggable\Services\SlugService;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Validation\Rule;

class GaransiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.inventaris.garansi',[
        'title' => 'garansi',
        'garansis' => Garansi::latest()->paginate(15)
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
        // Validasi semua input dari form create
        $validated = $request->validate([
            'nama' => 'required|string|max:100|unique:garansis',
            'slug' => 'required|string|max:100|unique:garansis',
            'durasi' => 'required|integer|min:1',
            'period' => 'required|string|in:Month,Year',
            'deskripsi' => 'nullable|string',
            'status' => 'nullable|boolean',
        ]);

        // Kalkulasi total bulan
        $totalMonths = $validated['durasi'];
        if ($validated['period'] === 'Year') {
            $totalMonths = $validated['durasi'] * 12;
        }

        // Siapkan data untuk disimpan, termasuk slug
        $dataToStore = [
            'nama' => $validated['nama'],
            'slug' => $validated['slug'],
            'deskripsi' => $validated['deskripsi'] ?? null,
            'status' => $request->has('status'),
            'durasi' => $totalMonths,
        ];

        Garansi::create($dataToStore);
        Alert::success('Berhasil', 'Garansi Baru Berhasil Ditambahkan.');
        return redirect()->route('garansi.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Garansi $garansi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function getGaransiJson(Garansi $garansi)
    {
        return response()->json($garansi);
    }

    public function edit(Garansi $garansi)
    {
        return redirect()->route('garansi.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Garansi $garansi)
    {
        // Validasi untuk update
        $validated = $request->validate([
            'nama' => ['required', 'max:255', Rule::unique('garansis')->ignore($garansi->id)],
            'slug' => ['required', 'max:255', Rule::unique('garansis')->ignore($garansi->id)],
            'durasi' => 'required|integer|min:1',
            'period' => 'required|string|in:Month,Year',
            'deskripsi' => 'nullable|string',
            'status' => 'nullable|boolean',
        ]);

        // Kalkulasi ulang total bulan
        $totalMonths = $validated['durasi'];
        if ($validated['period'] === 'Year') {
            $totalMonths = $validated['durasi'] * 12;
        }

        // Siapkan data untuk diupdate
        $dataToUpdate = [
            'nama' => $validated['nama'],
            'slug' => $validated['slug'],
            'deskripsi' => $validated['deskripsi'] ?? null,
            'status' => $request->has('status'),
            'durasi' => $totalMonths,
        ];

        $garansi->update($dataToUpdate);
        Alert::success('Berhasil', 'Garansi Berhasil Diperbarui.');
        return redirect()->route('garansi.index');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Garansi $garansi)
    {
        if ($garansi->produks()->count() > 0) {
        Alert::error('Gagal', 'Garansi tidak dapat dihapus karena masih memiliki produk terkait!');
        return back();
    }
        $garansi->delete();
        Alert::success('Berhasil', 'Garansi Berhasil Dihapus.');
        return redirect()->route('garansi.index');
    }

    public function chekSlug(Request $request)
    {
        $slug = SlugService::createSlug(Garansi::class, 'slug', $request->nama );
        return response()->json(['slug' => $slug]);
    }
}

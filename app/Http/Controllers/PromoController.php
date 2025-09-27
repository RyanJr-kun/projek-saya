<?php

namespace App\Http\Controllers;

use App\Models\Promo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Validation\Rule;

class PromoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Promo::with('user')->latest();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('nama_promo', 'like', "%{$search}%")
                  ->orWhere('kode_promo', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $promos = $query->paginate(10)->withQueryString();

        if ($request->ajax()) {
            return view('dashboard.promo._promo_table', compact('promos'))->render();
        }

        return view('dashboard.promo.index', [
            'title' => 'Manajemen Promo & Diskon',
            'promos' => $promos,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.promo.create', [
            'title' => 'Buat Promo Baru',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_promo' => 'required|string|max:255',
            'kode_promo' => 'nullable|string|max:50|unique:promos,kode_promo',
            'tipe_diskon' => 'required|in:percentage,fixed',
            'nilai_diskon' => 'required|numeric|min:0',
            'min_pembelian' => 'nullable|numeric|min:0',
            'max_diskon' => 'nullable|numeric|min:0',
            'tanggal_mulai' => 'required|date',
            'tanggal_berakhir' => 'required|date|after_or_equal:tanggal_mulai',
            'status' => 'nullable|boolean',
            'deskripsi' => 'nullable|string',
        ]);

        $validatedData['user_id'] = Auth::id();
        $validatedData['status'] = $request->has('status');

        Promo::create($validatedData);

        Alert::success('Berhasil', 'Promo baru berhasil ditambahkan!');
        return redirect()->route('promo.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Promo $promo)
    {
        return view('dashboard.promo.show', [
            'title' => 'Detail Promo: ' . $promo->nama_promo,
            'promo' => $promo->load('user'),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Promo $promo)
    {
        return view('dashboard.promo.edit', [
            'title' => 'Edit Promo: ' . $promo->nama_promo,
            'promo' => $promo,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Promo $promo)
    {
        $validatedData = $request->validate([
            'nama_promo' => 'required|string|max:255',
            'kode_promo' => ['nullable', 'string', 'max:50', Rule::unique('promos', 'kode_promo')->ignore($promo->id)],
            'tipe_diskon' => 'required|in:percentage,fixed',
            'nilai_diskon' => 'required|numeric|min:0',
            'min_pembelian' => 'nullable|numeric|min:0',
            'max_diskon' => 'nullable|numeric|min:0',
            'tanggal_mulai' => 'required|date',
            'tanggal_berakhir' => 'required|date|after_or_equal:tanggal_mulai',
            'status' => 'nullable|boolean',
            'deskripsi' => 'nullable|string',
        ]);

        $validatedData['user_id'] = Auth::id();
        $validatedData['status'] = $request->has('status');

        $promo->update($validatedData);

        Alert::success('Berhasil', 'Promo berhasil diperbarui!');
        return redirect()->route('promo.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Promo $promo)
    {
        try {
            $promo->delete();
            Alert::success('Berhasil', 'Promo berhasil dihapus!');
            return redirect()->route('promo.index');
        } catch (\Exception $e) {
            Alert::error('Gagal', 'Terjadi kesalahan saat menghapus promo: ' . $e->getMessage());
            return back();
        }
    }

    /**
     * Get JSON data for a specific resource.
     */
    public function getJson(Promo $promo)
    {
        return response()->json($promo);
    }
}

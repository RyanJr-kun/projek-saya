<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use \Cviebrock\EloquentSluggable\Services\SlugService;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.inventaris.unit', [
            'title'=>'Units',
            'units' => Unit::withCount('produks')->paginate(15)
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
        'nama' => 'required|max:255|unique:units',
        'slug' => 'required|max:255|unique:units',
        'singkat' => 'required|max:255|unique:units',
        'status' => 'nullable|boolean',
        ]);

        $validatedData['status'] = $request->has('status');

        Unit::create($validatedData);
        return redirect('/unit')->with('success', 'Pembuatan Data Unit baru berhasil!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Unit $unit)
    {
        //
    }

    public function getUnitJson(Unit $unit)
    {
        return response()->json($unit);
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Unit $unit)
    {
        return redirect()->route('unit.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Unit $unit)
    {
        $rules = [

            'nama' => ['required', 'max:255', Rule::unique('units')->ignore($unit->id)],
            'slug' => ['required', 'max:255', Rule::unique('units')->ignore($unit->id)],
            'singkat' => ['required', 'max:255', Rule::unique('units')->ignore($unit->id)],
            'status' => 'nullable|boolean',
        ];

        $validatedData = $request->validate($rules);
        $validatedData['status'] = $request->has('status');

        $unit->update($validatedData);
        return redirect()->route('unit.index')->with('success', 'Data Unit Berhasil Diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Unit $unit)
    {
        if ($unit->produks()->count() > 0) {
        return back()->with('error', 'Unit tidak dapat dihapus karena masih memiliki produk terkait!');
    }
        $unit->delete();
        return redirect()->route('unit.index')->with('success', 'Data Unit berhasil dihapus!');
    }

    public function chekSlug(Request $request)
    {
        $slug = SlugService::createSlug(Unit::class, 'slug', $request->nama );
        return response()->json(['slug' => $slug]);
    }
}

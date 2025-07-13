<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // Di dalam Controller Anda, saat mengambil semua unit


    // Sekarang setiap unit akan punya properti baru bernama 'produks_count'
    public function index()
    {
        return view('inventaris.unit', [
            'title'=>'Units',
            'units' => Unit::withCount('produks')->get()
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Unit $units)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Unit $units)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Unit $units)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Unit $units)
    {
        //
    }
}

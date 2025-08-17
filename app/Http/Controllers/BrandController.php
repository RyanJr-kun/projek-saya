<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use \Cviebrock\EloquentSluggable\Services\SlugService;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.inventaris.brand',[
            'title' => 'Data Brand',
            'brands' => Brand::withCount('produks')->latest()->paginate(10)
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
        'img_brand' => 'nullable|image|mimes:jpeg,png|max:1024',
        'nama' => 'required|max:255|unique:brands',
        'slug' => 'required|max:255|unique:brands',
        'status' => 'nullable|boolean',
        ]);

        if ($request->file('img_brand')) {
        $path = $request->file('img_brand')->store('brand-images', 'public');
        $validatedData['img_brand'] = $path;
        }

        $validatedData['status'] = $request->has('status');

        Brand::create($validatedData);
        return redirect('/brand')->with('success', 'Pembuatan Data Brand baru berhasil!');
    }
    /**
     * Display the specified resource.
     */
    public function show(Brand $brand)
    {
        //
    }

    public function getBrandJson(Brand $brand)
    {
        return response()->json($brand);
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Brand $brand)
    {
        return redirect()->route('brand.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Brand $brand)
    {
        $rules = [
            'img_brand' => 'nullable|image|mimes:jpeg,png,jpg|max:1024',
            'nama' => ['required', 'max:255', Rule::unique('brands')->ignore($brand->id)],
            'slug' => ['required', 'max:255', Rule::unique('brands')->ignore($brand->id)],
            'status' => 'nullable|boolean',
        ];

        $validatedData = $request->validate($rules);
        if ($request->file('img_brand')) {
            if ($brand->img_brand) {
                Storage::disk('public')->delete($brand->img_brand);
            }
            $path = $request->file('img_brand')->store('brand-images', 'public');
            $validatedData['img_brand'] = $path;
        }
        $validatedData['status'] = $request->has('status');

        $brand->update($validatedData);
        return redirect()->route('brand.index')->with('success', 'Data Brand Berhasil Diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Brand $brand)
    {
        if ($brand->produks()->count() > 0) {
        return back()->with('error', 'brand tidak dapat dihapus karena masih memiliki produk terkait!');
    }
        if ($brand->img_brand) {
        Storage::disk('public')->delete($brand->img_brand);
    }
        $brand->delete();
        return redirect()->route('brand.index')->with('success', 'Data Brand berhasil dihapus!');
    }

    public function chekSlug(Request $request)
    {
        $slug = SlugService::createSlug(Brand::class, 'slug', $request->nama );
        return response()->json(['slug' => $slug]);
    }

}

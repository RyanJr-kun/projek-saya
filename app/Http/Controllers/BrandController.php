<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
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
    // app/Http/Controllers/BrandController.php

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            // Menambahkan validasi untuk memastikan path gambar adalah dari FilePond
            'img_brand' => 'nullable|string|starts_with:tmp/',
            'nama' => 'required|max:255|unique:brands',
            'slug' => 'required|max:255|unique:brands',
            'status' => 'nullable|boolean',
        ]);

        // Jika ada file yang diunggah melalui FilePond
        if ($request->filled('img_brand')) {
            $sourcePath = $request->input('img_brand'); // Path dari folder tmp
            $fileName = basename($sourcePath);
            $destinationPath = 'brand-images/' . $fileName;

            // Pindahkan file dari tmp ke direktori tujuan
            if (Storage::disk('public')->exists($sourcePath)) {
                Storage::disk('public')->move($sourcePath, $destinationPath);
                $validatedData['img_brand'] = $destinationPath; // Simpan path baru
            } else {
                // Hapus path jika file tidak ditemukan untuk mencegah error
                unset($validatedData['img_brand']);
            }
        }

        $validatedData['status'] = $request->has('status');
        Brand::create($validatedData);
        Alert::success('Berhasil', 'Brand Baru Berhasil Ditambahkan.');

        if ($request->wantsJson()) {
            return response()->json(['message' => 'Brand created successfully.']);
        }

        return redirect()->route('brand.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Brand $brand)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Brand $brand)
    {
        //
    }

     public function getBrandJson(Brand $brand)
    {
        return response()->json($brand);
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, Brand $brand)
    {
        $rules = [
            'img_brand' => 'nullable|string',
            'nama' => ['required', 'max:255', Rule::unique('brands')->ignore($brand->id)],
            'slug' => ['required', 'max:255', Rule::unique('brands')->ignore($brand->id)],
            'status' => 'nullable|boolean',
        ];

        $validatedData = $request->validate($rules);

        // Cek apakah ada file baru yang diunggah
        if ($request->filled('img_brand')) {
            $sourcePath = $request->input('img_brand');

            // Pastikan ini adalah file baru dari tmp, bukan path file lama
            if (strpos($sourcePath, 'tmp/') === 0 && Storage::disk('public')->exists($sourcePath)) {
                // Hapus gambar lama jika ada
                if ($brand->img_brand) {
                    Storage::disk('public')->delete($brand->img_brand);
                }

                // Pindahkan gambar baru dari tmp ke lokasi permanen
                $fileName = basename($sourcePath);
                $destinationPath = 'brand-images/' . $fileName;
                Storage::disk('public')->move($sourcePath, $destinationPath);
                $validatedData['img_brand'] = $destinationPath;
            }
        // Menangani kasus jika pengguna menghapus gambar yang ada melalui FilePond
        } elseif ($request->exists('img_brand') && $request->input('img_brand') === null) {
            if ($brand->img_brand && Storage::disk('public')->exists($brand->img_brand)) {
                Storage::disk('public')->delete($brand->img_brand);
                $validatedData['img_brand'] = null;
            }
        }

        $validatedData['status'] = $request->has('status');
        $brand->update($validatedData);
        Alert::success('Berhasil', 'Data Brand Berhasil Diperbarui.');
        return redirect()->route('brand.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Brand $brand)
    {
        if ($brand->produks()->count() > 0) {
        Alert::error('Gagal','brand tidak dapat dihapus karena masih memiliki produk terkait!');
        return back();
    }
        if ($brand->img_brand) {
        Storage::disk('public')->delete($brand->img_brand);
    }
        $brand->delete();
        Alert::success('Berhasil', 'Data Brand Berhasil Dihapus.');
        return redirect()->route('brand.index');
    }

    public function chekSlug(Request $request)
    {
        $slug = SlugService::createSlug(Brand::class, 'slug', $request->nama );
        return response()->json(['slug' => $slug]);
    }

    /**
     * Menangani unggahan file sementara dari FilePond.
     */
    public function upload(Request $request)
    {
        if ($request->hasFile('img_brand')) {
            $request->validate([
                'img_brand' => 'required|image|mimes:jpeg,png,jpg,svg,webp|max:2048',
            ]);

            $file = $request->file('img_brand');
            // Simpan file ke direktori 'tmp' di dalam 'storage/app/public'
            $path = $file->store('tmp/brand-images', 'public');

            // Kembalikan path file sebagai plain text
            return $path;
        }

        // Jika tidak ada file, kembalikan response error
        return response()->json(['error' => 'No file uploaded.'], 400);
    }

    /**
     * Menangani pembatalan unggahan file dari FilePond.
     */
    public function revert(Request $request)
    {
        $filePath = $request->getContent();
        if ($filePath && Storage::disk('public')->exists($filePath)) {
            Storage::disk('public')->delete($filePath);
            return response()->noContent();
        }

        return response()->json(['error' => 'File not found.'], 404);
    }
}

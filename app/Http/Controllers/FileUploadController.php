<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FileUploadController extends Controller
{
    public function store(Request $request)
    {
        if ($request->hasFile('file')) {
            $request->validate([
                'file' => 'required|file|max:5120',
                'type' => 'required|string|in:produk,brand,kategori,avatar',
            ]);

            $type = $request->input('type');
            $file = $request->file('file');

            // Simpan file di subfolder berdasarkan tipenya, di dalam folder tmp
            // Contoh: storage/app/public/tmp/brand/xyz.jpg
            $path = $file->store("tmp/{$type}", 'public');
            return $path;
        }
        return response()->json(['error' => 'No file uploaded.'], 400);
    }
}

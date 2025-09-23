<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ProfilToko;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class ProfilTokoController extends Controller
{
    /**
     * Menampilkan form untuk mengedit profil toko.
     *
     * @return \Illuminate\View\View
     */
    public function edit()
    {
        // Menggunakan firstOrCreate untuk memastikan selalu ada data profil
        // dengan id = 1. Jika tidak ada, record baru akan dibuat dengan nilai default.
        $profil = ProfilToko::firstOrCreate(
            ['id' => 1],
            ['nama_toko' => 'Nama Toko Anda'] // Nilai default jika record baru dibuat
        );

        return view('dashboard.profil-toko', [
            'title' => 'Pengaturan Profil Toko',
            'profil' => $profil,
        ]);
    }

    /**
     * Memperbarui data profil toko.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'nama_toko' => 'required|string|max:100',
            'alamat' => 'nullable|string',
            'telepon' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:100',
            'logo' => 'nullable|string', // FilePond mengirim path, bukan file
        ]);

        // Cari profil toko, yang seharusnya selalu ada dengan id = 1
        $profil = ProfilToko::find(1);

        // Handle upload logo dari FilePond
        if ($request->filled('logo')) {
            $tempPath = $request->input('logo'); // Path dari file temp

            // Cek apakah file temp ada
            if (Storage::disk('public')->exists($tempPath)) {
                $newPath = 'profil-toko/' . basename($tempPath);

                // Pindahkan file dari temp ke direktori final
                Storage::disk('public')->move($tempPath, $newPath);

                // Hapus logo lama jika ada dan berbeda dari yang baru
                if ($profil->logo && $profil->logo !== $newPath && Storage::disk('public')->exists($profil->logo)) {
                    Storage::disk('public')->delete($profil->logo);
                }

                // Set path logo baru untuk diupdate
                $validatedData['logo'] = $newPath;
            }
        } else {
            // Jika input logo kosong (artinya logo dihapus di UI), hapus logo lama
            if ($profil->logo && Storage::disk('public')->exists($profil->logo)) {
                Storage::disk('public')->delete($profil->logo);
            }
            $validatedData['logo'] = null;
        }

        // Update data profil
        $profil->update($validatedData);

        Alert::success('Berhasil', 'Profil toko berhasil diperbarui.');
        return redirect()->route('pengaturan.profil-toko.edit');
    }

    /**
     * Menyimpan file yang diunggah sementara oleh FilePond.
     */
    public function upload(Request $request)
    {
        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('tmp/profil-toko', 'public');
            return $path;
        }
        return response()->json(['error' => 'No file uploaded.'], 400);
    }

    /**
     * Menghapus file yang diunggah sementara oleh FilePond.
     */
    public function revert(Request $request)
    {
        $filePath = $request->getContent();
        if ($filePath && Storage::disk('public')->exists($filePath)) {
            Storage::disk('public')->delete($filePath);
            return response()->json(['success' => true]);
        }
        return response()->json(['error' => 'File not found.'], 404);
    }
}

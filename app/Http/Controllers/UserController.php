<?php

namespace App\Http\Controllers;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.user.index', [
        'title'=>'Users',
        'users' => User::latest()->paginate(10),
        'roles' => Role::all()
    ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        return view('dashboard.user.create',[
            'roles' => Role::all()
        ]);
    }

    /**
     * nyetor data baru ke penyimpanan.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required|max:255',
            'username' => 'required|min:3|max:255|unique:users',
            'email' => 'required|email:dns|unique:users',
            'password' => 'required|min:5|max:255',
            'role_id' => ['required', Rule::exists('roles', 'id')],
            'kontak' => 'nullable|min:9|max:14|unique:users',
            'mulai_kerja' => 'required|date',
            'status' => 'required|boolean',
            'img_user' => 'nullable|image|mimes:jpeg,png|max:2048',
        ]);

        if ($request->file('img_user')) {
        // Simpan gambar ke folder public/storage/user-images
        $path = $request->file('img_user')->store('user-images', 'public');
        $validatedData['img_user'] = $path;
        }

        $validatedData['password'] = bcrypt($validatedData['password']);

        User::create($validatedData);
        return redirect('/users')->with('success', 'Pembuatan User Baru Berhasil!!');
    }

    /**
     * Display the specified resource. iki durung kangge bjir
     */
    public function show (user $user) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('dashboard.user.edit',[
            'user' => $user,
            'roles' => Role::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {

        $rules = [
            'nama' => 'required|max:255',
            'username' => ['required', 'min:3', 'max:255', Rule::unique('users')->ignore($user->id)],
            'email' => ['required', 'email:dns', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|min:5|max:255',
            'role_id' => ['required', Rule::exists('roles', 'id')],
            'kontak' => ['nullable', 'min:9', 'max:14', Rule::unique('users')->ignore($user->id)],
            'mulai_kerja' => 'required|date',
            'status' => 'required|boolean',
            'img_user' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ];

        $validatedData['status'] = $request->has('status') ? 1 : 0;
        $validatedData = $request->validate($rules);
        if ($request->file('img_user')) {
            if ($user->img_user) {
                Storage::disk('public')->delete($user->img_user);
            }
            $path = $request->file('img_user')->store('user-images', 'public');
            $validatedData['img_user'] = $path;
        }

        if ($request->filled('password')) {
            $validatedData['password'] = bcrypt($validatedData['password']);
        } else {
            unset($validatedData['password']);
        }
        $user->update($validatedData);
        return redirect('/users')->with('success', 'Data User Berhasil Diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
         if ($user->img_user) {
        Storage::disk('public')->delete($user->img_user);
         }
        $user->delete();
        return redirect()->route('users.index')->with('success', 'Data Pengguna berhasil dihapus!');
    }
}

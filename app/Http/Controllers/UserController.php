<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('users', [
        'title'=>'users',
        'users' => User::latest()->get()
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
     * nyetor data baru ke penyimpanan.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required|max:255',
            'username' => 'required|min:3|max:255|unique:users',
            'email' => 'required|email:dns|unique:users',
            'password' => 'required|min:5|max:255',
            'role_id' => 'required|in:1,2',
            'kontak' => 'nullable|min:9|max:14|unique:users',

        ]);
        $validatedData['password'] = bcrypt($validatedData['password']);
        User::create($validatedData);
        // $request->session()->flash('success', 'Pembuatan User Baru Berhasil!!' );
        return redirect('/users')->with('success', 'Pembuatan User Baru Berhasil!!');
    }

    /**
     * Display the specified resource. iki durung kangge bjir
     */
    public function show (user $user) {
        return view('profile',[
        'title' => 'Single user',
        'user' => $user
    ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
     public function run(): void
    {
        // Membuat user Admin secara spesifik
        User::create([
            'nama' => 'Administrator',
            'username' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('Admin361'),
            'role_id' => 1, // 1 = Admin
        ]);

        // Membuat user Kasir secara spesifik
        User::create([
            'nama' => 'Kasir Staff',
            'username' => 'kasir',
            'email' => 'kasir@gmail.com',
            'password' => Hash::make('Kasir361'),
            'role_id' => 2, // 2 = Kasir
        ]);
    }
}

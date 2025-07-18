<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
     public function run(): void
    {
        Role::firstOrCreate(['nama' => 'admin']);
        Role::firstOrCreate(['nama' => 'kasir']);
    }
}

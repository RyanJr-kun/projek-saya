<?php

namespace Database\Seeders;

use App\Models\Unit;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Unit::query()->delete();

        $units = [
            // Satuan Umum & Kemasan
            ['nama' => 'Pieces', 'singkat' => 'Pcs'],
            ['nama' => 'Unit', 'singkat' => 'Unit'],
            ['nama' => 'Set', 'singkat' => 'Set'],
            ['nama' => 'Box', 'singkat' => 'Box'],
            ['nama' => 'Dus', 'singkat' => 'Dus'],
            ['nama' => 'Pack', 'singkat' => 'Pack'],
            ['nama' => 'Roll', 'singkat' => 'Roll'],
            ['nama' => 'Lembar', 'singkat' => 'Lembar'],

            // Satuan Ukuran Fisik
            ['nama' => 'Milimeter', 'singkat' => 'mm'],
            ['nama' => 'Sentimeter', 'singkat' => 'cm'],
            ['nama' => 'Meter', 'singkat' => 'm'],
            ['nama' => 'Inci', 'singkat' => 'Inch'],
            ['nama' => 'Gram', 'singkat' => 'g'],
            ['nama' => 'Kilogram', 'singkat' => 'kg'],
        ];

        // Looping untuk memasukkan data ke database
        foreach ($units as $unit) {
            Unit::create([
                'nama' => $unit['nama'],
                'slug' => Str::slug($unit['nama'], '-'),
                'singkat' => $unit['singkat'],
            ]);
        }
    }
}

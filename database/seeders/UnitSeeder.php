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

            // Satuan Ukuran Data & Kecepatan
            ['nama' => 'Byte', 'singkat' => 'B'],
            ['nama' => 'Kilobyte', 'singkat' => 'KB'],
            ['nama' => 'Megabyte', 'singkat' => 'MB'],
            ['nama' => 'Gigabyte', 'singkat' => 'GB'],
            ['nama' => 'Terabyte', 'singkat' => 'TB'],
            ['nama' => 'Megabit per second', 'singkat' => 'Mbps'],
            ['nama' => 'Gigabit per second', 'singkat' => 'Gbps'],

            // Satuan Frekuensi (Processor, RAM)
            ['nama' => 'Hertz', 'singkat' => 'Hz'],
            ['nama' => 'Megahertz', 'singkat' => 'MHz'],
            ['nama' => 'Gigahertz', 'singkat' => 'GHz'],

            // Satuan Ukuran Fisik
            ['nama' => 'Milimeter', 'singkat' => 'mm'],
            ['nama' => 'Sentimeter', 'singkat' => 'cm'],
            ['nama' => 'Meter', 'singkat' => 'm'],
            ['nama' => 'Inci', 'singkat' => 'Inch'],
            ['nama' => 'Gram', 'singkat' => 'g'],
            ['nama' => 'Kilogram', 'singkat' => 'kg'],

            // Satuan Kelistrikan (PSU, Baterai, Komponen)
            ['nama' => 'Watt', 'singkat' => 'W'],
            ['nama' => 'Volt', 'singkat' => 'V'],
            ['nama' => 'Ampere', 'singkat' => 'A'],
            ['nama' => 'Milliampere Hour', 'singkat' => 'mAh'],
            ['nama' => 'Ohm', 'singkat' => 'Ω'],
            ['nama' => 'Kilowatt Hour', 'singkat' => 'kWh'],

            // Satuan Lainnya (Layar, Printer)
            ['nama' => 'Piksel', 'singkat' => 'Pixel'],
            ['nama' => 'Dot per Inch', 'singkat' => 'DPI'],
            ['nama' => 'Pages per Minute', 'singkat' => 'PPM'],
            ['nama' => 'Nits', 'singkat' => 'Nits'],
            ['nama' => 'Desibel', 'singkat' => 'dB'],
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

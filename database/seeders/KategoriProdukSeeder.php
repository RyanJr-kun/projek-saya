<?php

namespace Database\Seeders;

use App\Models\KategoriProduk; // Pastikan model ini sudah ada
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class KategoriProdukSeeder extends Seeder
{
    /**
     *
     * Run the database seeds.
     */
    public function run(): void
    {
        // Kosongkan tabel untuk eksekusi ulang seeder yang bersih
        KategoriProduk::query()->delete();

        $categories = [
            // == Komputer & Laptop ==
            'Laptop',
            'Laptop Gaming',
            'Laptop Ultrabook',
            'PC Desktop',
            'PC All-in-One (AIO)',
            'Mini PC',

            // == Komponen PC Inti ==
            'Processor (CPU)',
            'Motherboard',
            'VGA Card / Kartu Grafis',
            'RAM (Memory)',

            // == Penyimpanan Data ==
            'SSD Internal',
            'Hard Disk Internal (HDD)',
            'Penyimpanan Eksternal',
            'Flashdisk',
            'Memory Card',

            // == Casing & Daya ==
            'Casing Komputer',
            'Power Supply (PSU)',

            // == Pendingin Komputer ==
            'CPU Cooler',
            'Casing Fan',
            'Thermal Paste',

            // == Periferal Input ==
            'Keyboard',
            'Mouse',
            'Mousepad',
            'Webcam',
            'Microphone',
            'Drawing Tablet',

            // == Periferal Output ==
            'Monitor',
            'Printer',
            'Proyektor',
            'Speaker Komputer',
            'Headset & Headphone',

            // == Habis Pakai (Consumables) ==
            'Tinta Printer',
            'Toner Printer',
            'Kertas Printer',

            // == Aksesoris ==
            'Tas Laptop',
            'Cooling Pad Laptop',
            'USB Hub',
            'Card Reader',
            'UPS (Uninterruptible Power Supply)',
            'Stabilizer (Stavolt)',
            'Kabel Power & Adapter',
            'Kabel Display (HDMI, VGA)',

            // == Jaringan ==
            'Router',
            'Access Point',
            'Switch Hub',
            'Kabel LAN (UTP)',
            'USB WiFi Adapter',
            'Modem',

            // == Software ==
            'Sistem Operasi',
            'Antivirus',
            'Software Office',

            // == Gadget & Elektronik Lain ==
            'Smartphone',
            'Tablet',
            'Smartwatch',
            'Power Bank',
        ];

        // Urutkan kategori berdasarkan abjad
        sort($categories);

        foreach ($categories as $category) {
            KategoriProduk::create([
                'nama' => $category,
                'slug' => Str::slug($category),
                // 'status' otomatis true sesuai skema
            ]);
        }
    }
}

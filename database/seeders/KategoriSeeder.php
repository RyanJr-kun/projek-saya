<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use App\Models\KategoriTransaksi;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Kosongkan tabel untuk menghindari duplikasi saat seeder dijalankan ulang
        KategoriTransaksi::query()->delete();

        $categories = [
            // =================================================================
            // == KATEGORI PEMASUKAN ==
            // =================================================================

            [
                'nama' => 'Penjualan Aksesoris',
                'jenis' => 'pemasukan',
                'deskripsi' => 'Pemasukan dari penjualan mouse, keyboard, headset.',
            ],
            [
                'nama' => 'Penjualan Software',
                'jenis' => 'pemasukan',
                'deskripsi' => 'Pemasukan dari penjualan OS, Antivirus, aplikasi.',
            ],
            [
                'nama' => 'Jasa Servis',
                'jenis' => 'pemasukan',
                'deskripsi' => 'Pendapatan dari jasa perbaikan hardware & software.',
            ],
            [
                'nama' => 'Jasa Instalasi',
                'jenis' => 'pemasukan',
                'deskripsi' => 'Pendapatan dari jasa instalasi OS atau program.',
            ],
            [
                'nama' => 'Jasa Perakitan PC',
                'jenis' => 'pemasukan',
                'deskripsi' => 'Pendapatan dari jasa merakit komputer custom.',
            ],
            [
                'nama' => 'Penjualan Barang Bekas',
                'jenis' => 'pemasukan',
                'deskripsi' => 'Pemasukan dari penjualan komponen atau unit bekas.',
            ],
            [
                'nama' => 'Pendapatan Bunga Bank',
                'jenis' => 'pemasukan',
                'deskripsi' => 'Pemasukan non-operasional dari bunga simpanan bank.',
            ],

            // =================================================================
            // == KATEGORI PENGELUARAN ==
            // =================================================================
            [
                'nama' => 'Pembelian Stok Barang',
                'jenis' => 'pengeluaran',
                'deskripsi' => 'Pengeluaran untuk membeli barang dagangan dari pemasok.',
            ],
            [
                'nama' => 'Gaji Karyawan',
                'jenis' => 'pengeluaran',
                'deskripsi' => 'Pembayaran gaji bulanan untuk semua staf dan teknisi.',
            ],
            [
                'nama' => 'Biaya Listrik',
                'jenis' => 'pengeluaran',
                'deskripsi' => 'Pembayaran tagihan listrik bulanan untuk operasional.',
            ],
            [
                'nama' => 'Biaya Internet & Telepon',
                'jenis' => 'pengeluaran',
                'deskripsi' => 'Pembayaran tagihan internet dan telepon untuk toko.',
            ],
            [
                'nama' => 'Sewa Tempat Usaha',
                'jenis' => 'pengeluaran',
                'deskripsi' => 'Biaya sewa ruko atau gedung tempat usaha.',
            ],
            [
                'nama' => 'Biaya Pemasaran',
                'jenis' => 'pengeluaran',
                'deskripsi' => 'Pengeluaran untuk iklan online, brosur, dan promosi.',
            ],
            [
                'nama' => 'Pembelian Peralatan Toko',
                'jenis' => 'pengeluaran',
                'deskripsi' => 'Belanja aset seperti etalase, kursi, atau alat kasir.',
            ],
            [
                'nama' => 'Pembelian Peralatan Servis',
                'jenis' => 'pengeluaran',
                'deskripsi' => 'Belanja alat-alat untuk teknisi seperti solder, obeng.',
            ],
            [
                'nama' => 'Biaya Transportasi',
                'jenis' => 'pengeluaran',
                'deskripsi' => 'Pengeluaran untuk bensin atau pengiriman barang.',
            ],
            [
                'nama' => 'Alat Tulis Kantor (ATK)',
                'jenis' => 'pengeluaran',
                'deskripsi' => 'Pembelian kebutuhan kantor seperti kertas, tinta, pulpen.',
            ],
            [
                'nama' => 'Biaya Administrasi Bank',
                'jenis' => 'pengeluaran',
                'deskripsi' => 'Biaya bulanan yang dikenakan oleh pihak bank.',
            ],
            [
                'nama' => 'Pajak & Retribusi',
                'jenis' => 'pengeluaran',
                'deskripsi' => 'Pembayaran pajak usaha dan retribusi daerah.',
            ],
        ];

        foreach ($categories as $category) {
            KategoriTransaksi::create([
                'nama' => $category['nama'],
                'slug' => Str::slug($category['nama']),
                'jenis' => $category['jenis'],
                'deskripsi' => $category['deskripsi'],
            ]);
        }
    }
}

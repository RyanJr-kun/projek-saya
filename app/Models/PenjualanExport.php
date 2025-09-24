<?php

namespace App\Models;

use App\Models\Penjualan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Support\Carbon;

class PenjualanExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $penjualans;

    public function __construct($penjualans)
    {
        $this->penjualans = $penjualans;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->penjualans;
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'Tanggal',
            'Referensi',
            'Pelanggan',
            'Status Pembayaran',
            'Total',
            'Dibayar',
            'Sisa',
        ];
    }

    /**
     * @param Penjualan $penjualan
     * @return array
     */
    public function map($penjualan): array
    {
        return [
            Carbon::parse($penjualan->tanggal_penjualan)->format('d-m-Y'),
            $penjualan->referensi,
            $penjualan->pelanggan->nama ?? 'N/A',
            $penjualan->status_pembayaran,
            $penjualan->total_akhir,
            $penjualan->jumlah_dibayar,
            $penjualan->total_akhir - $penjualan->jumlah_dibayar,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true]],
        ];
    }
}

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 10px;
            color: #333;
        }
        .header-table {
            width: 100%;
            margin-bottom: 20px;
            border-collapse: collapse;
        }
        .header-table td {
            padding: 0;
            vertical-align: top;
        }
        .header-info h1 {
            margin: 0 0 5px 0;
            font-size: 18px;
            font-weight: bold;
        }
        .header-info p {
            margin: 0;
            font-size: 11px;
        }
        .report-title h2 {
            margin: 0;
            font-size: 16px;
            font-weight: bold;
        }
        .report-title p {
            margin: 2px 0;
            font-size: 11px;
        }
        .main-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        .main-table th, .main-table td {
            border: 1px solid #ddd;
            padding: 6px;
            text-align: left;
            vertical-align: top;
        }
        .main-table thead th {
            background-color: #f2f2f2;
            font-weight: bold;
            font-size: 9px;
            text-transform: uppercase;
        }
        .main-table tfoot td {
            font-weight: bold;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .text-danger { color: #D32F2F; }
        .font-weight-bold { font-weight: bold; }
        .footer {
            position: fixed;
            bottom: -20px;
            left: 0;
            right: 0;
            height: 40px;
            font-size: 9px;
            color: #777;
            text-align: center;
            line-height: 35px;
        }
        .page-number:before {
            content: "Halaman " counter(page);
        }
    </style>
</head>
<body>
    @include('dashboard.laporan.pdf._header')

    <main>
        <table class="main-table">
            <thead>
                <tr>
                    <th style="width: 10%;">Tanggal</th>
                    <th style="width: 15%;">Referensi</th>
                    <th>Pemasok</th>
                    <th class="text-center" style="width: 12%;">Status Bayar</th>
                    <th class="text-center" style="width: 12%;">Status Barang</th>
                    <th class="text-right" style="width: 15%;">Total</th>
                    <th class="text-right" style="width: 15%;">Sisa</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pembelians as $pembelian)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($pembelian->tanggal_pembelian)->translatedFormat('d M Y') }}</td>
                        <td>{{ $pembelian->referensi }}</td>
                        <td>{{ $pembelian->pemasok->nama ?? 'N/A' }}</td>
                        <td class="text-center">{{ $pembelian->status_pembayaran }}</td>
                        <td class="text-center">{{ $pembelian->status_barang }}</td>
                        <td class="text-right">@money($pembelian->total_akhir)</td>
                        <td class="text-right {{ $pembelian->sisa_pembayaran > 0 ? 'text-danger' : '' }}">@money($pembelian->sisa_pembayaran)</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">Tidak ada data pembelian yang ditemukan untuk periode ini.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </main>

    @include('dashboard.laporan.pdf._footer')
</body>
</html>

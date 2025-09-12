<x-layout>
    @push('styles')
        <style>
            @media print {
                body * {
                    visibility: hidden;
                }
                .printable-area, .printable-area * {
                    visibility: visible;
                }
                .printable-area {
                    position: absolute;
                    left: 0;
                    top: 0;
                    width: 100%;
                }
                .no-print {
                    display: none;
                }
            }
        </style>
    @endpush

    @section('breadcrumb')
        @php
            $breadcrumbItems = [
                ['name' => 'Dashboard', 'url' => '/dashboard'],
                ['name' => 'Daftar Invoice Pembelian', 'url' => route('pembelian.index')],
                ['name' => 'Detail Pembelian', 'url' => '#'],
            ];
        @endphp
        <x-breadcrumb :items="$breadcrumbItems" />
    @endsection

    <div class="container-fluid py-4">
        <div class="card printable-area">
            <div class="card-header d-flex justify-content-between align-items-center pb-0">
                <h5 class="mb-0">Detail Pembelian: {{ $pembelian->referensi }}</h5>
                <div class="no-print">
                    <a href="{{ route('pembelian.index') }}" class="btn btn-sm btn-outline-secondary mb-0">
                        <i class="bi bi-arrow-left me-1"></i> Kembali
                    </a>
                    <button onclick="window.print()" class="btn btn-sm btn-info mb-0">
                        <i class="bi bi-printer me-1"></i> Cetak
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-4">
                        <h6>Pemasok:</h6>
                        <p class="text-sm mb-1"><strong>Nama:</strong> {{ $pembelian->pemasok->nama ?? 'Pemasok Dihapus' }}</p>
                        <p class="text-sm mb-1"><strong>Kontak:</strong> {{ $pembelian->pemasok->kontak ?? '-' }}</p>
                        <p class="text-sm mb-0"><strong>Alamat:</strong> {{ $pembelian->pemasok->alamat ?? '-' }}</p>
                    </div>
                    <div class="col-md-4 mt-3 mt-md-0">
                        <h6>Dibuat Oleh:</h6>
                        <p class="text-sm mb-1"><strong>Nama:</strong> {{ $pembelian->user->name ?? 'User Dihapus' }}</p>
                        <p class="text-sm mb-0"><strong>Email:</strong> {{ $pembelian->user->email ?? '-' }}</p>
                    </div>
                    <div class="col-md-4 text-md-end mt-3 mt-md-0">
                        <h6>Informasi Transaksi:</h6>
                        <p class="text-sm mb-1"><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($pembelian->tanggal_pembelian)->translatedFormat('d F Y') }}</p>
                        <p class="text-sm mb-1"><strong>Status Barang:</strong>
                            <span class="badge badge-sm {{ $pembelian->status_barang == 'Diterima' ? 'bg-gradient-success' : 'bg-gradient-warning' }}">
                                {{ $pembelian->status_barang }}
                            </span>
                        </p>
                        <p class="text-sm mb-0"><strong>Status Bayar:</strong>
                            @php
                                $statusClass = '';
                                if ($pembelian->status_pembayaran == 'Lunas') $statusClass = 'bg-gradient-success';
                                elseif ($pembelian->status_pembayaran == 'Lunas Sebagian') $statusClass = 'bg-gradient-warning';
                                else $statusClass = 'bg-gradient-danger';
                            @endphp
                            <span class="badge badge-sm {{ $statusClass }}">
                                {{ $pembelian->status_pembayaran }}
                            </span>
                        </p>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-secondary">
                            <tr>
                                <th class="text-center text-dark text-xs font-weight-bolder">#</th>
                                <th class="text-dark text-xs font-weight-bolder">Produk</th>
                                <th class="text-center text-dark text-xs font-weight-bolder">Qty</th>
                                <th class="text-end text-dark text-xs font-weight-bolder">Harga Beli</th>
                                <th class="text-end text-dark text-xs font-weight-bolder">Diskon</th>
                                <th class="text-end text-dark text-xs font-weight-bolder">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pembelian->details as $detail)
                                <tr>
                                    <td class="text-center text-sm">{{ $loop->iteration }}</td>
                                    <td class="text-sm">{{ $detail->produk->nama_produk }}</td>
                                    <td class="text-center text-sm">{{ $detail->qty }}</td>
                                    <td class="text-end text-sm">@rupiah($detail->harga_beli)</td>
                                    <td class="text-end text-sm">@rupiah($detail->diskon)</td>
                                    <td class="text-end text-sm">@rupiah($detail->subtotal)</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr><td colspan="5" class="text-end fw-bold">Subtotal Keseluruhan</td><td class="text-end fw-bold">@rupiah($pembelian->subtotal)</td></tr>
                            <tr><td colspan="5" class="text-end">Diskon Tambahan</td><td class="text-end">@rupiah($pembelian->diskon)</td></tr>
                            <tr><td colspan="5" class="text-end">Pajak</td><td class="text-end">@rupiah($pembelian->pajak)</td></tr>
                            <tr><td colspan="5" class="text-end">Ongkos Kirim</td><td class="text-end">@rupiah($pembelian->ongkir)</td></tr>
                            <tr class="table-secondary"><td colspan="5" class="text-end fw-bolder">TOTAL AKHIR</td><td class="text-end fw-bolder">@rupiah($pembelian->total_akhir)</td></tr>
                            <tr><td colspan="5" class="text-end">Jumlah Dibayar</td><td class="text-end">@rupiah($pembelian->jumlah_dibayar)</td></tr>
                            <tr><td colspan="5" class="text-end fw-bold">Sisa Hutang</td><td class="text-end fw-bold text-danger">@rupiah($pembelian->sisa_hutang)</td></tr>
                        </tfoot>
                    </table>
                </div>

                @if ($pembelian->catatan)
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <h6>Catatan:</h6>
                            <div class="p-3 border rounded text-sm">
                                {!! $pembelian->catatan !!}
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-layout>

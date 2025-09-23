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
        <div class="card rounded-2 printable-area">
            <div class="card-header d-flex justify-content-between align-items-center pb-0">
                <h5 class="mb-0 fw-bolder">Detail Pembelian</h5>
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
                        <h6 class="mb-1">Pemasok:</h6>
                        <p class="text-lg fw-bolder text-dark mb-0">{{ $pembelian->pemasok->nama ?? 'Pemasok Dihapus' }}</p>
                        <p class="text-sm mb-1 ">{{ $pembelian->pemasok->kontak ?? '' }}</p>
                        <p class="text-sm mb-0">{{ $pembelian->pemasok->alamat ?? '' }}</p>
                    </div>
                    <div class="col-md-4 mt-3 mt-md-0">
                        <h6>Dibuat Oleh:</h6>
                        <p class="text-sm mb-1">{{ $pembelian->user->nama ?? 'User Dihapus' }}</p>
                        <p class="text-sm mb-0">{{ $pembelian->user->email ?? '-' }}</p>
                    </div>
                    <div class="col-md-4 text-md-start mt-3 mt-md-0">
                        <h6>Informasi Transaksi:</h6>
                        <p class="text-sm mb-1">Referensi : {{ $pembelian->referensi }}</p>
                        <p class="text-sm mb-1">Tanggal : {{ \Carbon\Carbon::parse($pembelian->tanggal_pembelian)->translatedFormat('d F Y') }}</p>
                        <p class="text-sm mb-1">Status Barang :
                            <span class="badge badge-sm {{ $pembelian->status_barang == 'Diterima' ? 'badge-success' : 'badge-warning' }}">
                                {{ $pembelian->status_barang }}
                            </span>

                        </p>
                        <p class="text-sm mb-0">Status Bayar:
                            @php
                                $statusClass = '';
                                if ($pembelian->status_pembayaran == 'Lunas') $statusClass = 'badge-success';
                                elseif ($pembelian->status_pembayaran == 'Lunas Sebagian') $statusClass = 'badge-warning';
                                else $statusClass = 'badge-danger';
                            @endphp
                            <span class="badge badge-sm {{ $statusClass }}">
                                {{ $pembelian->status_pembayaran }}
                            </span>
                        </p>
                    </div>
                </div>
                <div>
                    <p class="mb-1 fw-bolder">Ringkasan Pembelian:</p>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-secondary">
                            <tr>
                                <th class="text-center text-dark text-xs font-weight-bolder">No.</th>
                                <th class="text-dark text-xs font-weight-bolder ps-2">Produk</th>
                                <th class="text-center text-dark text-xs font-weight-bolder">Qty</th>
                                <th class="text-end text-dark text-xs font-weight-bolder pe-2">Harga Beli</th>
                                <th class="text-end text-dark text-xs font-weight-bolder pe-2">Diskon</th>
                                <th class="text-end text-dark text-xs font-weight-bolder ">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pembelian->details as $detail)
                                <tr>
                                    <td class="text-center text-sm">{{ $loop->iteration }}</td>
                                    <td class="text-sm">{{ $detail->produk->nama_produk }}</td>
                                    <td class="text-center text-sm">{{ $detail->qty }}</td>
                                    <td class="text-end text-sm">@money($detail->harga_beli)</td>
                                    <td class="text-end text-sm">@money($detail->diskon)</td>
                                    <td class="text-end text-sm">@money($detail->subtotal)</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="row mt-4 justify-content-end">
                    <div class="col-md-5">
                        <div class="d-flex justify-content-between">
                            <p class="text-sm fw-bold mb-2">Subtotal Keseluruhan:</p>
                            <p class="text-sm fw-bold mb-2">@money($pembelian->subtotal)</p>
                        </div>
                        <div class="d-flex justify-content-between">
                            <p class="text-sm mb-2">Diskon Tambahan:</p>
                            <p class="text-sm mb-2">@money($pembelian->diskon)</p>
                        </div>
                        <div class="d-flex justify-content-between">
                            <p class="text-sm mb-2">PPN:</p>
                            <p class="text-sm mb-2">@money($pembelian->pajak)</p>
                        </div>
                        <div class="d-flex justify-content-between">
                            <p class="text-sm mb-2">Ongkos Kirim:</p>
                            <p class="text-sm mb-2">@money($pembelian->ongkir)</p>
                        </div>
                        <div class="d-flex justify-content-between align-items-center bg-light rounded p-2 my-2">
                            <h6 class="fw-bolder mb-0">TOTAL AKHIR</h6>
                            <h6 class="fw-bolder mb-0">@money($pembelian->total_akhir)</h6>
                        </div>
                        <div class="d-flex justify-content-between mt-2">
                            <p class="text-sm mb-2">Jumlah Dibayar:</p>
                            <p class="text-sm mb-2">@money($pembelian->jumlah_dibayar)</p>
                        </div>
                        <div class="d-flex justify-content-between">
                            <p class="text-sm fw-bold mb-0">Sisa Hutang:</p>
                            <p class="text-sm fw-bold text-danger mb-0">@money($pembelian->sisa_hutang)</p>
                        </div>
                    </div>
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

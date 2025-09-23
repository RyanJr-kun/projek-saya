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
                ['name' => 'Daftar Invoice Penjualan', 'url' => route('penjualan.index')],
                ['name' => 'Detail Penjualan', 'url' => '#'],
            ];
        @endphp
        <x-breadcrumb :items="$breadcrumbItems" />
    @endsection

    <div class="container-fluid py-4">
        <div class="card rounded-2 printable-area">
            <div class="card-header d-flex justify-content-between align-items-center pb-0">
                <h5 class="mb-0 fw-bolder">Detail Penjualan</h5>
                <div class="no-print">
                    <a href="{{ route('penjualan.index') }}" class="btn btn-sm btn-outline-secondary mb-0">
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
                        <h6 class="mb-1">Pelanggan:</h6>
                        <p class="text-lg fw-bolder text-dark mb-0">{{ $penjualan->pelanggan->nama ?? 'Pelanggan Umum' }}</p>
                        <p class="text-sm mb-1 ">{{ $penjualan->pelanggan->kontak ?? '' }}</p>
                        <p class="text-sm mb-0">{{ $penjualan->pelanggan->alamat ?? '' }}</p>
                    </div>
                    <div class="col-md-4 mt-3 mt-md-0">
                        <h6>Dibuat Oleh:</h6>
                        <p class="text-sm mb-1">{{ $penjualan->user->nama ?? 'User Dihapus' }}</p>
                        <p class="text-sm mb-0">{{ $penjualan->user->email ?? '-' }}</p>
                    </div>
                    <div class="col-md-4 text-md-start mt-3 mt-md-0">
                        <h6>Informasi Transaksi:</h6>
                        <table class="table table-borderless table-sm" style="width: auto;">
                            <tbody>
                                <tr class="text-sm">
                                    <td class="ps-0">Invoice</td>
                                    <td class="px-1">:</td>
                                    <td>{{ $penjualan->referensi }}</td>
                                </tr>
                                <tr class="text-sm">
                                    <td class="ps-0">Tanggal</td>
                                    <td class="px-1">:</td>
                                    <td>{{ \Carbon\Carbon::parse($penjualan->tanggal_penjualan)->translatedFormat('d F Y, H:i') }}</td>
                                </tr>
                                <tr class="text-sm">
                                    <td class="ps-0">Metode Bayar</td>
                                    <td class="px-1">:</td>
                                    <td>{{ $penjualan->metode_pembayaran }}</td>
                                </tr>
                                <tr class="text-sm">
                                    <td class="ps-0">Status</td>
                                    <td class="px-1">:</td>
                                    <td><span class="badge badge-sm {{ $penjualan->status_pembayaran == 'Lunas' ? 'badge-success' : ($penjualan->status_pembayaran == 'Belum Lunas' ? 'badge-warning' : 'badge-danger') }}">{{ $penjualan->status_pembayaran }}</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div>
                    <p class="mb-1 fw-bolder">Ringkasan Penjualan:</p>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-secondary">
                            <tr>
                                <th class="text-center text-dark text-xs font-weight-bolder">No.</th>
                                <th class="text-dark text-xs font-weight-bolder ps-2">Produk</th>
                                <th class="text-center text-dark text-xs font-weight-bolder">Qty</th>
                                <th class="text-end text-dark text-xs font-weight-bolder pe-2">Harga Jual</th>
                                <th class="text-end text-dark text-xs font-weight-bolder pe-2">Diskon</th>
                                <th class="text-end text-dark text-xs font-weight-bolder ">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($penjualan->items as $item)
                                <tr>
                                    <td class="text-center text-sm">{{ $loop->iteration }}</td>
                                    <td class="text-sm">{{ $item->produk->nama_produk ?? 'Produk Dihapus' }}</td>
                                    <td class="text-center text-sm">{{ $item->jumlah }}</td>
                                    <td class="text-end text-sm">@money($item->harga_jual)</td>
                                    <td class="text-end text-sm">@money($item->diskon_item)</td>
                                    <td class="text-end text-sm">@money($item->subtotal)</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="row mt-4 justify-content-end">
                    <div class="col-md-5">
                        <div class="d-flex justify-content-between">
                            <p class="text-sm fw-bold mb-2">Subtotal Keseluruhan:</p>
                            <p class="text-sm fw-bold mb-2">@money($penjualan->subtotal)</p>
                        </div>
                        <div class="d-flex justify-content-between">
                            <p class="text-sm mb-2">Diskon Tambahan:</p>
                            <p class="text-sm mb-2">@money($penjualan->diskon)</p>
                        </div>
                        <div class="d-flex justify-content-between">
                            <p class="text-sm mb-2">Pajak:</p>
                            <p class="text-sm mb-2">@money($penjualan->pajak)</p>
                        </div>
                        <div class="d-flex justify-content-between">
                            <p class="text-sm mb-2">Ongkos Kirim:</p>
                            <p class="text-sm mb-2">@money($penjualan->ongkir)</p>
                        </div>
                        @if ($penjualan->service > 0)
                        <div class="d-flex justify-content-between">
                            <p class="text-sm mb-2">Biaya Servis:</p>
                            <p class="text-sm mb-2">@money($penjualan->service)</p>
                        </div>
                        @endif
                        <div class="d-flex justify-content-between align-items-center bg-light rounded p-2 my-2">
                            <h6 class="fw-bolder mb-0">TOTAL AKHIR</h6>
                            <h6 class="fw-bolder mb-0">@money($penjualan->total_akhir)</h6>
                        </div>
                        <div class="d-flex justify-content-between mt-2">
                            <p class="text-sm mb-2">Jumlah Dibayar:</p>
                            <p class="text-sm mb-2">@money($penjualan->jumlah_dibayar)</p>
                        </div>
                        <div class="d-flex justify-content-between">
                            @if ($penjualan->kembalian > 0)
                                <p class="text-sm fw-bold mb-0">Kembalian:</p>
                                <p class="text-sm fw-bold text-success mb-0">@money($penjualan->kembalian)</p>
                            @else
                                <p class="text-sm fw-bold mb-0">Sisa Bayar:</p>
                                <p class="text-sm fw-bold text-danger mb-0">@money(abs($penjualan->kembalian))</p>
                            @endif
                        </div>
                    </div>
                </div>

                @if ($penjualan->catatan)
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <h6>Catatan:</h6>
                            <div class="p-3 border rounded text-sm">
                                {!! $penjualan->catatan !!}
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-layout>

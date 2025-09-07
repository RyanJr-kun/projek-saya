<x-layout>
    {{-- Breadcrumb --}}
    @section('breadcrumb')
        @php
            $breadcrumbItems = [
                ['name' => 'Penjualan', 'url' => route('penjualan.index')],
                ['name' => 'Detail Invoice', 'url' => '#'],
            ];
        @endphp
        <x-breadcrumb :items="$breadcrumbItems" />
    @endsection

    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="card">
                    <div class="card-header p-4 pb-0">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h5 class="mb-0">Invoice #{{ $penjualan->nomer_invoice }}</h5>
                                <p class="text-sm mb-0">
                                    Tanggal: {{ $penjualan->created_at->translatedFormat('d F Y, H:i') }}
                                </p>
                            </div>
                            <div class="text-end">
                                <img src="{{ asset('assets/img/logo.svg') }}" alt="logo" height="48">
                                <h6 class="mb-0 mt-2">JO Computer</h6>
                            </div>
                        </div>
                        <hr class="horizontal dark my-3">
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="mb-1">Ditagihkan Kepada:</h6>
                                <p class="text-sm font-weight-bold mb-0">{{ $penjualan->pelanggan->nama ?? 'Pelanggan Umum' }}</p>
                                <p class="text-sm mb-0">{{ $penjualan->pelanggan->alamat ?? '' }}</p>
                                <p class="text-sm mb-0">{{ $penjualan->pelanggan->kontak ?? '' }}</p>
                            </div>
                            <div class="col-md-6 text-md-end">
                                <h6 class="mb-1">Kasir:</h6>
                                <p class="text-sm font-weight-bold mb-0">{{ $penjualan->user->nama ?? 'N/A' }}</p>
                                <h6 class="mt-3 mb-1">Metode Pembayaran:</h6>
                                <span class="badge bg-gradient-info">{{ $penjualan->metode_pembayaran }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <thead class="table-secondary">
                                    <tr>
                                        <th class="text-sm text-uppercase">Item</th>
                                        <th class="text-sm text-uppercase text-center">Qty</th>
                                        <th class="text-sm text-uppercase text-end">Harga</th>
                                        <th class="text-sm text-uppercase text-end">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($penjualan->items as $item)
                                        <tr>
                                            <td>
                                                <p class="text-sm font-weight-bold mb-0">{{ $item->produk->nama_produk ?? 'Produk Dihapus' }}</p>
                                            </td>
                                            <td class="text-center">
                                                <p class="text-sm mb-0">{{ $item->jumlah }}</p>
                                            </td>
                                            <td class="text-end">
                                                <p class="text-sm mb-0">Rp {{ number_format($item->harga, 0, ',', '.') }}</p>
                                            </td>
                                            <td class="text-end">
                                                <p class="text-sm mb-0">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="3" class="text-end text-sm">Subtotal</th>
                                        <th class="text-end text-sm">Rp {{ number_format($penjualan->subtotal, 0, ',', '.') }}</th>
                                    </tr>
                                    <tr>
                                        <th colspan="3" class="text-end text-sm">Diskon</th>
                                        <th class="text-end text-sm text-danger">- Rp {{ number_format($penjualan->diskon, 0, ',', '.') }}</th>
                                    </tr>
                                    <tr>
                                        <th colspan="3" class="text-end text-sm">Pajak</th>
                                        <th class="text-end text-sm">+ Rp {{ number_format($penjualan->pajak, 0, ',', '.') }}</th>
                                    </tr>
                                    <tr>
                                        <th colspan="3" class="text-end h6">Total Akhir</th>
                                        <th class="text-end h6">Rp {{ number_format($penjualan->total_akhir, 0, ',', '.') }}</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        @if($penjualan->catatan)
                        <div class="mt-4">
                            <h6 class="mb-1">Catatan:</h6>
                            <p class="text-sm">{{ $penjualan->catatan }}</p>
                        </div>
                        @endif
                    </div>
                    <div class="card-footer text-end p-4 pt-0">
                        <button class="btn btn-info" onclick="window.print()">
                            <i class="fas fa-print me-2"></i> Cetak Invoice
                        </button>
                        <a href="{{ route('penjualan.index') }}" class="btn btn-outline-secondary ms-2">
                            Kembali ke Daftar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>

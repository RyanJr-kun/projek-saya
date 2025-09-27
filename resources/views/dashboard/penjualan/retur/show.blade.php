<x-layout>
    @section('breadcrumb')
        @php
            $breadcrumbItems = [
                ['name' => 'Penjualan', 'url' => route('penjualan.index')],
                ['name' => 'Daftar Retur', 'url' => route('retur-penjualan.index')],
                ['name' => 'Detail Retur', 'url' => '#'],
            ];
        @endphp
        <x-breadcrumb :items="$breadcrumbItems" />
    @endsection

    <div class="container-fluid p-3">
        <div class="card rounded-2">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Detail Retur: {{ $retur->kode_retur }}</h5>
                    <div>
                        {{-- <button class="btn btn-primary btn-sm mb-0">Cetak</button> --}}
                        <a href="{{ route('retur-penjualan.index') }}" class="btn btn-secondary btn-sm mb-0">Kembali</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6>Informasi Retur</h6>
                        <p class="text-sm mb-1"><strong>Kode Retur:</strong> {{ $retur->kode_retur }}</p>
                        <p class="text-sm mb-1"><strong>Tanggal Retur:</strong> {{ $retur->tanggal_retur->translatedFormat('l, d F Y') }}</p>
                        <p class="text-sm mb-1"><strong>Dibuat Oleh:</strong> {{ $retur->user->nama }}</p>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <h6>Informasi Invoice Asal</h6>
                        <p class="text-sm mb-1"><strong>No. Invoice:</strong> <a href="{{ route('penjualan.show', $retur->penjualan->referensi) }}">{{ $retur->penjualan->referensi }}</a></p>
                        <p class="text-sm mb-1"><strong>Tanggal Invoice:</strong> {{ $retur->penjualan->tanggal_penjualan->translatedFormat('l, d F Y') }}</p>
                        <p class="text-sm mb-1"><strong>Pelanggan:</strong> {{ $retur->penjualan->pelanggan->nama ?? 'Pelanggan Umum' }}</p>
                    </div>
                </div>

                @if ($retur->catatan)
                    <div class="alert alert-secondary text-white mt-3" role="alert">
                        <strong>Catatan:</strong> {{ $retur->catatan }}
                    </div>
                @endif

                <div class="table-responsive p-0 mt-4">
                    <table class="table table-bordered align-items-center mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder">No</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder">Nama Produk</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder text-end">Harga Satuan</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder text-center">Jumlah Diretur</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder text-end">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($retur->items as $item)
                                <tr>
                                    <td class="text-center"><p class="text-xs font-weight-bold mb-0">{{ $loop->iteration }}</p></td>
                                    <td><p class="text-xs font-weight-bold mb-0">{{ $item->produk->nama_produk }}</p></td>
                                    <td class="text-end"><p class="text-xs font-weight-bold mb-0">{{ 'Rp ' . number_format($item->harga, 0, ',', '.') }}</p></td>
                                    <td class="text-center"><p class="text-xs font-weight-bold mb-0">{{ $item->jumlah }}</p></td>
                                    <td class="text-end"><p class="text-xs font-weight-bold mb-0">{{ 'Rp ' . number_format($item->subtotal, 0, ',', '.') }}</p></td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4" class="text-end fw-bold">Total Nilai Retur</td>
                                <td class="text-end fw-bold">{{ 'Rp ' . number_format($retur->total_retur, 0, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-layout>

<x-layout>
    @section('breadcrumb')
        @php
            $breadcrumbItems = [
                ['name' => 'Penjualan', 'url' => route('penjualan.index')],
                ['name' => 'Daftar Retur Penjualan', 'url' => route('retur-penjualan.index')],
            ];
        @endphp
        <x-breadcrumb :items="$breadcrumbItems" />
    @endsection

    <div class="container-fluid p-3">
        <div class="card rounded-2">
            <div class="card-header pb-0 px-3 pt-2 mb-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-n1">Daftar Retur Penjualan</h6>
                        <p class="text-sm mb-0">Riwayat pengembalian barang dari pelanggan.</p>
                    </div>
                    <div class="ms-md-auto mt-2">
                        <a href="{{ route('retur-penjualan.create') }}" class="btn btn-outline-info mb-0">
                            <i class="fa fa-plus me-2"></i>Buat Retur
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <div class="filter-container p-3">
                    <form action="{{ route('retur-penjualan.index') }}" method="GET">
                        <div class="row g-3 align-items-center">
                            <div class="col-md-4">
                                <input type="text" name="search" class="form-control" placeholder="Cari kode retur atau referensi invoice..." value="{{ request('search') }}">
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary">Cari</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="table-responsive p-0">
                    <table class="table table-hover align-items-center mb-0">
                        <thead class="table-secondary">
                            <tr>
                                <th class="text-uppercase text-dark text-xs font-weight-bolder">Kode Retur</th>
                                <th class="text-uppercase text-dark text-xs font-weight-bolder ps-2">Invoice Asal</th>
                                <th class="text-uppercase text-dark text-xs font-weight-bolder ps-2">Tanggal</th>
                                <th class="text-uppercase text-dark text-xs font-weight-bolder ps-2">Total Retur</th>
                                <th class="text-uppercase text-dark text-xs font-weight-bolder ps-2">Dibuat Oleh</th>
                                <th class="text-dark"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($returs as $retur)
                                <tr>
                                    <td>
                                        <p class="text-xs text-dark fw-bold mb-0 px-3">{{ $retur->kode_retur }}</p>
                                    </td>
                                    <td>
                                        <a href="{{ route('penjualan.show', $retur->penjualan->referensi) }}" class="text-info fw-bold text-xs" data-bs-toggle="tooltip" title="Lihat Invoice Asal">
                                            {{ $retur->penjualan->referensi }}
                                        </a>
                                    </td>
                                    <td>
                                        <p class="text-xs text-dark fw-bold mb-0">{{ $retur->tanggal_retur->translatedFormat('d M Y') }}</p>
                                    </td>
                                    <td>
                                        <p class="text-xs text-dark fw-bold mb-0">{{ 'Rp ' . number_format($retur->total_retur, 0, ',', '.') }}</p>
                                    </td>
                                    <td>
                                        <p class="text-xs text-dark fw-bold mb-0">{{ $retur->user->nama }}</p>
                                    </td>
                                    <td class="align-middle">
                                        <a href="{{ route('retur-penjualan.show', $retur->id) }}" class="btn btn-link text-dark p-0 m-0" data-bs-toggle="tooltip" title="Lihat Detail Retur">
                                            <i class="bi bi-eye-fill text-sm opacity-10"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4">Tidak ada data retur penjualan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-3 px-3">
                    {{ $returs->links() }}
                </div>
            </div>
        </div>
    </div>
</x-layout>

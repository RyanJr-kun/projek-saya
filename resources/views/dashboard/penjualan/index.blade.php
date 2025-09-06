<x-layout>
    {{-- breadcrumb --}}
    @section('breadcrumb')
        @php
        $breadcrumbItems = [
            ['name' => 'Penjualan', 'url' => '#'],
            ['name' => 'Invoice Penjualan', 'url' => route('penjualan.index')],
        ];
        @endphp
        <x-breadcrumb :items="$breadcrumbItems" />
    @endsection

    <div class="container-fluid d-flex flex-column min-vh-90 p-3 mb-auto">
        <div class="card">
            <div class="card-header pb-0 px-3 pt-2 mb-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0">{{ $title }}</h5>
                            <p class="text-xs mb-0">
                            Kelola Riwayat Transaksi Penjualan.
                        </p>
                    </div>
                    <div class="ms-auto my-auto mt-md-0 mb-3">
                        <div>
                            <div class="d-none d-md-block mt-2">
                                <a href="#Export-Pdf" type="button" class="btn btn-outline-danger me-2 p-2 mb-0" title="Export PDF">
                                    <img src="assets/img/pdf.png" alt="Download PDF" width="20" height="20">
                                </a>
                                <a href="#Export-Excel" class="btn btn-outline-success p-2 me-2 export mb-0" data-type="csv" type="button" title="Export Excel">
                                    <img src="assets/img/xls.png" alt="Download Excel" width="20" height="20">
                                </a>
                                <a href="{{ route('penjualan.create') }}">
                                    <button class="btn btn-outline-info mb-0">
                                        <i class="bi bi-plus-lg cursor-pointer pe-2"></i> Penjualan
                                    </button>
                                </a>
                            </div>
                            <div class="dropdown d-block d-md-none mt-3 ">
                                <button class="btn btn-outline-info dropdown-toggle mb-0" type="button" id="aksiMobile" data-bs-toggle="dropdown" aria-expanded="false">Pilih Aksi</button>
                                <ul class="dropdown-menu" aria-labelledby="aksiMobile">
                                    <li>
                                        <a class="dropdown-item" href="#Export-Pdf">
                                            <img src="assets/img/pdf.png" alt="Download PDF" width="20" height="20" class="me-2">Export PDF
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item export" href="#Export-Excel" data-type="csv">
                                            <img src="assets/img/xls.png" alt="Download Excel" width="20" height="20" class="me-2">Export Excel
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item text-success ms-1" href="{{ route('penjualan.create') }}">
                                            <i class="bi bi-plus-lg cursor-pointer me-2"></i>Penjualan
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <div class="filter-container mb-3">
                    <div class="row g-3 align-items-center justify-content-between">
                        <!-- Filter Pencarian Nama -->
                        <div class="col-5 col-lg-3 ms-3">
                            <input type="text" id="searchInput" class="form-control" placeholder="cari produk ...">
                        </div>
                        <!-- Filter Dropdown Posisi -->
                        <div class="col-5 col-lg-2 me-3">
                            <select id="posisiFilter" class="form-select">
                                <option value="">Semua kategori</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="table-responsive p-0 mt-4">
                    <table class="table table-hover align-items-center pb-3" id="tableData">
                        <thead>
                            <tr class="table-secondary">
                                <th class="text-uppercase text-dark text-xs font-weight-bolder">Invoice</th>
                                <th class="text-uppercase text-dark text-xs font-weight-bolder ps-2 ">Pelanggan</th>
                                <th class="text-uppercase text-dark text-xs font-weight-bolder ps-2">Total</th>
                                <th class="text-uppercase text-dark text-xs font-weight-bolder ps-2">Status</th>
                                <th class="text-uppercase text-dark text-xs font-weight-bolder ps-2">Tanggal</th>
                                <th class="text-dark"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($penjualan as $item)
                                <tr>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">{{ $item->nomer_invoice }}</p>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">{{ $item->pelanggan->nama ?? 'Pelanggan Umum' }}</p><p class="text-xs text-secondary mb-0">Kasir: {{ $item->user->nama }}</p>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <span class="font-weight-bold">@currency($item->total_akhir)</span>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <span class="badge badge-sm bg-gradient-success">{{ $item->status }}</span>
                                    </td>
                                    <td class="align-middle text-center">
                                        <span class="text-secondary text-xs font-weight-bold">{{ $item->created_at->format('d/m/Y H:i') }}</span>
                                    </td>
                                    <td class="align-middle">
                                        <a href="{{ route('penjualan.show', $item->id) }}" class="btn btn-link text-dark px-3 mb-0" data-bs-toggle="tooltip" data-bs-placement="top" title="Lihat Detail"><i class="bi bi-eye-fill"></i></a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4">Tidak ada data penjualan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</x-layout>

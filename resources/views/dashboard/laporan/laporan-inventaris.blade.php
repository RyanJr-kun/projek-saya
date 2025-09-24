<x-layout>
    @push('styles')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
        <link rel="stylesheet"
            href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    @endpush

    @section('breadcrumb')
        @php
            $breadcrumbItems = [['name' => 'Laporan', 'url' => '#'], ['name' => 'Pergerakan Inventaris', 'url' => route('laporan.inventaris')]];
        @endphp
        <x-breadcrumb :items="$breadcrumbItems" />
    @endsection

    <div class="container-fluid p-3">
        <div class="card rounded-2">
            <div class="card-header pb-0 px-3 pt-2 mb-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-n1">Laporan Pergerakan Inventaris</h6>
                        <p class="text-sm mb-0">Melacak semua transaksi masuk dan keluar barang.</p>
                    </div>
                    <div class="dropdown mt-2">
                        <button class="btn btn-outline-primary dropdown-toggle" type="button" id="exportDropdown"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-download me-2"></i>Ekspor
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="exportDropdown">
                            <li><a class="dropdown-item" href="#" id="exportXlsx">
                                    <img src="{{ asset('assets/img/xls.png') }}" alt="Download Excel" width="20"
                                        height="20" class="me-2"> Excel (.xlsx)</a></li>
                            <li><a class="dropdown-item" href="#" id="exportPdf">
                                    <img src="{{ asset('assets/img/pdf.png') }}" alt="Download PDF" width="20"
                                        height="20" class="me-2">PDF</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                {{-- Filter Section --}}
                <div class="filter-container p-3 border-bottom">
                    <form action="{{ route('laporan.inventaris') }}" method="GET">
                        <div class="row g-3 align-items-end">
                            <div class="col-md-3">
                                <label for="produk_id" class="form-label">Produk</label>
                                <select name="produk_id" id="produk_id" class="form-select">
                                    <option value="">Semua Produk</option>
                                    @foreach ($produks as $produk)
                                        <option value="{{ $produk->id }}" @selected(request('produk_id') == $produk->id)>
                                            {{ $produk->nama_produk }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="tipe_gerakan" class="form-label">Tipe Gerakan</label>
                                <select name="tipe_gerakan" id="tipe_gerakan" class="form-select">
                                    <option value="">Semua Tipe</option>
                                    @foreach ($tipe_gerakan_options as $tipe)
                                        <option value="{{ $tipe }}" @selected(request('tipe_gerakan') == $tipe)>{{ $tipe }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="start_date" class="form-label">Tanggal Mulai</label>
                                <input type="date" name="start_date" id="start_date" class="form-control"
                                    value="{{ request('start_date') }}">
                            </div>
                            <div class="col-md-2">
                                <label for="end_date" class="form-label">Tanggal Selesai</label>
                                <input type="date" name="end_date" id="end_date" class="form-control"
                                    value="{{ request('end_date') }}">
                            </div>
                            <div class="col-md-3 d-flex mb-n3">
                                <button type="submit" class="btn btn-dark w-50 me-2">Filter</button>
                                <a href="{{ route('laporan.inventaris') }}" class="btn btn-outline-secondary w-50">Reset</a>
                            </div>
                        </div>
                    </form>
                </div>

                {{-- Table Section --}}
                <div class="table-responsive p-0">
                    <table class="table table-hover align-items-center mb-0">
                        <thead class="table-secondary">
                            <tr>
                                <th class="text-uppercase text-dark text-xs font-weight-bolder ps-4">Tanggal</th>
                                <th class="text-uppercase text-dark text-xs font-weight-bolder">Produk</th>
                                <th class="text-uppercase text-dark text-xs font-weight-bolder">Tipe</th>
                                <th class="text-uppercase text-dark text-xs font-weight-bolder">Referensi</th>
                                <th class="text-center text-uppercase text-dark text-xs font-weight-bolder">Masuk</th>
                                <th class="text-center text-uppercase text-dark text-xs font-weight-bolder">Keluar</th>
                                <th class="text-uppercase text-dark text-xs font-weight-bolder">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($pergerakan as $item)
                                <tr>
                                    <td class="ps-4">
                                        <p class="text-sm font-weight-bold mb-0">
                                            {{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d M Y, H:i') }}</p>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-bold mb-0">{{ $item->nama_produk ?? 'Produk Dihapus' }}</p>
                                        <p class="text-xs text-secondary mb-0">{{ $item->sku ?? '-' }}</p>
                                    </td>
                                    <td>
                                        <span
                                            class="badge badge-sm badge-{{ ['Pembelian' => 'success', 'Penjualan' => 'info', 'Stok Opname' => 'primary', 'Penyesuaian' => 'warning'][$item->tipe_gerakan] ?? 'secondary' }}">{{ $item->tipe_gerakan }}</span>
                                    </td>
                                    <td>
                                        @if ($item->route_name && $item->referensi_id)
                                            <a href="{{ route($item->route_name, $item->referensi_id) }}"
                                                class="text-info fw-bold text-sm" data-bs-toggle="tooltip"
                                                title="Lihat Detail {{ $item->tipe_gerakan }}">
                                                {{ $item->referensi }}
                                            </a>
                                        @else
                                            <p class="text-sm font-weight-bold mb-0">{{ $item->referensi }}</p>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <p class="text-sm text-success fw-bold mb-0">
                                            {{ $item->jumlah_masuk > 0 ? '+' . $item->jumlah_masuk : '-' }}</p>
                                    </td>
                                    <td class="text-center">
                                        <p class="text-sm text-danger fw-bold mb-0">
                                            {{ $item->jumlah_keluar > 0 ? '-' . $item->jumlah_keluar : '-' }}</p>
                                    </td>
                                    <td>
                                        <p class="text-sm mb-0 text-truncate" style="max-width: 200px;">
                                            {{ $item->keterangan ?: '-' }}</p>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4">
                                        <p class="text-sm fw-bold mb-0">Tidak ada data pergerakan inventaris ditemukan.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-center my-4">
                    {{ $pergerakan->links() }}
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script>
            $(document).ready(function() {
                $('#produk_id').select2({
                    theme: "bootstrap-5",
                    placeholder: 'Pilih Produk',
                });

                const exportXlsxBtn = document.getElementById('exportXlsx');
                const exportPdfBtn = document.getElementById('exportPdf');

                function handleExport(e) {
                    e.preventDefault();
                    // Tentukan tipe ekspor berdasarkan ID elemen yang diklik
                    const exportType = this.id === 'exportXlsx' ? 'xlsx' : 'pdf';

                    // Ambil nilai filter saat ini dari form
                    const form = document.querySelector('.filter-container form');
                    const params = new URLSearchParams(new FormData(form)).toString();

                    // Bangun URL untuk ekspor
                    const exportUrl = `{{ route('laporan.inventaris.export') }}?type=${exportType}&${params}`;

                    // Buka URL di tab baru untuk memulai unduhan
                    window.open(exportUrl, '_blank');
                }

                exportXlsxBtn.addEventListener('click', handleExport);
                exportPdfBtn.addEventListener('click', handleExport);
            });
        </script>
    @endpush
</x-layout>

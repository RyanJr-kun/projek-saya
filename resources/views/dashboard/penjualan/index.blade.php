<x-layout>
    @push('styles')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css">
    @endpush
    @section('breadcrumb')
        @php
            $breadcrumbItems = [
                ['name' => 'Page', 'url' => '#'],
                ['name' => 'Daftar Invoice Penjualan', 'url' => route('penjualan.index')],
            ];
        @endphp
        <x-breadcrumb :items="$breadcrumbItems" />
    @endsection

    <div class="container-fluid p-3">
        <div class="card rounded-2 ">
            <div class="card-header pb-0 px-3 pt-2 mb-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-n1">Invoice Penjualan</h6>
                        <p class="text-sm mb-0"> riwayat transaksi penjualan.</p>
                    </div>
                    <div class="ms-md-auto mt-2">
                        <a href="{{ route('penjualan.create') }}" class="btn btn-outline-info mb-0">
                            <i class="fa fa-plus me-2"></i>Transaksi
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <div class="filter-container">
                    <div class="row g-3 align-items-center justify-content-between">
                        <!-- Filter Pencarian Unit -->
                        <div class="col-5 col-lg-3 ms-3">
                            <input type="text" id="searchInput" class="form-control" placeholder="cari invoice ...">
                        </div>
                        <!-- Filter Dropdown Status -->
                        <div class="col-5 col-lg-2 me-3">
                            <select id="statusFilter" class="form-select">
                                <option value="">Semua Status</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="table-responsive p-0 mt-3">
                    <table class="table table-hover align-items-center mb-0">
                        <thead>
                            <tr class="table-secondary">
                                <th class="text-uppercase text-dark text-xs fw-bolder">Pelanggan</th>
                                <th class="text-uppercase text-dark text-xs fw-bolder ps-2">Invoice</th>
                                <th class="text-uppercase text-dark text-xs fw-bolder ps-2">Tanggal</th>
                                <th class="text-uppercase text-dark text-xs fw-bolder ps-2">Total</th>
                                <th class="text-uppercase text-dark text-xs fw-bolder text-center">Status</th>
                                <th class="text-uppercase text-dark text-xs fw-bolder">Pembuat</th>
                                <th class="text-dark"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($penjualan as $item)
                                <tr>
                                    <td>
                                        <div class="d-flex flex-column justify-content-center ms-3">
                                            <h6 class="mb-0 text-sm">{{ $item->pelanggan->nama ?? 'Pelanggan Umum' }}</h6>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="mb-0 text-sm">{{ $item->referensi }}</h6>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-sm fw-bolder mb-0">{{ $item->created_at->translatedFormat('d M Y, H:i') }}</p>
                                    </td>
                                    <td class="align-middle">
                                        <span class="text-secondary text-sm fw-bolder">{{ $item->total }}</span>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        @php
                                            $statusClass = '';
                                            if ($item->status_pembayaran === 'Lunas') $statusClass = 'badge-success';
                                            elseif ($item->status_pembayaran === 'Belum Lunas') $statusClass = 'badge-danger';
                                            elseif ($item->status_pembayaran === 'Dibatalkan') $statusClass = 'badge-warning';
                                        @endphp
                                        <span class="badge badge-sm {{ $statusClass }}">{{ str_replace('_', ' ', $item->status_pembayaran) }}</span>
                                    </td>
                                    <td>
                                        <div title="foto & nama user" class="d-flex align-items-center px-2 py-1">
                                            @if ($item->user->img_user)
                                                <img src="{{ asset('storage/' . $item->user->img_user) }}" class="avatar avatar-sm me-3" alt="user_img">
                                            @else
                                                <img src="{{ asset('assets/img/user.webp') }}" class="avatar avatar-sm me-3" alt="Gambar User default">
                                            @endif
                                            <h6 class="mb-0 text-sm">{{ $item->user->nama }}</h6>
                                        </div>
                                    </td>
                                    <td class="align-middle text-center">
                                        <a href="{{ route('penjualan.show', $item->referensi) }}" class="text-dark fw-bold text-sm px-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Lihat Detail">
                                            <i class="fa fa-eye "></i>
                                        </a>
                                        <a href="{{ route('penjualan.edit', $item->referensi) }}" class="text-dark fw-bold text-sm px-2"data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Transaksi">
                                            <i class="fa fa-pen-to-square"></i>
                                        </a>
                                        <a href="#" class="text-dark fw-bold text-sm px-2"
                                            data-bs-toggle="modal"
                                            data-bs-target="#cancelConfirmationModal"
                                            data-invoice-number="{{ $item->referensi }}"
                                            title="Batalkan Transaksi">
                                            <i class="fa fa-ban"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-3">
                                        <p class=" text-dark text-sm fw-bold mb-0">Belum ada data penjualan.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-3 px-3">
                    {{ $penjualan->links() }}
                </div>
            </div>
        </div>
    </div>

    {{-- Ubah Modal --}}
    <div class="modal fade" id="cancelConfirmationModal" tabindex="-1" aria-labelledby="cancelConfirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center mt-3 mx-n5">
                    <i class="bi bi-exclamation-triangle fa-2x text-warning mb-3"></i> {{-- Ganti ikon --}}
                    <p class="mb-0">Anda yakin ingin membatalkan transaksi ini?</p>    {{-- Ganti teks --}}
                    <h6 class="mt-2" id="invoiceNumberToCancel"></h6>
                    <small class="text-warning">Tindakan ini akan mengembalikan stok produk yang terjual.</small>
                    <div class="mt-4">
                        {{-- Form ini akan mengirim request ke method 'update' atau method khusus 'cancel' --}}
                        <form id="cancelInvoiceForm" method="POST" action="#">
                            @method('PUT') {{-- Atau PATCH --}}
                            @csrf
                            <input type="hidden" name="status_pembayaran" value="Dibatalkan">
                            <button type="submit" class="btn btn-warning btn-sm">Ya, Batalkan</button> {{-- Ganti teks & warna --}}
                            <button type="button" class="btn btn-outline-secondary btn-sm ms-2" data-bs-dismiss="modal">Tutup</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Ganti script lama untuk modal delete dengan yang ini
        document.addEventListener('DOMContentLoaded', function () {
            const cancelModal = document.getElementById('cancelConfirmationModal');
            if (cancelModal) {
                cancelModal.addEventListener('show.bs.modal', function (event) {
                    const button = event.relatedTarget;
                    const invoiceNumber = button.getAttribute('data-invoice-number');
                    const form = cancelModal.querySelector('#cancelInvoiceForm');
                    const text = cancelModal.querySelector('#invoiceNumberToCancel');

                    if (text) text.textContent = invoiceNumber;
                    // Arahkan form ke route update
                    if (form) form.action = `/penjualan/${invoiceNumber}`;
                });
            }
        });
    </script>
    @endpush
</x-layout>

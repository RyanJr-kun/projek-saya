<x-layout>
    {{-- Breadcrumb --}}
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
        <div class="card mb-4">
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
                                <th class="text-uppercase text-dark text-xs fw-bolder text-center">Total</th>
                                <th class="text-uppercase text-dark text-xs fw-bolder text-center">Status</th>
                                <th class="text-uppercase text-dark text-xs fw-bolder">Pembuat</th>
                                <th class="text-dark"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($penjualan as $item)
                                <tr>
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{ $item->nomer_invoice }}</h6>
                                                <p class="text-xs text-secondary mb-0">Kasir: {{ $item->user->nama ?? 'N/A' }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">{{ $item->created_at->translatedFormat('d M Y, H:i') }}</p>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">{{ $item->pelanggan->nama ?? 'Pelanggan Umum' }}</p>
                                    </td>
                                    <td class="align-middle text-center">
                                        <span class="text-secondary text-xs fw-bold">Rp {{ number_format($item->total_akhir, 0, ',', '.') }}</span>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <span class="badge badge-sm bg-gradient-success">{{ $item->status }}</span>
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
                                        <a href="{{ route('penjualan.show', $item->id) }}" class="text-secondary fw-bold text-xs px-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Lihat Detail">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="#" class="text-danger fw-bold text-xs"
                                            data-bs-toggle="modal"
                                            data-bs-target="#deleteConfirmationModal"
                                            data-invoice-id="{{ $item->id }}"
                                            data-invoice-number="{{ $item->nomer_invoice }}"
                                            title="Hapus Transaksi">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-3 ">
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

    {{-- modal edit --}}
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0 mb-n3">
                    <h6 class="modal-title" id="editModalLabel">Edit Unit Produk</h6>
                    <button type="button" class="btn btn-close bg-danger rounded-3 me-1" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="">
                        @method('put')
                        @csrf
                        <div class="row">
                            <div class="form-group">
                                <div class="mb-3">
                                    <label for="edit_nama" class="form-label">Nama</label>
                                    <input id="edit_nama" name="nama" type="text" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="edit_slug" class="form-label">Slug</label>
                                    <input id="edit_slug" name="slug" type="text" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="edit_singkat" class="form-label">Nama Pendek</label>
                                    <input id="edit_singkat" name="singkat" type="text" class="form-control" required>
                                </div>
                                <div class="justify-content-end form-check form-switch form-check-reverse mt-3">
                                    <label class="me-auto form-check-label" for="edit_status">Status</label>
                                    <input id="edit_status" class="form-check-input" type="checkbox" name="status" value="1">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer border-0 pb-0">
                            <button type="submit" class="btn btn-info btn-sm">Simpan Perubahan</button>
                            <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">Batalkan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Delete --}}
    <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center mt-3 mx-n5">
                    <i class="bi bi-trash fa-2x text-danger mb-3"></i>
                    <p class="mb-0">Anda yakin ingin menghapus transaksi ini?</p>
                    <h6 class="mt-2" id="invoiceNumberToDelete"></h6>
                    <small class="text-warning">Tindakan ini akan mengembalikan stok produk yang terjual.</small>
                    <div class="mt-4">
                        <form id="deleteInvoiceForm" method="POST" action="#">
                            @method('delete')
                            @csrf
                            <button type="submit" class="btn btn-danger btn-sm">Ya, Hapus</button>
                            <button type="button" class="btn btn-outline-secondary btn-sm ms-2" data-bs-dismiss="modal">Batal</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const deleteModal = document.getElementById('deleteConfirmationModal');
            if (deleteModal) {
                deleteModal.addEventListener('show.bs.modal', function (event) {
                    const button = event.relatedTarget;
                    const invoiceId = button.getAttribute('data-invoice-id');
                    const invoiceNumber = button.getAttribute('data-invoice-number');
                    deleteModal.querySelector('#invoiceNumberToDelete').textContent = invoiceNumber;
                    deleteModal.querySelector('#deleteInvoiceForm').action = `/penjualan/${invoiceId}`;
                });
            }
        });
    </script>
    @endpush
</x-layout>

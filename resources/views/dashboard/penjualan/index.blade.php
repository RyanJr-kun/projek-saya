<x-layout>
    {{-- Breadcrumb --}}
    @section('breadcrumb')
        @php
            $breadcrumbItems = [
                ['name' => 'Penjualan', 'url' => '#'],
                ['name' => 'Daftar Invoice', 'url' => route('penjualan.index')],
            ];
        @endphp
        <x-breadcrumb :items="$breadcrumbItems" />
    @endsection

    <div class="container-fluid d-flex flex-column min-vh-90 p-3 mb-auto">
        <div class="card">
            <div class="card-header pb-0">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-0">Daftar Invoice Penjualan</h6>
                        <p class="text-sm mb-0">
                            Menampilkan semua riwayat transaksi penjualan.
                        </p>
                    </div>
                    <a href="{{ route('penjualan.create') }}" class="btn btn-outline-info mb-0">
                        <i class="fa fa-plus me-2"></i>Buat Transaksi Baru
                    </a>
                </div>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <div class="table-responsive p-0 my-3">
                    <table class="table table-hover align-items-center mb-0">
                        <thead>
                            <tr class="table-secondary">
                                <th class="text-uppercase text-dark text-xs font-weight-bolder">Invoice</th>
                                <th class="text-uppercase text-dark text-xs font-weight-bolder ps-2">Tanggal</th>
                                <th class="text-uppercase text-dark text-xs font-weight-bolder ps-2">Pelanggan</th>
                                <th class="text-center text-uppercase text-dark text-xs font-weight-bolder">Total</th>
                                <th class="text-center text-uppercase text-dark text-xs font-weight-bolder">Status</th>
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
                                        <span class="text-secondary text-xs font-weight-bold">Rp {{ number_format($item->total_akhir, 0, ',', '.') }}</span>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <span class="badge badge-sm bg-gradient-success">{{ $item->status }}</span>
                                    </td>
                                    <td class="align-middle text-center">
                                        <a href="{{ route('penjualan.show', $item->id) }}" class="text-secondary font-weight-bold text-xs px-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Lihat Detail">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="#" class="text-danger font-weight-bold text-xs"
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
                                    <td colspan="6" class="text-center py-5">
                                        <p class="text-muted mb-0">Belum ada data penjualan.</p>
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

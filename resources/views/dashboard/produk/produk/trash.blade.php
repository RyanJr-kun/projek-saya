<x-layout>

    @section('breadcrumb')
        @php
        $breadcrumbItems = [
            ['name' => 'Page', 'url' => '#'],
            ['name' => 'Manajemen Produk', 'url' => route('produk.index')],
            ['name' => 'Produk Diarsipkan', 'url' => '#'],
        ];
        @endphp
        <x-breadcrumb :items="$breadcrumbItems" />
    @endsection

    <div class="container-fluid p-3">
        <div class="card">
            <div class="card-header pb-0 px-3 pt-2 mb-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-0">Produk Diarsipkan</h6>
                        <p class="text-sm mb-0">
                            Daftar produk yang telah dihapus (diarsipkan).
                        </p>
                    </div>
                </div>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <form id="bulk-action-form" method="POST">
                    @csrf
                    <div class="d-flex justify-content-between align-items-center p-3">
                        <div>
                            <button type="button" id="restore-selected-btn" class="btn btn-success btn-sm mb-0" disabled>
                                <i class="bi bi-arrow-counterclockwise pe-2"></i> Pulihkan yang Dipilih
                            </button>
                            <button type="button" id="force-delete-selected-btn" class="btn btn-danger btn-sm mb-0 ms-2" disabled>
                                <i class="bi bi-trash-fill pe-2"></i> Hapus Permanen
                            </button>
                        </div>
                        <a href="{{ route('produk.index') }}" class="btn btn-outline-primary btn-sm mb-0">
                            <i class="bi bi-arrow-left pe-2"></i> Kembali ke Daftar Produk
                        </a>
                    </div>
                    <div class="table-responsive p-0">
                    <table class="table table-hover align-items-center pb-3" id="tableData">
                        <thead>
                            <tr class="table-secondary">
                                <th class="text-center" style="width: 10px;">
                                    <input class="form-check-input" type="checkbox" id="check-all">
                                </th>
                                <th class="text-uppercase text-dark text-xs font-weight-bolder">Produk</th>
                                <th class="text-uppercase text-dark text-xs font-weight-bolder ps-2">Kategori</th>
                                <th class="text-uppercase text-dark text-xs font-weight-bolder ps-2">Brand</th>
                                <th class="text-uppercase text-dark text-xs font-weight-bolder ps-2">Dihapus Pada</th>
                                <th class="text-dark"></th>
                            </tr>
                        </thead>
                        <tbody id="isiTable">
                            @forelse ($produk as $produks)
                            <tr>
                                <td class="text-center">
                                    <input class="form-check-input check-item" type="checkbox" name="produk_ids[]" value="{{ $produks->id }}">
                                </td>
                                <td>
                                    <div title="gambar & nama produk" class="d-flex px-2 py-1">
                                        <div>
                                            @if ($produks->img_produk)
                                                <img src="{{ asset('storage/' . $produks->img_produk) }}" class="avatar avatar-lg me-3" alt="{{ $produks->nama_produk }}">
                                            @else
                                                <img src="{{ asset('assets/img/produk.webp') }}" class="avatar avatar-lg me-3" alt="Gambar produk default">
                                            @endif
                                        </div>
                                        <div class="d-flex flex-column justify-content-start">
                                            <h6 class="mb-0 text-sm">{{ $produks->nama_produk }}</h6>
                                            <p title="SKU" class="text-xs fw-bold mb-0 text-sm">SKU : {{ $produks->sku }}</p>
                                        </div>
                                    </div>
                                </td>

                                <td>
                                    <p title="kategori produk" class="text-xs text-dark fw-bold mb-0 ">{{ $produks->kategori_produk->nama }}</p>
                                </td>
                                <td>
                                    <p title="nama brand/merek poduk" class="text-xs text-dark fw-bold mb-0 ">{{ $produks->brand->nama }}</p>
                                </td>
                                <td>
                                    <p title="Tanggal dihapus" class="text-xs text-dark fw-bold mb-0">{{ $produks->deleted_at->translatedFormat('d M Y, H:i') }}</p>
                                </td>

                                <td class="align-middle pe-3">
                                    {{-- Tombol Restore --}}
                                    <a href="#" class="text-dark restore-btn"
                                        onclick="event.preventDefault(); document.getElementById('restore-form-{{ $produks->slug }}').submit();"
                                        title="Pulihkan produk">
                                        <i class="bi bi-arrow-counterclockwise text-success text-sm opacity-10"></i>
                                    </a>
                                    <form id="restore-form-{{ $produks->slug }}" action="{{ route('produk.restore', $produks->slug) }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>

                                    {{-- Tombol Hapus Permanen --}}
                                    <a href="#" class="text-dark mx-3 force-delete-btn"
                                        data-bs-toggle="modal"
                                        data-bs-target="#forceDeleteModal"
                                        data-product-slug="{{ $produks->slug }}"
                                        data-product-name="{{ $produks->nama_produk }}"
                                        title="Hapus permanen">
                                        <i class="bi bi-trash-fill text-danger text-sm opacity-10"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-3">
                                        <p class="text-dark text-sm fw-bold mb-0">Tidak ada produk yang diarsipkan.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="my-3 ms-3">{{ $produk->onEachSide(1)->links() }}</div>
                    </div>
                </form>
                </div>
        </div>

        {{-- Modal Konfirmasi Hapus Permanen --}}
        <div class="modal fade" id="forceDeleteModal" tabindex="-1" aria-labelledby="forceDeleteModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body text-center mt-3 mx-n5">
                        <i class="bi bi-exclamation-triangle-fill fa-2x text-danger mb-3"></i>
                        <h5 class="mb-2">Hapus Permanen!</h5>
                        <p class="mb-0">Anda yakin ingin menghapus produk ini secara permanen? Tindakan ini <strong>tidak dapat</strong> dibatalkan.</p>
                        <h6 class="mt-2" id="productNameToForceDelete"></h6>
                        <div class="mt-4">
                            <form id="forceDeleteForm" method="POST" class="d-inline">
                                @method('delete')
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm">Ya, Hapus Permanen</button>
                            </form>
                            <button type="button" class="btn btn-outline-secondary btn-sm ms-2" data-bs-dismiss="modal">Batal</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const forceDeleteModal = document.getElementById('forceDeleteModal');
                if (forceDeleteModal) {
                    forceDeleteModal.addEventListener('show.bs.modal', function (event) {
                        const button = event.relatedTarget;
                        const productSlug = button.getAttribute('data-product-slug');
                        const productName = button.getAttribute('data-product-name');

                        const modalBodyName = forceDeleteModal.querySelector('#productNameToForceDelete');
                        modalBodyName.textContent = productName;

                        const form = forceDeleteModal.querySelector('#forceDeleteForm');
                        form.action = `/produk/${productSlug}/force-delete`;
                    });
                }

                // --- BULK RESTORE LOGIC ---
                const checkAll = document.getElementById('check-all');
                const checkItems = document.querySelectorAll('.check-item');
                const bulkActionForm = document.getElementById('bulk-action-form');
                const restoreSelectedBtn = document.getElementById('restore-selected-btn');
                const forceDeleteSelectedBtn = document.getElementById('force-delete-selected-btn');

                function toggleActionButtons() {
                    const anyChecked = Array.from(checkItems).some(item => item.checked);
                    restoreSelectedBtn.disabled = !anyChecked;
                    forceDeleteSelectedBtn.disabled = !anyChecked;
                }

                if (checkAll) {
                    checkAll.addEventListener('change', function() {
                        checkItems.forEach(item => {
                            item.checked = this.checked;
                        });
                        toggleActionButtons();
                    });
                }

                checkItems.forEach(item => {
                    item.addEventListener('change', function() {
                        checkAll.checked = Array.from(checkItems).every(i => i.checked);
                        toggleActionButtons();
                    });
                });

                if (restoreSelectedBtn) {
                    restoreSelectedBtn.addEventListener('click', function() {
                        const checkedCount = document.querySelectorAll('.check-item:checked').length;

                        Swal.fire({
                            title: `Pulihkan ${checkedCount} Produk?`,
                            text: "Anda yakin ingin memulihkan semua produk yang dipilih?",
                            icon: 'question',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Ya, pulihkan!',
                            cancelButtonText: 'Batal'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                bulkActionForm.action = "{{ route('produk.restoreMultiple') }}";
                                bulkActionForm.submit();
                            }
                        });
                    });
                }

                if (forceDeleteSelectedBtn) {
                    forceDeleteSelectedBtn.addEventListener('click', function() {
                        const checkedCount = document.querySelectorAll('.check-item:checked').length;

                        Swal.fire({
                            title: `Hapus ${checkedCount} Produk Secara Permanen?`,
                            text: "Anda yakin? Tindakan ini tidak dapat dibatalkan!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#d33',
                            cancelButtonColor: '#3085d6',
                            confirmButtonText: 'Ya, hapus permanen!',
                            cancelButtonText: 'Batal'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                bulkActionForm.action = "{{ route('produk.forceDeleteMultiple') }}";
                                bulkActionForm.submit();
                            }
                        });
                    });
                }

                // Initial check in case of back navigation with form state preserved
                toggleActionButtons();
            });
        </script>
    @endpush
</x-layout>

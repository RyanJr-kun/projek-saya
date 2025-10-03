<x-layout>
    @section('breadcrumb')
        @php
            $breadcrumbItems = [
                ['name' => 'Page', 'url' => '#'],
                ['name' => 'Manajemen Promosi', 'url' => route('promo.index')],
            ];
        @endphp
        <x-breadcrumb :items="$breadcrumbItems" />
    @endsection

    <div class="container-fluid p-3">
        <div class="card rounded-2">
            <div class="card-header pb-0 px-3 pt-2">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-n1">Daftar Promo & Diskon</h6>
                        <p class="text-sm mb-0">Kelola semua promosi dan diskon <br class="d-sm-none"> Anda di sini.</p>
                    </div>
                    <div class="ms-md-auto mt-2">
                        <a href="{{ route('promo.create') }}" class="btn btn-outline-info mb-0">
                            <i class="fa fa-plus me-2"></i>Promo
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <div class="filter-container p-3">
                    <div class="row g-3 align-items-center justify-content-between">
                        <div class="col-md-4">
                            <input type="text" name="search" id="searchInput" class="form-control" placeholder="Cari nama atau kode promo..." value="{{ request('search') }}">
                        </div>
                        <div class="col-md-3">
                            <select name="status" id="statusFilter" class="form-select">
                                <option value="">Semua Status</option>
                                <option value="1" @selected(request('status') == '1')>Aktif</option>
                                <option value="0" @selected(request('status') == '0')>Tidak Aktif</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div id="promo-table-container">
                    @include('dashboard.promo._promo_table')
                </div>
            </div>
        </div>

        {{-- Modal Delete Confirmation --}}
        <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body text-center mt-3 mx-n5">
                        <i class="bi bi-trash fa-2x text-danger mb-3"></i>
                        <p class="mb-0">Apakah Anda yakin ingin menghapus promo ini?</p>
                        <h6 class="mt-2" id="promoNameToDelete"></h6>
                        <div class="mt-4">
                            <form id="deletePromoForm" method="POST" action="#">
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
    </div>

    @push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // --- MODAL DELETE ---
            const deleteModal = document.getElementById('deleteConfirmationModal');
            if (deleteModal) {
                deleteModal.addEventListener('show.bs.modal', function (event) {
                    const button = event.relatedTarget;
                    const promoId = button.getAttribute('data-promo-id');
                    const promoName = button.getAttribute('data-promo-name');
                    const modalBodyName = deleteModal.querySelector('#promoNameToDelete');
                    const deleteForm = deleteModal.querySelector('#deletePromoForm');

                    modalBodyName.textContent = promoName;
                    deleteForm.action = `{{ url('promo') }}/${promoId}`;
                });
            }

            // --- AJAX FILTER & SEARCH ---
            function debounce(func, delay) {
                let timeout;
                return function(...args) {
                    clearTimeout(timeout);
                    timeout = setTimeout(() => func.apply(this, args), delay);
                };
            }

            function fetchData(page = 1) {
                let search = $('#searchInput').val();
                let status = $('#statusFilter').val();
                let url = '{{ route("promo.index") }}';

                $('#promo-table-container').css('opacity', 0.5);

                $.ajax({
                    url: url,
                    data: { search: search, status: status, page: page },
                    success: function(data) {
                        $('#promo-table-container').html(data).css('opacity', 1);
                        window.history.pushState({path:url + '?page=' + page + '&search=' + search + '&status=' + status},'',url + '?page=' + page + '&search=' + search + '&status=' + status);
                    },
                    error: function() {
                        $('#promo-table-container').css('opacity', 1);
                        Swal.fire('Gagal', 'Gagal memuat data. Silakan coba lagi.', 'error');
                    }
                });
            }

            $('#searchInput').on('keyup', debounce(function() {
                fetchData(1);
            }, 500));

            $('#statusFilter').on('change', function() {
                fetchData(1);
            });

            $(document).on('click', '#promo-table-container .pagination a', function(e) {
                e.preventDefault();
                let page = $(this).attr('href').split('page=')[1];
                if (page) {
                    fetchData(page);
                }
            });
        });
    </script>
    @endpush
</x-layout>

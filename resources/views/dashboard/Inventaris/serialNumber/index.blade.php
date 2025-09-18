<x-layout>
    @push('styles')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
        <link rel="stylesheet"
            href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    @endpush
    {{-- breadcrumb --}}
    @section('breadcrumb')
        @php
            $breadcrumbItems = [
                ['name' => 'Inventaris', 'url' => '#'],
                ['name' => 'Manajemen Nomor Seri', 'url' => route('serialNumber.index')],
            ];
        @endphp
        <x-breadcrumb :items="$breadcrumbItems" />
    @endsection

    <div class="container-fluid p-3">
        {{-- Card 1: Form Pendaftaran Nomor Seri --}}
        <div class="card rounded-2 mb-4">
            <div class="card-header pb-0 px-3 pt-2">
                <h6 class="mb-0">Pendaftaran Nomor Seri</h6>
                <p class="text-sm mb-0">Tambah nomor seri untuk produk yang membutuhkannya.</p>
            </div>
            <div class="card-body pt-2">
                <form id="addMultipleSerialsForm" onsubmit="return false;">
                    @csrf
                    <input type="hidden" name="produk_id" id="selected_produk_id">
                    <div class="row g-3">
                        <div class="col-md-7">
                            <label for="select-produk" class="form-label">Pilih Produk:</label>
                            <select id="select-produk" class="form-control"></select>
                        </div>
                        <div class="col-md-5 d-flex">
                            <div class="w-100 me-3">
                                <label for="input-serial" class="form-label">Input Nomor Seri:</label>
                                <input type="text" id="input-serial" class="form-control" placeholder="Scan atau ketik nomor seri lalu tekan Enter">
                            </div>
                            <div>
                                <button type="button" id="btn-add-to-table" class="btn btn-outline-info" style="margin-top: 30px;">Tambah</button>
                            </div>
                        </div>
                        <div class="col-md-5 d" id="product-info-container" style="display: none;">
                            <div class="card bg-gray-100 shadow-none">
                                <div class="card-body p-2">
                                    <div class="d-flex justify-content-around text-center">
                                        <div>
                                            <h6 class="mb-0" id="info-stok">0</h6>
                                            <p class="text-xs fw-bold mb-0">Stok</p>
                                        </div>
                                        <div>
                                            <h6 class="mb-0" id="info-sn-tercatat">0</h6>
                                            <p class="text-xs fw-bold mb-0">SN Tercatat</p>
                                        </div>
                                        <div>
                                            <h6 class="mb-0 text-danger" id="info-sn-butuh">0</h6>
                                            <p class="text-xs fw-bold mb-0">Butuh SN</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="serial-input-section" style="display: none;">

                        <div class="table-responsive p-0 mt-3" style="max-height: 300px; overflow-y: auto;">
                            <table class="table table-sm align-items-center" id="temp-serial-table">
                                <thead class="table-secondary">
                                    <tr>
                                        <th class="text-dark text-xs font-weight-bolder ps-2">No.</th>
                                        <th class="text-dark text-xs font-weight-bolder">Nomor Seri</th>
                                        <th class="text-dark text-xs font-weight-bolder">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- New serials will be added here by JS --}}
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-end mt-3">
                            <button type="button" id="btn-submit-serials" class="btn btn-info" disabled>Simpan Nomor Seri</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- Card 2: Daftar Nomor Seri (Existing Table) --}}
        <div class="card rounded-2">
            <div class="card-header pb-0 px-3 pt-2 mb-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-n1">Daftar Nomor Seri</h6>
                        <p class="text-sm mb-0">Kelola semua nomor seri produk Anda.</p>
                    </div>
                </div>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <form method="GET" action="{{ route('serialNumber.index') }}">
                    <div class="row g-3 px-3 align-items-center justify-content-start">
                        <div class="col-md-4">
                            <label for="search" class="form-label">Cari Nomor Seri</label>
                            <input type="text" id="search" name="search" class="form-control"
                                placeholder="Ketik nomor seri..." value="{{ request('search') }}">
                        </div>
                        <div class="col-md-3">
                            <label for="produk_id_filter" class="form-label">Filter Produk</label>
                            <select id="produk_id_filter" name="produk_id" class="form-select" style="width: 100%;">
                                <option value="">Semua Produk</option>
                                @foreach ($produks as $produk)
                                    <option value="{{ $produk->id }}" @selected(request('produk_id') == $produk->id)>
                                        {{ $produk->nama_produk }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="status_filter" class="form-label">Filter Status</label>
                            <select id="status_filter" name="status" class="form-select">
                                <option value="">Semua Status</option>
                                <option value="Tersedia" @selected(request('status') == 'Tersedia')>Tersedia</option>
                                <option value="Terjual" @selected(request('status') == 'Terjual')>Terjual</option>
                                <option value="Rusak" @selected(request('status') == 'Rusak')>Rusak</option>
                                <option value="Hilang" @selected(request('status') == 'Hilang')>Hilang</option>
                            </select>
                        </div>
                        <div class="col-md-3 d-flex align-items-end">
                            <button type="submit" class="btn btn-info me-2">Filter</button>
                            <a href="{{ route('serialNumber.index') }}" class="btn btn-secondary">Reset</a>
                        </div>
                    </div>
                </form>
                <div class="table-responsive p-0 mt-3">
                    <table class="table table-hover align-items-center mb-0" id="tableData">
                        <thead>
                            <tr class="table-secondary">
                                <th class="text-uppercase text-dark text-xs font-weight-bolder">Produk</th>
                                <th class="text-uppercase text-dark text-xs font-weight-bolder ps-2">Nomor Seri</th>
                                <th class="text-uppercase text-dark text-xs font-weight-bolder ps-2">Status</th>
                                <th class="text-uppercase text-dark text-xs font-weight-bolder ps-2">Tgl. Masuk</th>
                                <th class="text-uppercase text-dark text-xs font-weight-bolder ps-2">Info Penjualan</th>
                                <th class="text-dark">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="isiTable">
                            @forelse ($serialNumbers as $sn)
                                <tr>
                                    <td>
                                        <div class="d-flex ms-2 px-2 py-1 align-items-center">
                                            @if ($sn->produk->img_produk)
                                                <img src="{{ asset('storage/' . $sn->produk->img_produk) }}"
                                                    class="avatar avatar-sm me-3" alt="{{ $sn->produk->nama_produk }}">
                                            @else
                                                <img src="{{ asset('assets/img/produk.webp') }}"
                                                    class="avatar avatar-sm me-3" alt="Gambar produk default">
                                            @endif
                                            <h6 class="mb-0 text-sm">{{ $sn->produk->nama_produk }}</h6>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-xs text-dark fw-bold mb-0">{{ $sn->nomor_seri }}</p>
                                    </td>
                                    <td class="align-middle text-sm">
                                        @php
                                            $statusClass = '';
                                            switch ($sn->status) {
                                                case 'Tersedia':
                                                    $statusClass = 'badge-success';
                                                    break;
                                                case 'Terjual':
                                                    $statusClass = 'badge-info';
                                                    break;
                                                case 'Rusak':
                                                    $statusClass = 'badge-danger';
                                                    break;
                                                case 'Hilang':
                                                    $statusClass = 'badge-warning';
                                                    break;
                                            }
                                        @endphp
                                        <span class="badge {{ $statusClass }}">{{ $sn->status }}</span>
                                    </td>
                                    <td>
                                        <p class="text-xs text-dark fw-bold mb-0">
                                            {{ $sn->created_at->translatedFormat('d M Y') }}</p>
                                    </td>
                                    <td>
                                        @if ($sn->penjualan)
                                            <a href="{{ route('penjualan.show', $sn->penjualan->referensi) }}"
                                                class="text-info fw-bold text-xs" data-bs-toggle="tooltip"
                                                title="Lihat Invoice Penjualan">
                                                {{ $sn->penjualan->referensi }}
                                            </a>
                                        @else
                                            <p class="text-xs text-dark fw-bold mb-0">-</p>
                                        @endif
                                    </td>
                                    <td class="align-middle">
                                        <button type="button" class="btn btn-link text-dark p-0 m-0 btn-edit"
                                            data-id="{{ $sn->id }}" data-serial="{{ $sn->nomor_seri }}"
                                            data-status="{{ $sn->status }}" title="Edit SN">
                                            <i class="bi bi-pencil-square text-dark text-sm opacity-10"></i>
                                        </button>
                                        <button type="button" class="btn btn-link text-danger p-0 m-0 ms-2 btn-delete"
                                            data-id="{{ $sn->id }}" data-serial="{{ $sn->nomor_seri }}"
                                            title="Hapus SN">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4">Tidak ada data nomor seri yang cocok.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="my-3 ms-3">{{ $serialNumbers->links() }}</div>
                </div>
            </div>
        </div>

        {{-- modal edit --}}
        <div class="modal fade" id="editSerialModal" tabindex="-1" aria-labelledby="editSerialModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header border-0 mb-n3">
                        <h6 class="modal-title" id="editSerialModalLabel">Edit Nomor Seri</h6>
                        <button type="button" class="btn btn-close bg-danger rounded-3 me-1" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editSerialForm" method="post">
                            @method('put')
                            @csrf
                            <div class="mb-3">
                                <label for="edit_serial_number" class="form-label">Nomor Seri</label>
                                <input id="edit_serial_number" name="serial_number" type="text" class="form-control"
                                    required>
                                <div class="invalid-feedback" id="edit_serial_number-error"></div>
                            </div>
                            <div class="mb-3">
                                <label for="edit_status" class="form-label">Status</label>
                                <select id="edit_status" name="status" class="form-select" required>
                                    <option value="Tersedia">Tersedia</option>
                                    <option value="Terjual">Terjual</option>
                                    <option value="Rusak">Rusak</option>
                                    <option value="Hilang">Hilang</option>
                                </select>
                            </div>
                            <div class="modal-footer border-0 pb-0">
                                <button type="submit" class="btn btn-outline-info btn-sm">Simpan Perubahan</button>
                                <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">Batalkan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        {{-- modal delete --}}
        <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body text-center mt-3 mx-n5">
                        <i class="bi bi-trash fa-2x text-danger mb-3"></i>
                        <p class="mb-0">Apakah Anda yakin ingin menghapus Unit ini?</p>
                        <h6 class="mt-2" id="serialNumberToDelete"></h6>
                        <div class="mt-4">
                            <form id="deleteSerialForm" method="POST" action="#">
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
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function () {

            // --- GLOBAL VARIABLES & INITIALIZATION ---
            let tempSerials = new Set();
            let selectedProductData = null;
            const editSerialModal = new bootstrap.Modal(document.getElementById('editSerialModal'));
            const deleteSerialModal = new bootstrap.Modal(document.getElementById('deleteConfirmationModal'));

            // Initialize Select2 for the main filter dropdown
            $('#produk_id_filter').select2({
                theme: "bootstrap-5",
                placeholder: 'Semua Produk',
            });

            // --- UTILITY FUNCTIONS ---
            function showSuccess(message) {
                Swal.fire('Berhasil', message, 'success').then(() => location.reload());
            }

            function showError(message, errors = {}) {
                let errorText = message;
                if (Object.keys(errors).length > 0) {
                    // Ambil pesan error pertama dari validasi
                    errorText = Object.values(errors).flat()[0];
                }
                Swal.fire('Gagal', errorText, 'error');
            }

            // --- NEW SERIAL REGISTRATION WORKFLOW ---

            function formatProduk(produk) {
                if (!produk.id) return produk.text;
                const defaultImage = "{{ asset('assets/img/produk.webp') }}";
                const imageUrl = produk.img_produk ? `{{ asset('storage/') }}/${produk.img_produk}` : defaultImage;
                return $(
                    `<div class="d-flex align-items-center">
                        <img src="${imageUrl}" class="avatar avatar-sm me-3" />
                        <div>
                            <h6 class="mb-0 text-sm">${produk.text}</h6>
                            <p class="text-xs text-muted mb-0">Stok: ${produk.qty}</p>
                        </div>
                    </div>`
                );
            }

            // 1. Initialize Select2 for the new product search input
            $('#select-produk').select2({
                theme: "bootstrap-5",
                placeholder: 'Ketik untuk mencari produk',
                templateResult: formatProduk,
                templateSelection: (produk) => produk.text,
                ajax: {
                    url: "{{ route('get-data.produk') }}",
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            search: params.term,
                            page: params.page || 1,
                            wajib_seri: 1
                        };
                    },
                    processResults: function(data, params) {
                        return {
                            results: data.data.map(function(item) {
                                return {
                                    id: item.id,
                                    text: item.nama_produk,
                                    img_produk: item.img_produk,
                                    qty: item.qty,
                                    sn_count: item.serial_numbers_count
                                };
                            }),
                            pagination: {
                                more: (params.page * 10) < data.total
                            }
                        };
                        }
                    }
                });

            // 2. Handle product selection
            $('#select-produk').on('select2:select', function (e) {
                selectedProductData = e.params.data;
                $('#selected_produk_id').val(selectedProductData.id);

                // Update info card
                const butuhSn = selectedProductData.qty - selectedProductData.sn_count;
                $('#info-stok').text(selectedProductData.qty);
                $('#info-sn-tercatat').text(selectedProductData.sn_count);
                $('#info-sn-butuh').text(butuhSn > 0 ? butuhSn : 0);

                // Show sections
                $('#product-info-container').show();
                $('#serial-input-section').show();
                $('#input-serial').focus();
            });

            // 3. Add serial number to temporary table
            function addSerialToTempTable() {
                const serialInput = $('#input-serial');
                const serialValue = serialInput.val().trim();

                if (serialValue && !tempSerials.has(serialValue)) {
                    tempSerials.add(serialValue);
                    renderTempTable();
                    serialInput.val('').focus();
                } else if (tempSerials.has(serialValue)) {
                    Swal.fire('Duplikat', 'Nomor seri sudah ada di dalam daftar.', 'warning');
                }
            }

            $('#btn-add-to-table').on('click', addSerialToTempTable);
            $('#input-serial').on('keypress', function(e) {
                if (e.which === 13) { // Enter key
                    e.preventDefault();
                    addSerialToTempTable();
                }
            });

            // 4. Render the temporary serials table
            function renderTempTable() {
                const tableBody = $('#temp-serial-table tbody');
                tableBody.empty();
                let counter = 1;
                tempSerials.forEach(serial => {
                    const row = `
                        <tr>
                            <td class="ps-2">${counter++}</td>
                            <td>${serial}</td>
                            <td>
                                <button type="button" class="btn btn-link text-danger p-0 m-0 btn-remove-temp" data-serial="${serial}">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                    `;
                    tableBody.append(row);
                });
                $('#btn-submit-serials').prop('disabled', tempSerials.size === 0);
            }

            // 5. Remove serial from temporary table
            $('#temp-serial-table').on('click', '.btn-remove-temp', function() {
                const serialToRemove = $(this).data('serial');
                tempSerials.delete(serialToRemove);
                renderTempTable();
            });

            // 6. Submit all temporary serials
            $('#btn-submit-serials').on('click', function() {
                const productId = $('#selected_produk_id').val();
                const serials = Array.from(tempSerials);

                if (!productId || serials.length === 0) {
                    Swal.fire('Error', 'Pilih produk dan tambahkan minimal satu nomor seri.', 'error');
                    return;
                }

                $.ajax({
                    url: "{{ route('serialNumber.store') }}",
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        produk_id: productId,
                        serial_numbers: serials // Send as an array
                    },
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: response.message,
                        }).then(() => {
                            location.reload();
                        });
                    },
                    error: function(xhr) {
                        const response = xhr.responseJSON;
                        showError(response.message || 'Terjadi kesalahan.', response.errors || {});
                    }
                });
            });



            // --- EXISTING TABLE & MODALS LOGIC ---
            // --- SUBMIT FORM TAMBAH SN ---
            $('#addMultipleSerialsForm').on('submit', function(e) {
                e.preventDefault();
                const form = $(this);
                // This logic is now handled by the new workflow above.
                // This block can be removed to avoid confusion.
            });


            // --- MODAL EDIT ---
            // Corrected the table ID from #serialNumberTable to #tableData
            $('#tableData').on('click', '.btn-edit', function() {
                const serialId = $(this).data('id');
                const serialNumber = $(this).data('serial');
                const status = $(this).data('status');

                // Corrected input ID from #edit_nomor_seri to #edit_serial_number
                $('#edit_serial_number').val(serialNumber);
                $('#edit_status').val(status);
                $('#editSerialForm').attr('action', `/serialNumber/${serialId}`);

                // Disable status 'Terjual' because it should only be changed by sales transaction
                $('#edit_status option[value="Terjual"]').prop('disabled', true);

                editSerialModal.show();
            });

            // --- SUBMIT FORM EDIT ---
            $('#editSerialForm').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    url: $(this).attr('action'),
                    method: 'POST', // Laravel handles PUT via _method field
                    data: $(this).serialize(),
                    success: function(response) {
                        editSerialModal.hide();
                        showSuccess(response.message);
                    },
                    error: function(xhr) {
                        editSerialModal.hide();
                        const response = xhr.responseJSON;
                        showError(response.message, response.errors);
                    }
                });
            });

           // --- MODAL DELETE ---
            // Corrected the table ID from #serialNumberTable to #tableData
            $('#tableData').on('click', '.btn-delete', function() {
                const serialId = $(this).data('id');
                const serialNumber = $(this).data('serial');
                $('#deleteSerialForm').attr('action', `/serialNumber/${serialId}`);
                $('#serialNumberToDelete').text(serialNumber);
                deleteSerialModal.show();
            });

            // --- SUBMIT FORM DELETE ---
            $('#deleteSerialForm').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    url: $(this).attr('action'),
                    method: 'POST', // Laravel handles DELETE via _method field
                    data: $(this).serialize(),
                    success: function(response) {
                        deleteSerialModal.hide();
                        showSuccess(response.message);
                    },
                    error: function(xhr) {
                        deleteSerialModal.hide();
                        showError(xhr.responseJSON.message);
                    }
                });
            });

            // Clear validation on modal close
            $('.modal').on('hidden.bs.modal', function() {
                $(this).find('.is-invalid').removeClass('is-invalid');
                $(this).find('.invalid-feedback').text('');
                $(this).find('form').trigger('reset');
            });
        });
    </script>
    @endpush
</x-layout>

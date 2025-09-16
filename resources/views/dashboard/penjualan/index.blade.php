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
                                        <div class="d-flex flex-column justify-content-center px-2 py-1">
                                            <h6 class="mb-0 text-sm">{{ $item->pelanggan->nama ?? 'Pelanggan Umum' }}</h6>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="mb-0 text-sm">{{ $item->nomer_invoice }}</h6>
                                            <p class="text-xs text-secondary mb-0">Kasir: {{ $item->user->nama ?? 'N/A' }}</p>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">{{ $item->created_at->translatedFormat('d M Y, H:i') }}</p>
                                    </td>
                                    <td class="align-middle text-center">
                                        <span class="text-secondary text-xs fw-bold">Rp {{ number_format($item->total_akhir, 0, ',', '.') }}</span>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <span class="badge badge-sm {{ $item->status === 'Lunas' ? 'bg-gradient-success' : ($item->status === 'Belum Lunas' ? 'bg-gradient-danger' : 'bg-gradient-warning') }}">{{ $item->status }}</span>
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
                                        <a href="#" class="text-info fw-bold text-xs px-2 edit-penjualan-btn"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editPenjualanModal"
                                            data-penjualan-id="{{ $item->id }}"
                                            title="Edit Transaksi">
                                            <i class="bi bi-pencil-square"></i>
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

    {{-- Modal Edit Penjualan --}}
    <div class="modal fade" id="editPenjualanModal" tabindex="-1" aria-labelledby="editPenjualanModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="editPenjualanModalLabel">Edit Transaksi Penjualan</h6>
                    <button type="button" class="btn btn-close bg-danger rounded-3 me-1" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="edit-modal-spinner" class="text-center py-5">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-2">Memuat data transaksi...</p>
                    </div>
                    <form id="editPenjualanForm" style="display: none;">
                        @method('put')
                        @csrf
                        <div class="row g-3">
                            {{-- Informasi Dasar --}}
                            <div class="col-md-3">
                                <label for="edit_pelanggan_id" class="form-label">Pelanggan</label>
                                <select name="pelanggan_id" id="edit_pelanggan_id" class="form-select" required>
                                    @foreach ($pelanggans as $pelanggan)
                                        <option value="{{ $pelanggan->id }}">{{ $pelanggan->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="edit_tanggal_penjualan" class="form-label">Tanggal</label>
                                <input type="datetime-local" name="tanggal_penjualan" id="edit_tanggal_penjualan" class="form-control" required>
                            </div>
                            <div class="col-md-3">
                                <label for="edit_metode_pembayaran" class="form-label">Metode Pembayaran</label>
                                <select name="metode_pembayaran" id="edit_metode_pembayaran" class="form-select" required>
                                    <option value="TUNAI">Tunai</option>
                                    <option value="TRANSFER">Transfer</option>
                                    <option value="QRIS">QRIS</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="edit_nomer_invoice" class="form-label">No. Invoice</label>
                                <input type="text" name="nomer_invoice" id="edit_nomer_invoice" class="form-control" readonly>
                            </div>
                            <div class="col-12">
                                <label for="edit_catatan" class="form-label">Catatan (Opsional)</label>
                                <textarea name="catatan" id="edit_catatan" class="form-control" rows="2"></textarea>
                            </div>

                            {{-- Pencarian Produk --}}
                            <div class="col-12">
                                <label for="edit_produk_search" class="form-label">Cari & Tambah Produk</label>
                                <select id="edit_produk_search" class="form-control"></select>
                            </div>

                            {{-- Tabel Item --}}
                            <div class="col-12 table-responsive" style="max-height: 300px; overflow-y: auto;">
                                <table class="table table-sm table-hover align-items-center" id="edit_items_table">
                                    <thead class="table-secondary sticky-top">
                                        <tr>
                                            <th class="text-dark text-xs font-weight-bolder">Produk</th>
                                            <th class="text-dark text-xs font-weight-bolder text-center">Qty</th>
                                            <th class="text-dark text-xs font-weight-bolder">Harga Jual</th>
                                            <th class="text-dark text-xs font-weight-bolder">Pajak (%)</th>
                                            <th class="text-dark text-xs font-weight-bolder">Diskon (Rp)</th>
                                            <th class="text-dark text-xs font-weight-bolder">Subtotal</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- Items will be injected here by JS --}}
                                    </tbody>
                                </table>
                            </div>

                            {{-- Rincian Biaya --}}
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="edit_service" class="form-label">Service</label>
                                        <input type="number" name="service" id="edit_service" class="form-control" value="0" min="0">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="edit_ongkir" class="form-label">Ongkir</label>
                                        <input type="number" name="ongkir" id="edit_ongkir" class="form-control" value="0" min="0">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="edit_diskon" class="form-label">Diskon Global</label>
                                        <input type="number" name="diskon" id="edit_diskon" class="form-control" value="0" min="0">
                                    </div>
                                </div>
                            </div>

                            {{-- Total & Pembayaran --}}
                            <div class="col-md-4">
                                <h5 class="fw-bold">Total: <span id="edit_total_akhir">Rp 0</span></h5>
                                <label for="edit_jumlah_dibayar" class="form-label">Jumlah Dibayar</label>
                                <input type="number" name="jumlah_dibayar" id="edit_jumlah_dibayar" class="form-control" value="0" min="0">
                            </div>
                        </div>
                        <div class="modal-footer mt-4">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-info">Simpan Perubahan</button>
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // --- MODAL DELETE ---
            const deleteModal = document.getElementById('deleteConfirmationModal');
            if (deleteModal) {
                deleteModal.addEventListener('show.bs.modal', function (event) {
                    const button = event.relatedTarget;
                    const invoiceId = button.getAttribute('data-invoice-id');
                    const invoiceNumber = button.getAttribute('data-invoice-number');
                    const form = deleteModal.querySelector('#deleteInvoiceForm');
                    const text = deleteModal.querySelector('#invoiceNumberToDelete');

                    if (text) text.textContent = invoiceNumber;
                    if (form) form.action = `/penjualan/${invoiceId}`;
                });
            }

            // --- MODAL EDIT ---
            const editModal = document.getElementById('editPenjualanModal');
            const editForm = document.getElementById('editPenjualanForm');
            const spinner = document.getElementById('edit-modal-spinner');
            let itemCounter = 0;

            const formatCurrency = (number) => new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(number);

            // Initialize Select2 for product search
            const productSearch = $('#edit_produk_search').select2({
                theme: "bootstrap-5",
                placeholder: 'Ketik untuk mencari produk...',
                dropdownParent: $('#editPenjualanModal'),
                ajax: {
                    url: "{{ route('get-data.produk') }}",
                    dataType: 'json',
                    delay: 250,
                    data: params => ({ search: params.term, page: params.page || 1 }),
                    processResults: data => ({
                        results: data.map(item => ({
                            id: item.id,
                            text: item.nama_produk,
                            harga_jual: item.harga_jual,
                            stok: item.qty
                        }))
                    }),
                    cache: true
                }
            });

            // Handle adding product from Select2
            productSearch.on('select2:select', function (e) {
                const data = e.params.data;
                addItemToTable(data.id, data.text, 1, data.harga_jual, 0);
                $(this).val(null).trigger('change'); // Reset select2
                calculateTotals();
            });

            // Function to add item row to table
            function addItemToTable(produk_id, nama, qty, harga, diskon, pajak_persen = 0) {
                // Cek jika produk sudah ada di tabel
                let existingRow = $(`#edit_items_table tbody tr[data-produk-id="${produk_id}"]`);
                if (existingRow.length > 0) {
                    // Jika sudah ada, cukup tambahkan kuantitasnya
                    let currentQtyInput = existingRow.find(".item-qty");
                    let newQty = parseInt(currentQtyInput.val()) + parseInt(qty);
                    currentQtyInput.val(newQty).trigger('input'); // Update qty dan trigger kalkulasi
                    return;
                }

                const subtotal = (qty * harga) - diskon;
                const newRow = `
                    <tr data-produk-id="${produk_id}">
                        <input type="hidden" name="items[${itemCounter}][produk_id]" value="${produk_id}" class="item-produk-id">
                        <td><p class="text-sm fw-bold mb-0">${nama}</p></td>
                        <td class="text-center" style="width: 15%;">
                            <input type="number" name="items[${itemCounter}][jumlah]" class="form-control form-control-sm text-center item-qty" value="${qty}" min="1">
                        </td>
                        <td style="width: 20%;">
                            <input type="number" name="items[${itemCounter}][harga_jual]" class="form-control form-control-sm item-harga" value="${harga}" min="0">
                        </td>
                        <td style="width: 15%;">
                            <input type="number" name="items[${itemCounter}][pajak_persen]" class="form-control form-control-sm item-pajak" value="${pajak_persen}" min="0">
                        </td>
                        <td style="width: 20%;">
                            <input type="number" name="items[${itemCounter}][diskon]" class="form-control form-control-sm item-diskon" value="${diskon}" min="0">
                        </td>
                        <td class="item-subtotal text-sm fw-bold">${formatCurrency(subtotal)}</td>
                        <td>
                            <button type="button" class="btn btn-link text-danger p-0 m-0 btn-remove-item">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>
                `;
                $('#edit_items_table tbody').append(newRow);
                itemCounter++;
            }

            // Function to calculate totals
            function calculateTotals() {
                let subtotalKeseluruhan = 0;
                let totalPajak = 0;
                $('#edit_items_table tbody tr').each(function() {
                    const qty = parseFloat($(this).find('.item-qty').val()) || 0;
                    const harga = parseFloat($(this).find('.item-harga').val()) || 0;
                    const diskon = parseFloat($(this).find('.item-diskon').val()) || 0;
                    const pajakPersen = parseFloat($(this).find('.item-pajak').val()) || 0;
                    const subtotal = (qty * harga) - diskon;
                    const pajakAmount = subtotal * (pajakPersen / 100);
                    $(this).find('.item-subtotal').text(formatCurrency(subtotal));
                    subtotalKeseluruhan += subtotal;
                    totalPajak += pajakAmount;
                });

                const service = parseFloat($('#edit_service').val()) || 0;
                const ongkir = parseFloat($('#edit_ongkir').val()) || 0;
                const diskonGlobal = parseFloat($('#edit_diskon').val()) || 0;

                const totalAkhir = subtotalKeseluruhan + totalPajak + service + ongkir - diskonGlobal;
                $('#edit_total_akhir').text(formatCurrency(totalAkhir));
            }

            // Event delegation for dynamic elements
            $('#edit_items_table').on('input', '.item-qty, .item-harga, .item-diskon, .item-pajak', calculateTotals);
            $('#edit_items_table').on('click', '.btn-remove-item', function() {
                $(this).closest('tr').remove();
                calculateTotals();
            });
            $('#editPenjualanForm').on('input', '#edit_service, #edit_ongkir, #edit_diskon', calculateTotals);


            // Handle modal show event
            editModal.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;
                const penjualanId = button.getAttribute('data-penjualan-id');
                const url = `/penjualan/${penjualanId}/json`; // Pastikan route ini ada

                // Set form action
                editForm.action = `/penjualan/${penjualanId}`;

                // Show spinner, hide form
                spinner.style.display = 'block';
                editForm.style.display = 'none';
                $('#edit_items_table tbody').empty(); // Clear table

                fetch(url)
                    .then(response => {
                        if (!response.ok) throw new Error('Gagal memuat data.');
                        return response.json();
                    })
                    .then(data => {
                        // Populate form fields
                        $('#edit_pelanggan_id').val(data.pelanggan_id);
                        // Gunakan tanggal_penjualan dan format untuk input datetime-local
                        const date = new Date(data.tanggal_penjualan);
                        const formattedDate = date.getFullYear() + '-' +
                            ('0' + (date.getMonth() + 1)).slice(-2) + '-' +
                            ('0' + date.getDate()).slice(-2) + 'T' +
                            ('0' + date.getHours()).slice(-2) + ':' +
                            ('0' + date.getMinutes()).slice(-2);
                        $('#edit_tanggal_penjualan').val(formattedDate);
                        $('#edit_metode_pembayaran').val(data.metode_pembayaran);
                        $('#edit_catatan').val(data.catatan);
                        $('#edit_nomer_invoice').val(data.referensi); // Sesuaikan dengan nama kolom di DB
                        $('#edit_service').val(data.service);
                        $('#edit_ongkir').val(data.ongkir);
                        $('#edit_diskon').val(data.diskon);
                        $('#edit_jumlah_dibayar').val(data.jumlah_dibayar);

                        // Populate items table
                        itemCounter = 0;
                        data.items.forEach(item => { // pajak_item / subtotal * 100
                            const pajakPersen = item.subtotal > 0 ? (item.pajak_item / item.subtotal) * 100 : 0;
                            addItemToTable(item.produk_id, item.produk.nama_produk, item.jumlah, item.harga, item.diskon_item, pajakPersen.toFixed(2));
                        });

                        calculateTotals();

                        // Hide spinner, show form
                        spinner.style.display = 'none';
                        editForm.style.display = 'block';
                    })
                    .catch(error => {
                        spinner.innerHTML = `<p class="text-danger">${error.message}</p>`;
                    });
            });

            // Handle form submission with AJAX
            editForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(this);
                const url = this.action;

                fetch(url, {
                    method: 'POST', // Laravel handles PUT/PATCH via _method field
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    },
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    const editModalInstance = bootstrap.Modal.getInstance(editModal);
                    if (data.success) {
                        editModalInstance.hide();
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: data.message,
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => {
                            window.location.reload();
                        });
                    } else {
                        // Menampilkan error dari server (misal: validasi, stok tidak cukup)
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: data.message || 'Terjadi kesalahan yang tidak diketahui.',
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Terjadi kesalahan saat mengirim data ke server.',
                    });
                });
            });
        });
    </script>
    @endpush
</x-layout>

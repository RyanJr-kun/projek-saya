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
                                <th class="text-uppercase text-dark text-xs fw-bolder text-center">Status Pembayaran</th>
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
                                        <a href="{{ route('penjualan.show', $item->referensi) }}" class="text-dark fw-bold text-xs px-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Lihat Detail">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="#" class="text-info fw-bold text-xs px-2 edit-penjualan-btn"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editPenjualanModal"
                                            data-penjualan-ref="{{ $item->referensi }}"
                                            title="Edit Transaksi">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <a href="#" class="text-danger fw-bold text-xs"
                                            data-bs-toggle="modal"
                                            data-bs-target="#deleteConfirmationModal"
                                            data-invoice-ref="{{ $item->referensi }}"
                                            data-invoice-number="{{ $item->referensi }}"
                                            title="Hapus Transaksi">
                                            <i class="bi bi-trash"></i>
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

                            <div class="col-md-3 ms-auto">
                                <label for="edit_nomer_invoice" class="form-label">No. Invoice</label>
                                <input type="text" name="nomer_invoice" id="edit_nomer_invoice" class="form-control" readonly>
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
                            <div class="col-3 d-md-block d-none">
                                <label for="edit_metode_pembayaran" class="form-label">Metode Pembayaran</label>
                                <select name="metode_pembayaran" id="edit_metode_pembayaran" class="form-select" required>
                                    <option value="TUNAI">Tunai</option>
                                    <option value="TRANSFER">Transfer</option>
                                    <option value="QRIS">QRIS</option>
                                </select>
                            </div>
                            <div class="col-3 mt-3">
                                <label for="status_pembayaran_select" class="form-label">Status Pembayaran</label>
                                <select name="status_pembayaran" id="status_pembayaran_select" class="form-select" required>
                                    <option value="Lunas">Lunas</option>
                                    <option value="Belum Lunas">Belum Lunas</option>
                                    <option value="Dibatalkan">Dibatalkan</option>
                                </select>
                            </div>

                            {{-- Total & Pembayaran --}}
                            <div class="col-12 col-md-6 mt-3">
                                <div class="d-flex justify-content-between align-items-center" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#editExtraCostModal" data-type="service" data-label="Service">
                                    <p class="text-sm mb-0">Service</p>
                                    <p class="text-sm font-weight-bold mb-0" id="edit_service_display">Rp 0</p>
                                    <input type="hidden" name="service" id="edit_service" value="0">
                                </div>
                                <div class="d-flex justify-content-between align-items-center my-2" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#editExtraCostModal" data-type="ongkir" data-label="Ongkos Kirim">
                                    <p class="text-sm mb-0">Ongkir</p>
                                    <p class="text-sm font-weight-bold mb-0" id="edit_ongkir_display">Rp 0</p>
                                    <input type="hidden" name="ongkir" id="edit_ongkir" value="0">
                                </div>
                                <div class="d-flex justify-content-between align-items-center" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#editExtraCostModal" data-type="diskon" data-label="Diskon Global">
                                    <p class="text-sm mb-0">Diskon Global (Rp)</p>
                                    <p class="text-sm font-weight-bold mb-0" id="edit_diskon_display">Rp 0</p>
                                    <input type="hidden" name="diskon" id="edit_diskon" value="0">
                                </div>
                                <div class="d-flex justify-content-between">
                                    <h6 class="font-weight-bold ">Total</h6>
                                    <h6 class="font-weight-bold" id="edit_total_akhir">Rp 0</h6>
                                </div>
                                <div class="d-flex justify-content-between mt-2">
                                    <label for="edit_jumlah_dibayar" class="form-label mb-0 align-self-center">Jumlah Dibayar</label>
                                    <div style="width: 150px;">
                                        <input type="text" name="jumlah_dibayar" id="edit_jumlah_dibayar" class="form-control text-end" value="0">
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <label for="edit_catatan" class="form-label">Catatan (Opsional)</label>
                                <div id="edit_quill_catatan" style="height: 80px;"></div>
                                <input type="hidden" name="catatan" id="edit_catatan_hidden">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" form="editPenjualanForm" class="btn btn-outline-info">Simpan Perubahan</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Edit Item Detail --}}
    <div class="modal fade" id="editItemDetailModal" tabindex="-1" aria-labelledby="editItemDetailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editItemDetailModalLabel">Edit Item</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editItemDetailForm" onsubmit="return false;">
                        <input type="hidden" id="edit_item_produk_id">
                        <div class="mb-3">
                            <label class="form-label">Nama Produk</label>
                            <input type="text" class="form-control" id="edit_item_nama" readonly disabled>
                        </div>
                        <div class="row g-3">
                            <div class="col-6">
                                <label for="edit_item_qty" class="form-label">Qty</label>
                                <input type="number" class="form-control" id="edit_item_qty" min="1" required>
                            </div>
                            <div class="col-6">
                                <label for="edit_item_harga" class="form-label">Harga Jual</label>
                                <input type="text" class="form-control" id="edit_item_harga" placeholder="0">
                            </div>
                            <div class="col-6">
                                <label for="edit_item_pajak" class="form-label">Pajak (%)</label>
                                <input type="number" class="form-control" id="edit_item_pajak" placeholder="0" min="0">
                            </div>
                            <div class="col-6">
                                <label for="edit_item_diskon" class="form-label">Diskon (Rp)</label>
                                <input type="text" class="form-control" id="edit_item_diskon" placeholder="0">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-info" id="saveItemDetailChangesBtn">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Edit Biaya Tambahan (Service, Ongkir, Diskon) --}}
    <div class="modal fade" id="editExtraCostModal" tabindex="-1" aria-labelledby="editExtraCostModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="editExtraCostModalLabel">Edit Biaya</h6>
                    <button type="button" class="btn bg-dark btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editExtraCostForm" onsubmit="return false;">
                        <input type="hidden" id="extra-cost-type">
                        <div class="form-group">
                            <label for="extra-cost-value" class="form-control-label" id="extra-cost-label">Jumlah</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="text" class="form-control" id="extra-cost-value" min="0" required>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-info" id="saveExtraCostBtn">Simpan</button>
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
                    const invoiceRef = button.getAttribute('data-invoice-ref');
                    const invoiceNumber = button.getAttribute('data-invoice-number');
                    const form = deleteModal.querySelector('#deleteInvoiceForm');
                    const text = deleteModal.querySelector('#invoiceNumberToDelete');

                    if (text) text.textContent = invoiceNumber;
                    if (form) form.action = `/penjualan/${invoiceRef}`;
                });
            }

            // --- MODAL EDIT ---
            const editModal = document.getElementById('editPenjualanModal');
            const editForm = document.getElementById('editPenjualanForm');
            const spinner = document.getElementById('edit-modal-spinner');
            let editQuill = null; // Untuk instance Quill
            let itemCounter = 0;

            const formatCurrency = (number) => new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(number);
            const parseCurrency = (string) => parseFloat(String(string).replace(/[^0-9]/g, '')) || 0;

            function formatInputAsCurrency(input) {
                let value = input.val();
                let number = parseCurrency(value);
                input.val(new Intl.NumberFormat('id-ID').format(number));
            }

            // Inisialisasi modal anak
            const editItemDetailModal = new bootstrap.Modal(document.getElementById('editItemDetailModal'));

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
                addItemToTable(data.id, data.text, 1, data.harga_jual, 0, 0);
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
                        <input type="hidden" name="items[${itemCounter}][produk_id]" value="${produk_id}">
                        <input type="hidden" name="items[${itemCounter}][jumlah]" class="item-qty-hidden" value="${qty}">
                        <input type="hidden" name="items[${itemCounter}][harga_jual]" class="item-harga-hidden" value="${harga}">
                        <input type="hidden" name="items[${itemCounter}][diskon]" class="item-diskon-hidden" value="${diskon}">
                        <input type="hidden" name="items[${itemCounter}][pajak_persen]" class="item-pajak-hidden" value="${pajak_persen}">

                        <td><p class="text-sm fw-bold mb-0">${nama}</p></td>
                        <td class="text-center text-sm item-qty">${qty}</td>
                        <td class="text-sm item-harga">${formatCurrency(harga)}</td>
                        <td class="text-sm item-pajak">${pajak_persen}%</td>
                        <td class="text-sm item-diskon">${formatCurrency(diskon)}</td>
                        <td class="item-subtotal text-sm fw-bold">${formatCurrency(subtotal)}</td>
                        <td>
                            <div class="d-flex">
                                <button type="button" class="btn btn-link text-info p-0 m-0 me-2 btn-edit-item" title="Edit Item"><i class="bi bi-pencil-square"></i></button>
                                <button type="button" class="btn btn-link text-danger p-0 m-0 btn-remove-item" title="Hapus Item"><i class="bi bi-trash"></i></button>
                            </div>
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
                    const qty = parseFloat($(this).find('.item-qty-hidden').val()) || 0;
                    const harga = parseFloat($(this).find('.item-harga-hidden').val()) || 0;
                    const diskon = parseFloat($(this).find('.item-diskon-hidden').val()) || 0;
                    const pajakPersen = parseFloat($(this).find('.item-pajak-hidden').val()) || 0;
                    const subtotal = (qty * harga) - diskon;
                    const pajakAmount = subtotal * (pajakPersen / 100);
                    $(this).find('.item-subtotal').text(formatCurrency(subtotal));
                    subtotalKeseluruhan += subtotal;
                    totalPajak += pajakAmount;
                });

                const service = parseCurrency($('#edit_service').val());
                const ongkir = parseCurrency($('#edit_ongkir').val());
                const diskonGlobal = parseCurrency($('#edit_diskon').val());

                const totalAkhir = subtotalKeseluruhan + totalPajak + service + ongkir - diskonGlobal;
                $('#edit_total_akhir').text(formatCurrency(totalAkhir));
            }

            // Event delegation for dynamic elements
            $('#edit_items_table').on('click', '.btn-edit-item', function() {
                const row = $(this).closest('tr');
                const produkId = row.data('produk-id');

                $('#edit_item_produk_id').val(produkId);
                $('#edit_item_nama').val(row.find('td:first p').text());
                $('#edit_item_qty').val(row.find('.item-qty-hidden').val());
                $('#edit_item_harga').val(row.find('.item-harga-hidden').val());
                $('#edit_item_pajak').val(row.find('.item-pajak-hidden').val());
                $('#edit_item_diskon').val(row.find('.item-diskon-hidden').val());

                editItemDetailModal.show();
            });

            $('#saveItemDetailChangesBtn').on('click', function() {
                const produkId = $('#edit_item_produk_id').val();
                const row = $(`#edit_items_table tbody tr[data-produk-id="${produkId}"]`);

                const newQty = $('#edit_item_qty').val();
                const newHarga = parseCurrency($('#edit_item_harga').val());
                const newPajak = $('#edit_item_pajak').val();
                const newDiskon = parseCurrency($('#edit_item_diskon').val());

                row.find('.item-qty-hidden').val(newQty);
                row.find('.item-harga-hidden').val(newHarga);
                row.find('.item-pajak-hidden').val(newPajak);
                row.find('.item-diskon-hidden').val(newDiskon);

                row.find('.item-qty').text(newQty);
                row.find('.item-harga').text(formatCurrency(newHarga));
                row.find('.item-pajak').text(newPajak + '%');
                row.find('.item-diskon').text(formatCurrency(newDiskon));

                calculateTotals();
                editItemDetailModal.hide();
            });

            $('#edit_item_harga, #edit_item_diskon').on('input', function() { formatInputAsCurrency($(this)); });

            $('#edit_items_table').on('click', '.btn-remove-item', function() {
                $(this).closest('tr').remove();
                calculateTotals();
            });

            // --- Extra Cost Modal Logic ---
            const extraCostModal = new bootstrap.Modal(document.getElementById('editExtraCostModal'));
            const extraCostModalEl = document.getElementById('editExtraCostModal');

            extraCostModalEl.addEventListener('show.bs.modal', function (event) {
                const triggerElement = event.relatedTarget;
                const type = triggerElement.dataset.type;
                const label = triggerElement.dataset.label;
                const currentValue = $(`#edit_${type}`).val();

                $('#extra-cost-type').val(type);
                $('#editExtraCostModalLabel').text(`Edit ${label}`);
                $('#extra-cost-label').text(label);
                $('#extra-cost-value').val(currentValue);
                formatInputAsCurrency($('#extra-cost-value'));
                setTimeout(() => $('#extra-cost-value').focus(), 500);
            });

            $('#saveExtraCostBtn').on('click', function() {
                const type = $('#extra-cost-type').val();
                const newValue = parseCurrency($('#extra-cost-value').val());

                $(`#edit_${type}`).val(newValue);
                $(`#edit_${type}_display`).text(formatCurrency(newValue));

                extraCostModal.hide();
                calculateTotals();
            });
            $('#extra-cost-value, #edit_jumlah_dibayar').on('input', function() { formatInputAsCurrency($(this)); });

            // Handle modal show event
            editModal.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;
                const penjualanRef = button.getAttribute('data-penjualan-ref');
                const url = `/penjualan/${penjualanRef}/json`; // Pastikan route ini ada

                // Set form action
                editForm.action = `/penjualan/${penjualanRef}`;

                // Show spinner, hide form
                spinner.style.display = 'block';
                editForm.style.display = 'none';
                $('#edit_items_table tbody').empty(); // Clear table

                // Initialize Quill
                if (!editQuill) {
                    editQuill = new Quill('#edit_quill_catatan', {
                        theme: 'snow',
                        placeholder: 'Tulis catatan di sini...'
                    });
                }
                editQuill.on('text-change', function() {
                    $('#edit_catatan_hidden').val(editQuill.root.innerHTML);
                });


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

                        // Set Quill content
                        editQuill.root.innerHTML = data.catatan || '';
                        $('#edit_catatan_hidden').val(data.catatan || '');

                        $('#edit_nomer_invoice').val(data.referensi); // Sesuaikan dengan nama kolom di DB

                        $('#edit_service').val(data.service);
                        $('#edit_ongkir').val(data.ongkir);
                        $('#edit_diskon').val(data.diskon);
                        $('#edit_service_display').text(formatCurrency(data.service));
                        $('#edit_ongkir_display').text(formatCurrency(data.ongkir));
                        $('#edit_diskon_display').text(formatCurrency(data.diskon));
                        $('#edit_jumlah_dibayar').val(data.jumlah_dibayar);

                        // Populate items table
                        itemCounter = 0;
                        data.items.forEach(item => { // pajak_item / subtotal * 100
                            const namaProduk = item.produk?.nama_produk ?? '[Produk Dihapus]';
                            const pajakPersen = item.subtotal > 0 ? (item.pajak_item / item.subtotal) * 100 : 0;
                            addItemToTable(item.produk_id, namaProduk, item.jumlah, item.harga, item.diskon_item, pajakPersen.toFixed(2));
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

            editModal.addEventListener('hidden.bs.modal', function() {
                if (editQuill) {
                    editQuill.off('text-change'); // Hapus listener untuk mencegah duplikasi
                }
            });


            // Handle form submission with AJAX
            editForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(this);
                const url = this.action;

                // Ambil nilai mentah dari input jumlah dibayar
                const rawJumlahDibayar = parseCurrency($('#edit_jumlah_dibayar').val());
                formData.set('jumlah_dibayar', rawJumlahDibayar);

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

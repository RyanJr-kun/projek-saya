<x-layout>

    @section('breadcrumb')
        @php
        // Definisikan item breadcrumb dalam bentuk array
        $breadcrumbItems = [
            ['name' => 'Page', 'url' => '#'],
            ['name' => 'Manajemen Produk', 'url' => route('produk.index')],
        ];
        @endphp
        <x-breadcrumb :items="$breadcrumbItems" />
    @endsection

    <div class="container-fluid p-3">
        <div class="card">
            <div class="card-header pb-0 px-3 pt-2 mb-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-0">Data Produk</h6>
                            <p class="text-sm mb-0">
                            Kelola Data Produkmu
                        </p>
                    </div>
                    <div class="ms-auto mt-2">
                        <div class="d-none d-md-block">
                            <a href="#Export-Pdf" type="button" class="btn btn-outline-danger me-2 p-2 mb-0" title="Export PDF">
                                <img src="assets/img/pdf.png" alt="Download PDF" width="20" height="20">
                            </a>
                            <a href="#Export-Excel" class="btn btn-outline-success p-2 me-2 export mb-0" data-type="csv" type="button" title="Export Excel">
                                <img src="assets/img/xls.png" alt="Download Excel" width="20" height="20">
                            </a>
                            <a href="{{ route('produk.trash') }}" class="btn btn-outline-secondary mb-0" title="Produk Diarsipkan">
                                <i class="bi bi-trash3"></i>
                            </a>
                            <a href="{{ route('produk.create') }}">
                                <button class="btn btn-outline-info mb-0">
                                    <i class="bi bi-plus-lg cursor-pointer pe-2"></i> Produk
                                </button>
                            </a>
                        </div>
                        <div class="dropdown d-block d-md-none ">
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
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('produk.trash') }}">
                                        <i class="bi bi-trash3 me-2"></i>Produk Diarsipkan</a>
                                </li>
                                <li>
                                    <a class="dropdown-item text-info " href="{{ route('produk.create') }}">
                                        <i class="bi bi-plus-lg  cursor-pointer pe-2"></i> Produk
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <div class="row g-3 align-items-center justify-content-between">
                    <div class="col-5 col-lg-3 ms-3">
                        <input type="text" id="searchInput" class="form-control" placeholder="Cari Produk...">
                    </div>
                    <div class="col-5 col-lg-2 me-3">
                        <select id="posisiFilter" class="form-select">
                            <option value="">Semua Kategori</option>
                        </select>
                    </div>
                </div>
                <div class="table-responsive p-0 mt-3">
                    <table class="table table-hover align-items-center pb-3" id="tableData">
                        <thead>
                            <tr class="table-secondary">
                                <th class="text-uppercase text-dark text-xs font-weight-bolder">Produk</th>
                                <th class="text-uppercase text-dark text-xs font-weight-bolder ps-2">Kategori</th>
                                <th class="text-uppercase text-dark text-xs font-weight-bolder ps-2">Brand</th>
                                <th class="text-uppercase text-dark text-xs font-weight-bolder ps-2">Harga Jual</th>
                                <th class="text-uppercase text-dark text-xs font-weight-bolder ps-2">Unit</th>
                                <th class="text-uppercase text-dark text-xs font-weight-bolder ps-2">Qty</th>
                                <th class="text-uppercase text-dark text-xs font-weight-bolder">Pembuat</th>
                                <th class="text-dark"></th>
                            </tr>
                        </thead>
                        <tbody id="isiTable">
                            @forelse ($produk as $produks)
                            <tr>
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
                                            <p title="SKU" class="text-xs fw-bold mb-0 text-sm">SKU : {{ $produks->sku }}
                                            </p>
                                            <p title="Barcode" class="text-xs fw-bold mb-0 text-sm">Barcode : {{ $produks->barcode }}
                                            </p>
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
                                    <p title="harga jual" class="text-xs text-dark fw-bold mb-0">{{ $produks->harga_formatted }}</p>
                                </td>
                                <td>
                                    <p title="jenis unit" class="text-xs text-dark fw-bold mb-0">{{ $produks->unit->nama }}</p>
                                </td>
                                <td>
                                    <span title="Jumlah Barang" class="text-dark text-xs fw-bold ">{{ $produks->qty }}</span>
                                </td>

                                <td>
                                    <div title="foto & nama user" class="d-flex align-items-center px-2 py-1">
                                        @if ($produks->user->img_user)
                                            <img src="{{ asset('storage/' . $produks->user->img_user) }}" class="avatar avatar-sm me-3" alt="user_img">
                                        @else
                                            <img src="{{ asset('assets/img/user.webp') }}" class="avatar avatar-sm me-3" alt="Gambar produk default">
                                        @endif
                                        <h6 class="mb-0 text-sm">{{ $produks->user->nama }}</h6>
                                    </div>
                                </td>

                                <td class="align-middle pe-3">
                                    <a href="{{ route('produk.show', $produks->slug) }}" class="text-dark" data-toggle="tooltip" data-original-title="Detail produk">
                                        <i class="fa fa-eye text-dark text-sm opacity-10"></i>
                                    </a>
                                    <a href="{{ route('produk.edit', $produks->slug) }}" class="text-dark mx-3" data-toggle="tooltip" data-original-title="Edit produk">
                                        <i class="fa fa-pen-to-square text-dark text-sm opacity-10"></i>
                                    </a>
                                    <a href="#" class="text-dark delete-product-btn"
                                        data-bs-toggle="modal"
                                        data-bs-target="#deleteConfirmationModal"
                                        data-product-slug="{{ $produks->slug }}"
                                        data-product-name="{{ $produks->nama_produk }}"
                                        title="Hapus produk">
                                        <i class="bi bi-trash text-dark text-sm opacity-10"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center py-3">
                                        <p class="text-dark text-sm fw-bold mb-0">Belum ada data produk.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="my-3 ms-3">{{ $produk->onEachSide(1)->links() }}</div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body text-center mt-3 mx-n5">
                        <i class="fa fa-trash fa-2x text-danger mb-3"></i>
                        <p class="mb-0">apakah kamu yakin ingin menghapus produk ini?</p>
                        <h6 class="mt-2" id="productNameToDelete"></h6>
                        <div class="mt-4">
                            <form id="deleteProductForm" method="POST" class="d-inline" data-base-url="{{ url('produk') }}">
                                @method('delete')
                                @csrf
                                <button class="btn btn-danger btn-sm">Ya, Hapus</button>
                            </form>
                            <button type="button" class="btn btn-outline-secondary btn-sm ms-2" data-bs-dismiss="modal">Batalkan</button>
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
                //search
                const checkAll = document.getElementById('check-all');
                const checkItems = document.querySelectorAll('.check-item');

                if (checkAll) { // Pastikan elemen ada sebelum menambahkan event
                    checkAll.addEventListener('change', function() {
                        checkItems.forEach(item => {
                            item.checked = this.checked;
                            const row = item.closest('tr');
                            row.classList.toggle('row-checked', this.checked);
                        });
                    });

                    checkItems.forEach(item => {
                        item.addEventListener('change', function() {
                            const row = this.closest('tr');
                            row.classList.toggle('row-checked', this.checked);
                            checkAll.checked = Array.from(checkItems).every(i => i.checked);
                        });
                    });
                }
                //filter
                const searchInput = document.getElementById('searchInput');
                const brandFilter = document.getElementById('posisiFilter'); // Sebenarnya ini filter Brand
                const tableBody = document.getElementById('isiTable');
                const rows = tableBody.getElementsByTagName('tr');

                function populateBrandFilter() {
                    const brandSet = new Set();
                    for (let row of rows) {
                        const brandCell = row.getElementsByTagName('td')[3]; // Target Kolom 4: Brand
                        if (brandCell) {
                            const brandText = brandCell.querySelector('p').textContent.trim();
                            brandSet.add(brandText);
                        }
                    }
                    brandSet.forEach(brand => {
                        const option = document.createElement('option');
                        option.value = brand;
                        option.textContent = brand;
                        brandFilter.appendChild(option);
                    });
                }

                function filterTable() {
                    const searchText = searchInput.value.toLowerCase();
                    const brandValue = brandFilter.value;

                    for (let row of rows) {
                        const namaCell = row.getElementsByTagName('td')[1];   // Target Kolom 2: Nama Produk
                        const brandCell = row.getElementsByTagName('td')[3]; // Target Kolom 4: Brand

                        if (namaCell && brandCell) {
                            const namaText = namaCell.querySelector('h6').textContent.toLowerCase();
                            const brandText = brandCell.querySelector('p').textContent;

                            const namaMatch = namaText.includes(searchText);
                            const brandMatch = (brandValue === "" || brandText === brandValue);

                            row.style.display = (namaMatch && brandMatch) ? "" : "none";
                        }
                    }
                }

                if (rows.length > 0) {
                    populateBrandFilter();
                    searchInput.addEventListener('keyup', filterTable);
                    brandFilter.addEventListener('change', filterTable);
                }
                //scrollbar
                var win = navigator.platform.indexOf('Win') > -1;
                if (win && document.querySelector('#sidenav-scrollbar')) {
                    var options = {
                        damping: '0.5'
                    }
                    Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
                }

                // --- MODAL DELETE (AJAX) ---
                const deleteModal = document.getElementById('deleteConfirmationModal');
                const deleteForm = document.getElementById('deleteProductForm');
                let productRowToDelete = null; // Variabel untuk menyimpan baris tabel yang akan dihapus

                if (deleteModal && deleteForm) {
                    deleteModal.addEventListener('show.bs.modal', function (event) {
                        const button = event.relatedTarget; // Tombol yang memicu modal
                        const productSlug = button.getAttribute('data-product-slug');
                        const productName = button.getAttribute('data-product-name');

                        // Simpan referensi ke baris <tr> untuk dihapus nanti
                        productRowToDelete = button.closest('tr');

                        // Isi konten modal
                        const modalBodyName = deleteModal.querySelector('#productNameToDelete');
                        modalBodyName.textContent = productName;

                        // Atur action form untuk URL fetch
                        const baseUrl = deleteForm.getAttribute('data-base-url');
                        deleteForm.action = `${baseUrl}/${productSlug}`;
                    });

                    deleteForm.addEventListener('submit', function(e) {
                        e.preventDefault(); // Mencegah submit form tradisional

                        const url = this.action;
                        const token = this.querySelector('input[name="_token"]').value;

                        fetch(url, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': token,
                                'Accept': 'application/json' // Penting agar Laravel merespons dengan JSON
                            }
                        })
                        .then(response => {
                            bootstrap.Modal.getInstance(deleteModal).hide();
                            return response.json();
                        })
                        .then(data => {
                            if (data.success) {
                                // Hapus baris dari tabel tanpa reload
                                productRowToDelete.remove();
                                Swal.fire({ icon: 'success', title: 'Berhasil!', text: data.message, timer: 2000, showConfirmButton: false });
                            } else {
                                Swal.fire({ icon: 'error', title: 'Gagal!', text: data.message });
                            }
                        })
                        .catch(error => {
                            Swal.fire({ icon: 'error', title: 'Oops...', text: 'Terjadi kesalahan jaringan.' });
                        });
                    });
                }
            });
        </script>
    @endpush
</x-layout>

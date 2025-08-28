<x-layout>

    @section('breadcrumb')
        @php
        // Definisikan item breadcrumb dalam bentuk array
        $breadcrumbItems = [
            ['name' => 'Page', 'url' => '/dashboard'],
            ['name' => 'Manajemen Produk', 'url' => route('produk.index')],
        ];
        @endphp
        <x-breadcrumb :items="$breadcrumbItems" />
    @endsection

    @if (session()->has('success'))
        <div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 1055">
            <div id="successToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header bg-success text-white">
                    <span class="alert-icon text-light me-2"><i class="fa fa-thumbs-up"></i></span>
                    <strong class="me-auto">Notifikasi</strong>
                    <small class="text-light">Baru saja</small>
                    <button type="button" class="btn-close btn-light" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    {{ session('success') }}
                </div>
            </div>
        </div>
    @endif

    <div class="container-fluid d-flex flex-column min-vh-90 p-3 mb-auto ">
        <div class="card mb-4 ">
            <div class="card-header pb-0 px-3 pt-2 mb-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0">Data Produk</h5>
                            <p class="text-sm mb-0">
                            Kelola Data Produkmu
                        </p>
                    </div>
                    <div class="ms-auto my-auto mt-md-0 mb-3">
                        <div>
                            <div class="d-none d-md-block mt-2">
                                <a href="#Export-Pdf" type="button" class="btn btn-outline-danger me-2 p-2 mb-0" title="Export PDF">
                                    <img src="assets/img/pdf.png" alt="Download PDF" width="20" height="20">
                                </a>
                                <a href="#Export-Excel" class="btn btn-outline-success p-2 me-2 export mb-0" data-type="csv" type="button" title="Export Excel">
                                    <img src="assets/img/xls.png" alt="Download Excel" width="20" height="20">
                                </a>
                                <a href="{{ route('produk.create') }}">
                                    <button class="btn btn-outline-info mb-0">
                                        <i class="bi bi-plus-lg cursor-pointer pe-2"></i>Buat produk
                                    </button>
                                </a>
                            </div>
                            <div class="dropdown d-block d-md-none mt-3 ">
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
                                    <li>
                                        <a class="dropdown-item text-success" href="{{ route('produk.create') }}">
                                            <i class="bi bi-plus-lg  cursor-pointer pe-2"></i>Buat Produk
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <div class="filter-container mb-3">
                    <div class="row g-3 align-items-center justify-content-between">
                        <!-- Filter Pencarian Nama -->
                        <div class="col-5 col-lg-3 ms-3">
                            <input type="text" id="searchInput" class="form-control" placeholder="cari produk ...">
                        </div>
                        <!-- Filter Dropdown Posisi -->
                        <div class="col-5 col-lg-2 me-3">
                            <select id="posisiFilter" class="form-select">
                                <option value="">Semua kategori</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="table-responsive p-0 mt-4">
                    <table class="table table-hover align-items-center pb-3" id="tableData">
                        <thead>
                            <tr class="table-secondary">
                                <th class="text-uppercase text-dark text-xs font-weight-bolder">
                                    <input type="checkbox" id="check-all" class="me-4">SKU</th>
                                <th class="text-uppercase text-dark text-xs font-weight-bolder">Nama Produk</th>
                                <th class="text-uppercase text-dark text-xs font-weight-bolder ps-2">Kategori</th>
                                <th class="text-uppercase text-dark text-xs font-weight-bolder ps-2">Brand</th>
                                <th class="text-uppercase text-dark text-xs font-weight-bolder ps-2">Harga</th>
                                <th class="text-uppercase text-dark text-xs font-weight-bolder ps-2">Unit</th>
                                <th class="text-uppercase text-dark text-xs font-weight-bolder ps-2">Qty</th>
                                <th class="text-uppercase text-dark text-xs font-weight-bolder">Pembuat</th>
                                <th class="text-dark"></th>
                            </tr>
                        </thead>
                        <tbody id="isiTable">
                            @foreach ($produk as $produks)
                            <tr>
                                <td class="ps-4">
                                    <input name="checkboxSKU" type="checkbox" class="check-item me-4 dark mb-0">
                                    <span title="SKU" class="text-xs text-dark fw-bold mb-0 text-sm">{{ $produks->sku }}</span>
                                </td>

                                <td>
                                    <div title="gambar & nama produk" class="d-flex align-items-center px-2 py-1">
                                        @if ($produks->img_produk)
                                            <img src="{{ asset('storage/' . $produks->img_produk) }}" class="avatar avatar-sm me-3" alt="{{ $produks->nama_produk }}">
                                        @else
                                            <img src="{{ asset('assets/img/produk.webp') }}" class="avatar avatar-sm me-3" alt="Gambar produk default">
                                        @endif
                                        <h6 class="mb-0 text-sm">{{ $produks->nama_produk }}</h6>
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
                                        <img src="{{ asset('storage/' . $produks->user->img_user) }}" class="avatar avatar-sm me-3" alt="user_img">
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
                            @endforeach
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
                        <p class="mb-0">Are you sure you want to delete product?</p>
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
        <script>
            document.addEventListener('DOMContentLoaded', function () {
            // 1. Ambil semua elemen yang dibutuhkan
            const checkAll = document.getElementById('check-all');
            const checkItems = document.querySelectorAll('.check-item');

            // 2. Fungsi saat "Check All" di-klik
            checkAll.addEventListener('change', function () {
                // Ulangi semua checkbox item
                checkItems.forEach(item => {
                    // Set status centang item sama dengan status "Check All"
                    item.checked = this.checked;

                    // Tambah atau hapus class 'row-checked' pada baris (tr)
                    const row = item.closest('tr');
                    if (this.checked) {
                        row.classList.add('row-checked');
                    } else {
                        row.classList.remove('row-checked');
                    }
                });
            });

            // 3. Fungsi saat salah satu item di-klik
            checkItems.forEach(item => {
                item.addEventListener('change', function () {
                    const row = this.closest('tr');

                    // Tambah atau hapus class 'row-checked' berdasarkan status centang
                    if (this.checked) {
                        row.classList.add('row-checked');
                    } else {
                        row.classList.remove('row-checked');
                    }

                    // Cek apakah semua item sudah dicentang
                    // Jika ya, maka centang juga "Check All"
                    const allChecked = Array.from(checkItems).every(i => i.checked);
                    checkAll.checked = allChecked;
                });
            });

            });
        </script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                //serch
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
                //notif toast
                var toastElement = document.getElementById('successToast');
                if (toastElement) {
                    var toast = new bootstrap.Toast(toastElement);
                    toast.show();
                }
            });
        </script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const deleteButtons = document.querySelectorAll('.delete-product-btn');
                const deleteForm = document.getElementById('deleteProductForm');
                if (deleteForm) {
                    const productNameElement = document.getElementById('productNameToDelete');
                    const baseUrl = deleteForm.getAttribute('data-base-url');

                    deleteButtons.forEach(button => {
                        button.addEventListener('click', function(event) {
                            event.preventDefault();
                            const productSlug = this.getAttribute('data-product-slug');
                            const productName = this.getAttribute('data-product-name');
                            const formAction = `${baseUrl}/${productSlug}`;
                            deleteForm.setAttribute('action', formAction);
                            if (productNameElement) {
                                productNameElement.textContent = productName;
                            }
                        });
                    });
                }
            });
        </script>
    @endpush
</x-layout>

<x-layout>
    {{-- breadcrumb --}}
    @section('breadcrumb')
        @php
        $breadcrumbItems = [
            ['name' => 'Page', 'url' => '/dashboard'],
            ['name' => 'Manajemen Unit', 'url' => route('unit.index')],
        ];
        @endphp
        <x-breadcrumb :items="$breadcrumbItems" />
    @endsection
    {{-- notif-success --}}
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
        <div class="row ">
            <div class="col-12 ">
                <div class="card mb-4 ">
                    <div class="card-header pb-0 p-3 mb-3">
                        <div class="d-flex flex-sm-row justify-content-sm-center align-items-sm-center">
                            <div class="mb-0">
                                <h5 class="mb-0">Data Unit</h5>
                                    <p class="text-sm mb-0">
                                    Kelola Data Unit Produkmu
                                </p>
                            </div>
                            <div class="ms-auto my-auto mt-lg-0">
                                <div class="ms-auto mb-0">
                                    {{-- triger-modal --}}
                                    <button class="btn btn-outline-info mb-0" data-bs-toggle="modal" data-bs-target="#import"><i class="fa fa-plus fixed-plugin-button-nav cursor-pointer pe-2"></i>Buat Unit</button>

                                    {{-- start-modal --}}
                                    <div class="modal fade" id="import" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header border-0 mb-n3">
                                                    <h6 class="modal-title" id="ModalLabel">Buat Unit Baru</h6>
                                                    <button type="button" class="btn btn-close bg-danger rounded-3 me-1" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('unit.store') }}" method="post" >
                                                        @csrf
                                                        <div class="row">
                                                            <div class="form-group">

                                                                <div class="mb-3">
                                                                    <label for="nama" class="form-label ">Unit</label>
                                                                    <input id="nama" name="nama" type="string" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama') }}" required>
                                                                    @error('nama')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                    @enderror
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="slug" class="form-label">Slug</label>
                                                                    <input id="slug" name="slug" type="string" class="form-control @error('slug') is-invalid @enderror"  value="{{ old('slug') }}" required>
                                                                    @error('slug')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                    @enderror
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="singkat" class="form-label">Nama Pendek</label>
                                                                    <input id="singkat" name="singkat" type="string" class="form-control @error('singkat') is-invalid @enderror"  value="{{ old('singkat') }}" required>
                                                                    @error('singkat')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                    @enderror
                                                                </div>

                                                                <div class="justify-content-end form-check form-switch form-check-reverse">
                                                                    <label class="me-auto form-check-label" for="status">Status</label>
                                                                    <input id="status" class="form-check-input" type="checkbox" name="status" value="1" checked>
                                                                </div>

                                                            </div>
                                                        </div>
                                                        <div class="modal-footer border-0 pb-0">
                                                            <button type="submit" class="btn btn-info btn-sm">Buat Unit</button>
                                                            <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">Batalkan</button>
                                                        </div>
                                                    </form>

                                                    <script>
                                                        document.addEventListener('DOMContentLoaded', function () {
                                                            const hasError = document.querySelector('.is-invalid');
                                                                if (hasError) {
                                                                    var importModal = new bootstrap.Modal(document.getElementById('import'));
                                                                    importModal.show();
                                                                }
                                                            });
                                                    </script>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- end-modal --}}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="filter-container">
                            <div class="row g-3 align-items-center justify-content-between">
                                <!-- Filter Pencarian Unit -->
                                <div class="col-5 col-lg-3 ms-3">
                                    <input type="text" id="searchInput" class="form-control" placeholder="cari Unit ...">
                                </div>
                                <!-- Filter Dropdown Status -->
                                <div class="col-5 col-lg-2 me-3">
                                    <select id="statusFilter" class="form-select">
                                        <option value="">Semua Status</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    <div class="table-responsive p-0 mt-4">
                        <table class="table table-hover align-items-center justify-content-start mb-0" id="tableData">
                        <thead>
                            <tr class="table-secondary">
                            <th class="text-uppercase text-dark text-xs font-weight-bolder">Nama</th>
                            <th class="text-uppercase text-dark text-xs font-weight-bolder ps-2">Singkatan</th>
                            <th class="text-uppercase text-dark text-xs font-weight-bolder ps-2">Jumlah Produk</th>
                            <th class="text-uppercase text-dark text-xs font-weight-bolder ps-2">Dibuat Tanggal</th>
                            <th class="text-center text-uppercase text-dark text-xs font-weight-bolder">status</th>
                            <th class="text-dark"></th>
                            </tr>
                        </thead>
                        <tbody id="isiTable">
                            @foreach ($units as $unit)
                            <tr>
                            <td>
                                <div class="d-flex ms-2 px-2 py-1 align-items-center">
                                    <p class="mb-0 text-xs text-dark fw-bold">{{ $unit->nama }}</p>
                                </div>
                            </td>
                            <td>
                                <p class="text-xs text-dark fw-bold mb-0">{{ $unit->singkat }}</p>
                            </td>
                            <td>
                                <p class="text-xs text-dark fw-bold mb-0">{{ $unit->produks_count }}</p>
                            </td>
                            <td>
                                <p class="text-xs text-dark fw-bold mb-0">{{ $unit->created_at->translatedFormat('d M Y') }}</p>
                            </td>

                            <td class="align-middle text-center text-sm">
                                @if ($unit->status)
                                    <span class="badge badge-success">Aktif</span>
                                @else
                                    <span class="badge badge-secondary">Tidak Aktif</span>
                                @endif
                            </td>

                            <td class="align-middle">
                                {{-- <a href="/#" class="text-dark fw-bold pe-3 text-xs" data-toggle="tooltip"
                                    data-original-title="Detail user">
                                    <i class="fa fa-eye text-dark text-sm opacity-10"></i>
                                </a> --}}
                                <a href="#" class="text-dark fw-bold px-3 text-xs"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editModal"
                                    data-url="{{ route('unit.getjson', $unit->slug) }}"
                                    data-update-url="{{ route('unit.update', $unit->slug) }}"
                                    title="Edit unit">
                                    <i class="bi bi-pencil-square text-dark text-sm opacity-10"></i>
                                </a>
                                <a href="#" class="text-dark delete-user-btn"
                                    data-bs-toggle="modal"
                                    data-bs-target="#deleteConfirmationModal"
                                    data-unit-slug="{{ $unit->slug }}"
                                    data-unit-name="{{ $unit->nama }}"
                                    title="Hapus Unit">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </td>
                            </tr>
                            @endforeach
                        </tbody>
                        </table>
                        <div class="my-3 ms-3">{{ $units->onEachSide(1)->links() }}</div>
                    </div>
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
                        <form id="editUnitForm" method="post">
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
        {{-- modal delete --}}
        <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body text-center mt-3 mx-n5">
                        <i class="bi bi-trash fa-2x text-danger mb-3"></i>
                        <p class="mb-0">Apakah Anda yakin ingin menghapus Unit ini?</p>
                        <h6 class="mt-2" id="unitNameToDelete"></h6>
                        <div class="mt-4">
                            <form id="deleteUnitForm" method="POST" action="#">
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
        <x-footer></x-footer>
    </div>
@push('scripts')

@endpush
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('searchInput');
            const statusFilter = document.getElementById('statusFilter'); // Ganti nama variabel agar lebih jelas
            const tableBody = document.getElementById('isiTable');
            const rows = tableBody.getElementsByTagName('tr');

            // Mengisi filter status secara manual, bukan dari data
            function populateStatusFilter() {
                const statuses = ['Aktif', 'Tidak Aktif'];
                // Hapus opsi lama jika ada, kecuali yang pertama ("status")
                while (statusFilter.options.length > 1) {
                    statusFilter.remove(1);
                }
                statuses.forEach(status => {
                    const option = document.createElement('option');
                    option.value = status;
                    option.textContent = status;
                    statusFilter.appendChild(option);
                });
            }

            function filterTable() {
                const searchText = searchInput.value.toLowerCase();
                const statusValue = statusFilter.value;

                for (let i = 0; i < rows.length; i++) {
                    const row = rows[i];
                    // Kolom pertama (indeks 0) adalah Nama Unit
                    const namaCell = row.cells[0];
                    // Kolom keempat (indeks 3) adalah Status
                    const statusCell = row.cells[3];

                    if (namaCell && statusCell) {
                        const namaText = namaCell.textContent.toLowerCase().trim();
                        const statusText = statusCell.textContent.trim();

                        // Cek kondisi filter
                        const namaMatch = namaText.includes(searchText);
                        const statusMatch = (statusValue === "" || statusText === statusValue);

                        // Tampilkan atau sembunyikan baris
                        row.style.display = (namaMatch && statusMatch) ? "" : "none";
                    }
                }
            }

            populateStatusFilter();

            searchInput.addEventListener('keyup', filterTable);
            statusFilter.addEventListener('change', filterTable);
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // scrollbar
            var win = navigator.platform.indexOf('Win') > -1;
            if (win && document.querySelector('#sidenav-scrollbar')) {
                var options = {
                    damping: '0.5'
                }
                Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
            }
            // toast notif
            var toastElement = document.getElementById('successToast');
            if (toastElement) {
                var toast = new bootstrap.Toast(toastElement);
                toast.show();
            }
            // slug
            const nama = document.querySelector('#nama ')
            const slug = document.querySelector('#slug')

            nama.addEventListener('change', function(){
                fetch('/dashboard/unit/chekSlug?nama=' + nama.value)
                    .then(response => response.json())
                    .then(data => slug.value = data.slug)
            });
        });
    </script>
    <script>
        // delete
        document.addEventListener('DOMContentLoaded', function () {
            const deleteModal = document.getElementById('deleteConfirmationModal');
            if (deleteModal) {
                deleteModal.addEventListener('show.bs.modal', function (event) {
                    const button = event.relatedTarget;
                    // Ambil 'unit' dari atribut data-*
                    const unitSlug = button.getAttribute('data-unit-slug');
                    const unitName = button.getAttribute('data-unit-name');
                    const modalBodyName = deleteModal.querySelector('#unitNameToDelete');
                    const deleteForm = deleteModal.querySelector('#deleteUnitForm');
                    modalBodyName.textContent = unitName;
                    // Atur action form menggunakan unit
                    deleteForm.action = `/unit/${unitSlug}`;
                });
            }
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const editModal = document.getElementById('editModal');
            if (editModal) {
                editModal.addEventListener('show.bs.modal', function (event) {
                    const button = event.relatedTarget; // Tombol yang di-klik

                    // Ambil URL dari atribut data-*
                    const dataUrl = button.getAttribute('data-url');
                    const updateUrl = button.getAttribute('data-update-url');

                    // Ambil elemen form dan input di dalam modal edit
                    const editForm = document.getElementById('editUnitForm');
                    const inputNama = document.getElementById('edit_nama');
                    const inputSlug = document.getElementById('edit_slug');
                    const inputSingkat = document.getElementById('edit_singkat');
                    const inputStatus = document.getElementById('edit_status');

                    // Atur action form untuk update
                    editForm.action = updateUrl;

                    // Ambil data Unit dari server
                    fetch(dataUrl)
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.json();
                        })
                        .then(data => {
                            // Isi form modal dengan data yang diterima
                            inputNama.value = data.nama;
                            inputSlug.value = data.slug;
                            inputSingkat.value = data.singkat;
                            inputStatus.checked = data.status == 1;
                        })
                        .catch(error => {
                            console.error('Error fetching category data:', error);
                            // Opsional: tampilkan pesan error kepada pengguna
                        });
                });

                // Slug generator untuk form edit
                const editNama = document.querySelector('#edit_nama');
                const editSlug = document.querySelector('#edit_slug');
                editNama.addEventListener('change', function(){
                    fetch('/dashboard/unit/chekSlug?nama=' + editNama.value)
                        .then(response => response.json())
                        .then(data => editSlug.value = data.slug)
                });
            }
        });
    </script>
</x-layout>


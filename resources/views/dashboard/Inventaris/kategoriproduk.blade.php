<x-layout>
    {{-- breadcrumb --}}
    @section('breadcrumb')
        @php
        $breadcrumbItems = [
            ['name' => 'Page', 'url' => '/dashboard'],
            ['name' => 'Manajemen Kategori', 'url' => route('kategoriproduk.index')],
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
    {{-- notif-error --}}
    @if (session()->has('error'))
        <div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 1055">
            <div id="errorToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header bg-warning text-white">
                    <span class="alert-icon text-light me-2"><i class="bi bi-exclamation-triangle"></i></span>
                    <strong class="me-auto">Notifikasi</strong>
                    <small class="text-light">Baru saja</small>
                    <button type="button" class="btn-close btn-light" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    {{ session('error') }}
                </div>
            </div>
        </div>
    @endif

    <div class="container-fluid d-flex flex-column min-vh-90 p-3 mb-auto ">
        <div class="row ">
            <div class="col-12 ">
                <div class="card mb-4 ">
                    <div class="card-header pb-0 px-3 pt-2 mb-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="mb-0">Data Kategori</h5>
                                    <p class="text-sm mb-0">
                                    Kelola data Kategorimu
                                </p>
                            </div>
                            <div class="ms-md-auto mt-2">
                                {{-- triger-modal-create --}}
                                <button class="btn btn-outline-info mb-0" data-bs-toggle="modal" data-bs-target="#import"><i class="fa fa-plus fixed-plugin-button-nav cursor-pointer pe-2"></i>Buat Kategori</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="filter-container">
                            <div class="row g-3 align-items-center justify-content-between">
                                <div class="col-5 col-lg-3 ms-3">
                                    <input type="text" id="searchInput" class="form-control" placeholder="cari kategori ...">
                                </div>
                                <div class="col-5 col-lg-2 me-3">
                                    <select id="posisiFilter" class="form-select">
                                        <option value="">semua status</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive p-0 my-3">
                            <table class="table table-hover align-items-center justify-content-start mb-0" id="tableData">
                                <thead>
                                    <tr class="table-secondary">
                                        <th class="text-uppercase text-dark text-xs font-weight-bolder">Kategori</th>
                                        <th class="text-uppercase text-dark text-xs font-weight-bolder ps-2">kategori Slug</th>
                                        <th class="text-uppercase text-dark text-xs font-weight-bolder ps-2">Jumlah Produk</th>
                                        <th class="text-uppercase text-dark text-xs font-weight-bolder ps-2">Dibuat Tanggal</th>
                                        <th class="text-center text-uppercase text-dark text-xs font-weight-bolder">status</th>
                                        <th class="text-dark"></th>
                                    </tr>
                                </thead>
                                <tbody id="isiTable">
                                    @foreach ($kategoris as $kategori)
                                    <tr>
                                        <td>
                                            <div title="image & Nama Kategori" class="d-flex align-items-center px-2 py-1">
                                                @if ($kategori->img_kategori)
                                                    <img src="{{ asset('storage/' . $kategori->img_kategori) }}" class="avatar avatar-sm me-3" alt="{{ $kategori->nama }}">
                                                @else
                                                    <img src="{{ asset('assets/img/produk.webp') }}" class="avatar avatar-sm me-3" alt="Gambar produk default">
                                                @endif
                                                <h6 class="mb-0 text-sm">{{ $kategori->nama }}</h6>
                                            </div>
                                        </td>

                                        <td>
                                            <p title="kategori slug" class=" text-xs text-dark fw-bold mb-0">{{ $kategori->slug }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs text-dark fw-bold mb-0">{{ $kategori->produks_count }}</p>
                                        </td>

                                        <td class="align-middle ">
                                            <span class="text-dark text-xs fw-bold">{{ $kategori->created_at?->translatedFormat('d M Y')}}</span>
                                        </td>

                                        <td class="align-middle text-center text-sm">
                                            @if ($kategori->status)
                                                <span class="badge badge-success">Aktif</span>
                                            @else
                                                <span class="badge badge-secondary">Tidak Aktif</span>
                                            @endif
                                        </td>

                                        <td class="align-middle">
                                            <a href="#" class="text-dark fw-bold px-3 text-xs"
                                                data-bs-toggle="modal"
                                                data-bs-target="#editModal"
                                                data-url="{{ route('kategoriproduk.getjson', $kategori->slug) }}"
                                                data-update-url="{{ route('kategoriproduk.update', $kategori->slug) }}"
                                                title="Edit kategori">
                                                <i class="bi bi-pencil-square text-dark text-sm opacity-10"></i>
                                            </a>
                                            <a href="#" class="text-dark delete-user-btn"
                                                data-bs-toggle="modal"
                                                data-bs-target="#deleteConfirmationModal"
                                                data-kategori-slug="{{ $kategori->slug }}"
                                                data-kategori-name="{{ $kategori->nama }}"
                                                title="Hapus kategori">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="my-3 ms-3">{{ $kategoris->onEachSide(1)->links() }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- modal-create --}}
        <div class="modal fade" id="import" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header border-0 mb-n3">
                        <h6 class="modal-title" id="ModalLabel">Buat kategori Baru</h6>
                        <button type="button" class="btn btn-close bg-danger rounded-3 me-1" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('kategoriproduk.store') }}" method="post" enctype="multipart/form-data" >
                            @csrf
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="d-flex flex-column justify-content-center align-items-center h-100">
                                        <div id="imagePreviewBox"
                                            class="border rounded p-2 d-flex justify-content-center align-items-center position-relative"
                                            style="height: 150px; width: 150px; border-style: dashed !important; border-width: 2px !important;">
                                            <div class="text-center text-muted">
                                                <i class="bi bi-cloud-arrow-up-fill fs-1"></i>
                                                <p class="mb-0 small mt-2">Pratinjau Gambar</p>
                                            </div>
                                        </div>
                                        <div class="mt-3 text-center">
                                            <label for="img" class="btn btn-outline-primary">Pilih Gambar</label>
                                            <input type="file" id="img" name="img_kategori" class="d-none" accept="image/jpeg, image/png">
                                            <p class="text-sm">JPEG, PNG maks 2MB</p>
                                        </div>
                                    </div>
                                </div>

                            <div class="col-md-7">
                                <div class="mb-3">
                                    <label for="nama" class="form-label">kategori</label>
                                    <input id="nama" name="nama" type="text" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama') }}" required>
                                    @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="slug" class="form-label">Slug</label>
                                    <input id="slug" name="slug" type="text" class="form-control @error('slug') is-invalid @enderror" value="{{ old('slug') }}" required>
                                    @error('slug')
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
                                <button type="submit" class="btn btn-info btn-sm">Buat Kategori</button>
                                <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">Batalkan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        {{-- modal edit --}}
        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header border-0 mb-n3">
                        <h6 class="modal-title" id="editModalLabel">Edit Kategori Produk</h6>
                        <button type="button" class="btn btn-close bg-danger rounded-3 me-1" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editKategoriForm" method="post" enctype="multipart/form-data">
                            @method('put')
                            @csrf
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="d-flex flex-column justify-content-center align-items-center h-100">
                                        <div id="editImagePreviewBox" class="border rounded p-2 d-flex justify-content-center align-items-center position-relative" style="height: 150px; width: 150px; border-style: dashed !important; border-width: 2px !important;">
                                            <div class="text-center text-muted">
                                                <i class="bi bi-cloud-arrow-up-fill fs-1"></i>
                                                <p class="mb-0 small mt-2">Pratinjau Gambar</p>
                                            </div>
                                        </div>
                                        <div class="mt-3 text-center">
                                            <label for="edit_img_kategori" class="btn btn-outline-primary">Ubah Gambar</label>
                                            <input type="file" id="edit_img_kategori" name="img_kategori" class="d-none" accept="image/jpeg, image/png">
                                            <p class="text-sm">JPEG, PNG maks 2MB</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <div class="mb-3">
                                        <label for="edit_nama" class="form-label">Nama</label>
                                        <input id="edit_nama" name="nama" type="text" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="edit_slug" class="form-label">Slug</label>
                                        <input id="edit_slug" name="slug" type="text" class="form-control" required readonly>
                                    </div>
                                    <div class="justify-content-end form-check form-switch form-check-reverse mt-4">
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
                        <p class="mb-0">Apakah Anda yakin ingin menghapus kategori ini?</p>
                        <h6 class="mt-2" id="kategoriNameToDelete"></h6>
                        <div class="mt-4">
                            <form id="deleteKategoriForm" method="POST" action="#">
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
                // toast notif success
                var succesToast = document.getElementById('successToast');
                if (succesToast) {
                    var toast = new bootstrap.Toast(succesToast);
                    toast.show();
                }

                // toast notif error
                var errorToast = document.getElementById('errorToast');
                if (errorToast) {
                    var toast = new bootstrap.Toast(errorToast);
                    toast.show();
                }

                // // slug
                // const nama = document.querySelector('#nama ')
                // const slug = document.querySelector('#slug')

                // nama.addEventListener('change', function(){
                //     fetch('/dashboard/kategoriproduk/chekSlug?nama=' + nama.value)
                //         .then(response => response.json())
                //         .then(data => slug.value = data.slug)
                // });

                // filter search dan status
                const searchInput = document.getElementById('searchInput');
                const statusFilter = document.getElementById('posisiFilter');
                const tableBody = document.getElementById('isiTable');
                const rows = tableBody.getElementsByTagName('tr');

                function populateStatusFilter() {
                    const statuses = ['Aktif', 'Tidak Aktif'];
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
                        const namaCell = row.cells[0];
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

                // pratinjau gambar
                function previewImage(fileInput, previewBox) {
                const file = fileInput.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            previewBox.innerHTML = `<img src="${e.target.result}" alt="Image Preview" style="width: 100%; height: 100%; object-fit: cover; border-radius: 0.5rem;">`;
                        }
                        reader.readAsDataURL(file);
                    }
                }

                // MODAL CREATE
                const hasError = document.querySelector('.is-invalid');
                if (hasError) {
                    var importModal = new bootstrap.Modal(document.getElementById('import'));
                    importModal.show();
                }

                const createModal = document.getElementById('import');
                if (createModal) {
                    const namaInput = createModal.querySelector('#nama');
                    const slugInput = createModal.querySelector('#slug');
                    const imageInput = createModal.querySelector('#img');
                    const imagePreviewBox = createModal.querySelector('#imagePreviewBox');

                    // Event listener untuk slug otomatis
                    namaInput.addEventListener('change', function() {
                        fetch(`/dashboard/kategoriproduk/chekSlug?nama=${namaInput.value}`)
                            .then(response => response.json())
                            .then(data => slugInput.value = data.slug);
                    });

                    // Event listener untuk pratinjau gambar
                    imageInput.addEventListener('change', function() {
                        previewImage(this, imagePreviewBox);
                    });

                    // Tampilkan modal jika ada error validasi dari server
                    const hasError = document.querySelector('.is-invalid');
                    if (hasError) {
                        var importModal = new bootstrap.Modal(createModal);
                        importModal.show();
                    }
                }

                // Modal Delete
                const deleteModal = document.getElementById('deleteConfirmationModal');
                if (deleteModal) {
                    deleteModal.addEventListener('show.bs.modal', function (event) {
                        const button = event.relatedTarget;
                        // Ambil 'username' dari atribut data-*
                        const kategoriSlug = button.getAttribute('data-kategori-slug'); // <-- DIUBAH DI SINI
                        const kategoriName = button.getAttribute('data-kategori-name');
                        const modalBodyName = deleteModal.querySelector('#kategoriNameToDelete');
                        const deleteForm = deleteModal.querySelector('#deleteKategoriForm');
                        modalBodyName.textContent = kategoriName;
                        // Atur action form menggunakan username
                        deleteForm.action = `/kategoriproduk/${kategoriSlug}`; // <-- DIUBAH DI SINI
                    });
                }

                // Modal Edit
                const editModal = document.getElementById('editModal');
                if (editModal) {
                    const editForm = editModal.querySelector('#editKategoriForm');
                    const inputNama = editModal.querySelector('#edit_nama');
                    const inputSlug = editModal.querySelector('#edit_slug');
                    const inputStatus = editModal.querySelector('#edit_status');
                    const imageInput = editModal.querySelector('#edit_img_kategori');
                    const imagePreviewBox = editModal.querySelector('#editImagePreviewBox');
                    const defaultPreview = `<div class="text-center text-muted"><i class="bi bi-cloud-arrow-up-fill fs-1"></i><p class="mb-0 small mt-2">Pratinjau Gambar</p></div>`;

                    // Event listener untuk menampilkan modal edit
                    editModal.addEventListener('show.bs.modal', function (event) {
                        const button = event.relatedTarget;
                        const dataUrl = button.getAttribute('data-url');
                        const updateUrl = button.getAttribute('data-update-url');

                        editForm.action = updateUrl;

                        fetch(dataUrl)
                            .then(response => response.json())
                            .then(data => {
                                // Isi form dengan data yang ada
                                inputNama.value = data.nama;
                                inputSlug.value = data.slug;
                                inputStatus.checked = data.status == 1;

                                // Tampilkan gambar yang sudah ada atau placeholder
                                if (data.img_kategori) {
                                    imagePreviewBox.innerHTML = `<img src="/storage/${data.img_kategori}" alt="${data.nama}" style="width: 100%; height: 100%; object-fit: cover; border-radius: 0.5rem;">`;
                                } else {
                                    imagePreviewBox.innerHTML = defaultPreview;
                                }
                            })
                            .catch(error => console.error('Error fetching kategori data:', error));
                    });

                    // Event listener untuk slug otomatis di modal edit
                    inputNama.addEventListener('change', function() {
                        fetch(`/dashboard/kategoriproduk/chekSlug?nama=${inputNama.value}`)
                            .then(response => response.json())
                            .then(data => inputSlug.value = data.slug);
                    });

                    // Event listener untuk pratinjau gambar di modal edit
                    imageInput.addEventListener('change', function() {
                        previewImage(this, imagePreviewBox);
                    });
                }
            });
        </script>
    @endpush
</x-layout>

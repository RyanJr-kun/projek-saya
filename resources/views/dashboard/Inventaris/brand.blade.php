<x-layout>

    @push('styles')
        <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">
        <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet">
        <link href="https://unpkg.com/filepond-plugin-image-edit/dist/filepond-plugin-image-edit.css" rel="stylesheet">
    @endpush
    
    @section('breadcrumb')
        @php
        $breadcrumbItems = [
            ['name' => 'Page', 'url' => '/dashboard'],
            ['name' => 'Manajemen Brand', 'url' => route('brand.index')],
        ];
        @endphp
        <x-breadcrumb :items="$breadcrumbItems" />

    @endsection

    <div class="container-fluid d-flex flex-column min-vh-90 p-3 mb-auto ">
        <div class="card mb-4 ">
            <div class="card-header pb-0 p-3 mb-3">
                <div class="d-flex flex-sm-row justify-content-sm-center align-items-sm-center">
                    <div class="mb-0">
                        <h5 class="mb-0">Data Brand</h5>
                            <p class="text-sm mb-0">
                            Kelola Data Brandmu
                        </p>
                    </div>
                    <div class="ms-auto my-auto mt-lg-0">
                        <div class="ms-auto mb-0">
                            {{-- triger-modal --}}
                            <button class="btn btn-outline-info mb-0" data-bs-toggle="modal" data-bs-target="#import"><i class="bi bi-plus-lg fixed-plugin-button-nav cursor-pointer pe-2"></i>Buat Brand</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <div class="filter-container">
                    <div class="row g-3 align-items-center justify-content-between">
                        <!-- Filter Pencarian Brand -->
                        <div class="col-5 col-lg-3 ms-3">
                            <input type="text" id="searchInput" class="form-control" placeholder="cari Brand ...">
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
                        <th class="text-uppercase text-dark text-xs font-weight-bolder ps-2">Jumlah Produk</th>
                        <th class="text-uppercase text-dark text-xs font-weight-bolder ps-2">Dibuat Tanggal</th>
                        <th class="text-center text-uppercase text-dark text-xs font-weight-bolder">status</th>
                        <th class="text-dark"></th>
                    </tr>
                </thead>
                <tbody id="isiTable">
                    @foreach ($brands as $brand)
                    <tr>
                    <td>
                        <div title="foto & nama brand" class="d-flex ms-2 px-2 py-1 align-items-center">
                            @if ($brand->img_brand)
                                <img src="{{ asset('storage/' . $brand->img_brand) }}" class="avatar avatar-sm me-3" alt="{{ $brand->nama }}">
                            @else
                                <img src="{{ asset('assets/img/produk.webp') }}" class="avatar avatar-sm me-3" alt="Gambar produk default">
                            @endif
                            <h6 class="mb-0 text-sm">{{ $brand->nama }}</h6>
                        </div>
                    </td>
                    <td>
                        <p class="text-xs text-dark fw-bold mb-0">{{ $brand->produks_count }}</p>
                    </td>
                    <td>
                        <p class="text-xs text-dark fw-bold mb-0">{{ $brand->created_at->translatedFormat('d M Y') }}</p>
                    </td>

                    <td class="align-middle text-center text-sm">
                        @if ($brand->status)
                            <span class="badge badge-success">Aktif</span>
                        @else
                            <span class="badge badge-secondary">Tidak Aktif</span>
                        @endif
                    </td>

                    <td class="align-middle">

                        <a href="#" class="text-dark fw-bold px-3 text-xs"
                            data-bs-toggle="modal"
                            data-bs-target="#editModal"
                            data-url="{{ route('brand.getjson', $brand->slug) }}"
                            data-update-url="{{ route('brand.update', $brand->slug) }}"
                            title="Edit brand">
                            <i class="bi bi-pencil-square text-dark text-sm opacity-10"></i>
                        </a>
                        <a href="#" class="text-dark delete-user-btn"
                            data-bs-toggle="modal"
                            data-bs-target="#deleteConfirmationModal"
                            data-brand-slug="{{ $brand->slug }}"
                            data-brand-name="{{ $brand->nama }}"
                            title="Hapus Unit">
                            <i class="bi bi-trash"></i>
                        </a>
                    </td>
                    </tr>
                    @endforeach
                </tbody>
                </table>
                <div class="my-3 ms-3">{{ $brands->onEachSide(1)->links() }}</div>
            </div>
            </div>
        </div>
        {{-- modal-create --}}
        <div class="modal fade" id="import" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header border-0 mb-n3">
                        <h6 class="modal-title" id="ModalLabel">Buat Data Brand Baru</h6>
                        <button type="button" class="btn btn-close bg-danger rounded-3 me-1" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="createBrandForm" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-3 mb-md-0">
                                    <p class="text-dark fw-bold ">Gambar Brand:</p>
                                    <input type="file" class="filepond" name="img_brand" id="img_brand_create">
                                </div>
                                <div class="col-md-6">
                                    <div class="mt-md-4">
                                        <label for="nama" class="form-label">Brand</label>
                                        <input id="nama" name="nama" type="text" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama') }}" required>
                                        <div class="invalid-feedback" id="nama-error"></div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="slug" class="form-label">Slug</label>
                                        <input id="slug" name="slug" type="text" class="form-control @error('slug') is-invalid @enderror" value="{{ old('slug') }}" required>
                                        <div class="invalid-feedback" id="slug-error"></div>
                                    </div>

                                    <div class="justify-content-end form-check form-switch form-check-reverse">
                                        <label class="me-auto form-check-label" for="status">Status</label>
                                        <input id="status" class="form-check-input" type="checkbox" name="status" value="1" checked>
                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer border-0 pb-0 mt-3">
                                <button type="button" id="submit-create-button" class="btn btn-info btn-sm">Buat Brand</button>
                                <button type="button" id="cancel-create-button" class="btn btn-danger btn-sm">Batalkan</button>
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
                        <h6 class="modal-title" id="editModalLabel">Edit Data Brand</h6>
                        <button type="button" class="btn btn-close bg-danger rounded-3 me-1" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editBrandForm" method="post" enctype="multipart/form-data">
                            @method('put')
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="text-dark fw-bold ">Gambar Brand:</p>
                                    <input type="file" class="filepond" name="img_brand" id="img_brand_edit">
                                </div>

                                <!-- Kolom Kanan untuk Input Teks -->
                                <div class="col-md-6">
                                    <div class="mt-4">
                                        <label for="edit_nama" class="form-label">Nama</label>
                                        <input id="edit_nama" name="nama" type="text" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="edit_slug" class="form-label">Slug</label>
                                        <input id="edit_slug" name="slug" type="text" class="form-control" required>
                                    </div>
                                    <div class="justify-content-end form-check form-switch form-check-reverse mt-4">
                                        <label class="me-auto form-check-label" for="edit_status">Status</label>
                                        <input id="edit_status" class="form-check-input" type="checkbox" name="status" value="1">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer border-0 pb-0 mt-3">
                                <button type="submit" class="btn btn-info btn-sm" id="submit-edit-button">Simpan Perubahan</button>
                                <button type="button" id="cancel-edit-button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">Batalkan</button>
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
                        <p class="mb-0">Apakah Anda yakin ingin menghapus Brand ini?</p>
                        <h6 class="mt-2" id="brandNameToDelete"></h6>
                        <div class="mt-4">
                            <form id="deleteBrandForm" method="POST" action="#">
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
        {{-- FilePond Scripts --}}
        <script src="https://unpkg.com/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.js"></script>
        <script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
        <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
        <script src="https://unpkg.com/filepond-plugin-image-crop/dist/filepond-plugin-image-crop.js"></script>
        <script src="https://unpkg.com/filepond-plugin-image-transform/dist/filepond-plugin-image-transform.js"></script>
        <script src="https://unpkg.com/filepond/dist/filepond.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // --- FILEPOND SETUP ---
                FilePond.registerPlugin(
                    FilePondPluginImagePreview,
                    FilePondPluginFileValidateSize,
                    FilePondPluginImageCrop,
                    FilePondPluginFileValidateType,
                    FilePondPluginImageTransform
                );

                // Setup FilePond untuk modal create
                const createPond = FilePond.create(document.querySelector('#img_brand_create'), {
                    labelIdle: `Seret & Lepas atau <span class="filepond--label-action">Cari</span>`,
                    // Aktifkan pratinjau gambar
                    allowImagePreview: true,
                    // Aktifkan validasi ukuran file
                    allowFileSizeValidation: true,
                    maxFileSize: '2MB',
                    // Aktifkan crop gambar
                    allowImageCrop: true,
                    imageCropAspectRatio: '1:1',
                    // stylePanelAspectRatio: '1:1',
                    labelMaxFileSizeExceeded: 'Ukuran file terlalu besar',
                    labelMaxFileSize: 'Ukuran file maksimum adalah 2MB',
                    acceptedFileTypes: ['image/png', 'image/jpeg', 'image/webp', 'image/svg+xml'],
                    labelFileTypeNotAllowed: 'Jenis file tidak valid. Hanya PNG, JPG, WEBP, dan SVG yang diizinkan.',
                    server: {
                        process: {
                            url: '/dashboard/brand/upload', // Pastikan route ini ada
                            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                        },
                            revert: {
                                url: '/dashboard/brand/revert',
                                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                            }
                    }
                });

                // --- MODAL CREATE ---
                const createModal = document.getElementById('import');
                if (createModal) {
                    const namaInput = createModal.querySelector('#nama');
                    const slugInput = createModal.querySelector('#slug');

                    // Event listener untuk slug otomatis
                    namaInput.addEventListener('change', function() {
                        fetch(`/dashboard/brand/chekSlug?nama=${namaInput.value}`)
                            .then(response => response.json())
                            .then(data => slugInput.value = data.slug);
                    });

                    // Tampilkan modal jika ada error validasi dari server
                    const hasError = document.querySelector('.is-invalid');
                    if (hasError) {
                        var createModalInstance = new bootstrap.Modal(createModal);
                        createModalInstance.show();
                    }

                    // Logika submit form create via AJAX
                    const createForm = document.getElementById('createBrandForm');
                    const submitCreateBtn = document.getElementById('submit-create-button');

                    if (submitCreateBtn) {
                        submitCreateBtn.addEventListener('click', function(e) {
                            e.preventDefault();
                            const formData = new FormData(createForm);

                            // Reset error states
                            createForm.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
                            createForm.querySelectorAll('.invalid-feedback').forEach(el => el.textContent = '');

                            fetch('{{ route("brand.store") }}', {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Accept': 'application/json' // Penting untuk memberitahu Laravel kita mau JSON
                                },
                                body: formData
                            })
                            .then(response => {
                                if (response.ok) {
                                    // Jika berhasil, reload halaman untuk melihat data baru
                                    window.location.reload();
                                } else if (response.status === 422) {
                                    // Jika ada error validasi, tampilkan pesan error di form.
                                    response.json().then(data => {
                                        Object.keys(data.errors).forEach(key => {
                                            const input = createForm.querySelector(`[name="${key}"]`);
                                            const errorDiv = createForm.querySelector(`#${key}-error`);
                                            if (input) input.classList.add('is-invalid');
                                            if (errorDiv) errorDiv.textContent = data.errors[key][0];
                                        });
                                    });
                                } else {
                                    alert('Terjadi kesalahan pada server. Silakan coba lagi.');
                                }
                            })
                            .catch(error => console.error('An unexpected network error occurred:', error));
                        });
                    }
                }

                // Logika tombol batalkan di modal create untuk membersihkan form dan FilePond
                    const cancelCreateBtn = createModal.querySelector('#cancel-create-button');
                    if (cancelCreateBtn) {
                        cancelCreateBtn.addEventListener('click', function(e) {
                            e.preventDefault(); // Mencegah penutupan modal otomatis oleh data-bs-dismiss

                            const createForm = document.getElementById('createBrandForm');
                            const modalInstance = bootstrap.Modal.getInstance(createModal);

                            // 1. Reset nilai input pada form ke nilai defaultnya
                            createForm.reset();

                            // 2. Hapus semua pesan error validasi
                            createForm.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
                            createForm.querySelectorAll('.invalid-feedback').forEach(el => el.textContent = '');

                            // 3. Hapus file dari FilePond (ini juga akan memicu revert di server)
                            //    dan tutup modal setelah selesai.
                            createPond.removeFiles().then(() => {
                                modalInstance.hide();
                            });
                        });
                    }

                // --- MODAL EDIT ---
                const editModal = document.getElementById('editModal');
                let editPond = null; // Untuk menyimpan instance FilePond modal edit

                if (editModal) {
                    const editForm = editModal.querySelector('#editBrandForm');
                    const inputNama = editModal.querySelector('#edit_nama');
                    const inputSlug = editModal.querySelector('#edit_slug');
                    const inputStatus = editModal.querySelector('#edit_status');

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

                                const pondFiles = [];
                                if (data.img_brand) {
                                    // Cukup berikan URL lengkap ke gambar yang ada, FilePond akan menampilkannya.
                                    pondFiles.push(`/storage/${data.img_brand}`);
                                }

                                // Buat instance FilePond baru untuk modal edit
                                editPond = FilePond.create(document.querySelector('#img_brand_edit'), {
                                    labelIdle: `Seret & Lepas atau <span class="filepond--label-action">Cari</span>`,
                                    files: pondFiles,
                                    allowImagePreview: true,
                                    allowFileSizeValidation: true,
                                    maxFileSize: '2MB',
                                    allowImageCrop: true,
                                    imageCropAspectRatio: '1:1',
                                    // stylePanelAspectRatio: '1:1',
                                    acceptedFileTypes: ['image/png', 'image/jpeg', 'image/webp', 'image/svg+xml'],
                                    labelFileTypeNotAllowed: 'Jenis file tidak valid.',
                                    labelMaxFileSizeExceeded: 'Ukuran file terlalu besar',
                                    labelMaxFileSize: 'Ukuran file maksimum adalah 2MB',
                                    server: {
                                        process: {
                                            url: '/dashboard/brand/upload', // Pastikan route ini ada
                                            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                                        },
                                        revert: {
                                            url: '/dashboard/brand/revert',
                                            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                                        }
                                    }
                                });

                                // --- Fitur Keamanan: Nonaktifkan tombol simpan saat upload ---
                                const submitEditBtn = editForm.querySelector('#submit-edit-button');
                                const pondEditInput = document.querySelector('#img_brand_edit');

                                pondEditInput.addEventListener('FilePond:addfile', (e) => {
                                    // Nonaktifkan tombol saat file ditambahkan dan mulai diunggah
                                    submitEditBtn.disabled = true;
                                    submitEditBtn.innerHTML = `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Mengunggah...`;
                                });

                                pondEditInput.addEventListener('FilePond:processfile', (e) => {
                                    // Aktifkan kembali setelah proses selesai (berhasil atau gagal)
                                    submitEditBtn.disabled = false;
                                    submitEditBtn.innerHTML = 'Simpan Perubahan';
                                });

                                pondEditInput.addEventListener('FilePond:removefile', (e) => {
                                    // Aktifkan kembali jika file dibatalkan/dihapus
                                    submitEditBtn.disabled = false;
                                    submitEditBtn.innerHTML = 'Simpan Perubahan';
                                });
                            })
                            .catch(error => console.error('Error fetching brand data:', error));
                    });

                    // Event listener untuk slug otomatis di modal edit
                    inputNama.addEventListener('change', function() {
                        fetch(`/dashboard/brand/chekSlug?nama=${inputNama.value}`)
                            .then(response => response.json())
                            .then(data => inputSlug.value = data.slug);
                    });

                    // Logika tombol batalkan di modal edit
                    const cancelEditBtn = editModal.querySelector('#cancel-edit-button');
                    if (cancelEditBtn) {
                        cancelEditBtn.addEventListener('click', function(e) {
                            e.preventDefault(); // Mencegah penutupan modal otomatis jika ada data-bs-dismiss

                            // Cari file yang BARU diunggah oleh pengguna dan sudah selesai diproses
                            const newFile = editPond.getFiles().find(file =>
                                file.origin === FilePond.FileOrigin.INPUT &&
                                file.status === FilePond.FileStatus.PROCESSING_COMPLETE
                            );

                            const modalInstance = bootstrap.Modal.getInstance(editModal);

                            if (newFile && newFile.serverId) {
                                // Jika ada file baru yang sudah diunggah, hapus dulu dari server
                                fetch('{{ route("brand.revert") }}', {
                                    method: 'DELETE',
                                    headers: {
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                    },
                                    body: newFile.serverId
                                }).finally(() => {
                                    modalInstance.hide();
                                });
                            } else {
                                modalInstance.hide();
                            }
                        });
                    }

                    // Tambahkan event listener untuk membersihkan FilePond saat modal ditutup.
                    // Ini penting untuk mencegah state gambar dari edit sebelumnya terbawa.
                    editModal.addEventListener('hidden.bs.modal', function () {
                        if (editPond) {
                            editPond.destroy();
                            editPond = null; // Pastikan instance lama benar-benar dihapus
                        }
                    });
                }

                // --- MODAL DELETE ---
                const deleteModal = document.getElementById('deleteConfirmationModal');
                if (deleteModal) {
                    deleteModal.addEventListener('show.bs.modal', function (event) {
                        const button = event.relatedTarget;
                        const brandSlug = button.getAttribute('data-brand-slug');
                        const brandName = button.getAttribute('data-brand-name');
                        const modalBodyName = deleteModal.querySelector('#brandNameToDelete');
                        const deleteForm = deleteModal.querySelector('#deleteBrandForm');

                        modalBodyName.textContent = brandName;
                        deleteForm.action = `/brand/${brandSlug}`;
                    });
                }
                // Filter tabel
                const searchInput = document.getElementById('searchInput');
                const statusFilter = document.getElementById('statusFilter');
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
                        const statusCell = row.cells[3]; // Status ada di kolom ke-4 (index 3)

                        if (namaCell && statusCell) {
                            const namaText = namaCell.textContent.toLowerCase().trim();
                            const statusText = statusCell.textContent.trim();
                            const namaMatch = namaText.includes(searchText);
                            const statusMatch = (statusValue === "" || statusText === statusValue);
                            row.style.display = (namaMatch && statusMatch) ? "" : "none";
                        }
                    }
                }

                if(searchInput && statusFilter && tableBody) {
                    populateStatusFilter();
                    searchInput.addEventListener('keyup', filterTable);
                    statusFilter.addEventListener('change', filterTable);
                }

                // Scrollbar
                const win = navigator.platform.indexOf('Win') > -1;
                if (win && document.querySelector('#sidenav-scrollbar')) {
                    Scrollbar.init(document.querySelector('#sidenav-scrollbar'), { damping: '0.5' });
                }
            });
        </script>
    @endpush
</x-layout>

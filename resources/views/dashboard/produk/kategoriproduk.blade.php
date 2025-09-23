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
            ['name' => 'Manajemen Kategori', 'url' => route('kategoriproduk.index')],
        ];
        @endphp
        <x-breadcrumb :items="$breadcrumbItems" />
    @endsection

    <div class="container-fluid p-3 ">
        <div class="card rounded-2">
            <div class="card-header pb-0 px-3 pt-2 mb-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-0">List Kategori</h6>
                            <p class="text-sm mb-0">
                            Kelola data Kategorimu
                        </p>
                    </div>
                    <div class="ms-auto mt-2">
                        {{-- triger-modal-create --}}
                        <button class="btn btn-outline-info mb-0" data-bs-toggle="modal" data-bs-target="#import"><i class="bi bi-plus-lg fixed-plugin-button-nav cursor-pointer pe-2"></i> Kategori</button>
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
                            <tr id="kategori-row-{{ $kategori->slug }}">
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
                                    <a href="#" class="text-dark delete-btn"
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
                            @if($kategoris->isEmpty())
                                <tr id="kategori-row-empty">
                                    <td colspan="6" class="text-center py-4">
                                        <p class="text-dark text-sm fw-bold mb-0">Belum ada data kategori.</p>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                    <div class="my-3 ms-3">{{ $kategoris->onEachSide(2)->links() }}</div>
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
                        <form id="createKategoriForm" enctype="multipart/form-data" >
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-3 mb-md-0">
                                    <p class="text-dark fw-bold ">Gambar Kategori:</p>
                                    <input type="file" class="filepond" name="img_kategori" id="img_kategori_create">
                                </div>

                            <div class="col-md-6">
                                <div class="mt-md-4">
                                    <label for="nama" class="form-label">Kategori</label>
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
                                <button type="button" id="submit-create-button" class="btn btn-outline-info btn-sm">Buat Kategori</button>
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
                        <h6 class="modal-title" id="editModalLabel">Edit Kategori Produk</h6>
                        <button type="button" class="btn btn-close bg-danger rounded-3 me-1" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editKategoriForm" method="post" enctype="multipart/form-data">
                            @method('put')
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="text-dark fw-bold ">Gambar Kategori:</p>
                                    <input type="file" class="filepond" name="img_kategori" id="img_kategori_edit">
                                </div>
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
                                <button type="submit" class="btn btn-outline-info btn-sm" id="submit-edit-button">Simpan Perubahan</button>
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
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://unpkg.com/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.js"></script>
        <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
        <script src="https://unpkg.com/filepond-plugin-image-crop/dist/filepond-plugin-image-crop.js"></script>
        <script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
        <script src="https://unpkg.com/filepond-plugin-image-transform/dist/filepond-plugin-image-transform.js"></script>
        <script src="https://unpkg.com/filepond/dist/filepond.js"></script>
        <script>
            // Fungsi untuk membuat baris tabel baru dari data
            function createTableRow(kategori) {
                const statusBadge = kategori.status ? '<span class="badge badge-success">Aktif</span>' : '<span class="badge badge-secondary">Tidak Aktif</span>';
                const imageUrl = kategori.img_kategori ? `{{ asset('storage') }}/${kategori.img_kategori}` : `{{ asset('assets/img/produk.webp') }}`;
                const editUrl = `{{ url('kategoriproduk/getjson') }}/${kategori.slug}`;
                const updateUrl = `{{ url('kategoriproduk') }}/${kategori.slug}`;

                return `
                    <tr id="kategori-row-${kategori.slug}">
                        <td>
                            <div title="image & Nama Kategori" class="d-flex align-items-center px-2 py-1">
                                <img src="${imageUrl}" class="avatar avatar-sm me-3" alt="${kategori.nama}">
                                <h6 class="mb-0 text-sm">${kategori.nama}</h6>
                            </div>
                        </td>
                        <td><p title="kategori slug" class="text-xs text-dark fw-bold mb-0">${kategori.slug}</p></td>
                        <td><p class="text-xs text-dark fw-bold mb-0">${kategori.produks_count}</p></td>
                        <td class="align-middle"><span class="text-dark text-xs fw-bold">${kategori.created_at_formatted}</span></td>
                        <td class="align-middle text-center text-sm">${statusBadge}</td>
                        <td class="align-middle">
                            <a href="#" class="text-dark fw-bold px-3 text-xs" data-bs-toggle="modal" data-bs-target="#editModal" data-url="${editUrl}" data-update-url="${updateUrl}" title="Edit kategori">
                                <i class="bi bi-pencil-square text-dark text-sm opacity-10"></i>
                            </a>
                            <a href="#" class="text-dark delete-btn" data-bs-toggle="modal" data-bs-target="#deleteConfirmationModal" data-kategori-slug="${kategori.slug}" data-kategori-name="${kategori.nama}" title="Hapus kategori">
                                <i class="bi bi-trash"></i>
                            </a>
                        </td>
                    </tr>
                `;
            }

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
                const createPond = FilePond.create(document.querySelector('#img_kategori_create'), {
                    labelIdle: `Seret & Lepas atau <span class="filepond--label-action">Cari</span>`,
                    allowImagePreview: true,
                    allowFileSizeValidation: true,
                    maxFileSize: '2MB',
                    allowImageCrop: true,
                    imageCropAspectRatio: '1:1',
                    labelMaxFileSizeExceeded: 'Ukuran file terlalu besar',
                    labelMaxFileSize: 'Ukuran file maksimum adalah 2MB',
                    acceptedFileTypes: ['image/png', 'image/jpeg', 'image/webp', 'image/svg+xml'],
                    labelFileTypeNotAllowed: 'Jenis file tidak valid. Hanya PNG, JPG, WEBP, dan SVG yang diizinkan.',
                    server: {
                        process: {
                            url: '/dashboard/kategoriproduk/upload', // Disesuaikan untuk kategori
                            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                        },
                            revert: {
                                url: '/dashboard/kategoriproduk/revert', // Disesuaikan untuk kategori
                                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                            }
                    }
                });

                // --- MODAL CREATE ---
                const createModal = document.getElementById('import');
                if (createModal) {
                    const namaInput = createModal.querySelector('#nama');
                    const slugInput = createModal.querySelector('#slug');

                    // Tampilkan modal jika ada error validasi dari server
                    const hasError = document.querySelector('.is-invalid');
                    if (hasError) {
                        var createModalInstance = new bootstrap.Modal(createModal);
                        createModalInstance.show();
                    }

                    // Logika submit form create via AJAX
                    const createForm = document.getElementById('createKategoriForm');
                    const submitCreateBtn = document.getElementById('submit-create-button');

                    if (submitCreateBtn) {
                        submitCreateBtn.addEventListener('click', function(e) {
                            e.preventDefault();
                            const formData = new FormData(createForm);

                            // Reset error states
                            createForm.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
                            createForm.querySelectorAll('.invalid-feedback').forEach(el => el.textContent = '');

                            fetch('{{ route("kategoriproduk.store") }}', {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Accept': 'application/json'
                                },
                                body: formData
                            })
                            .then(response => {
                                if (!response.ok) {
                                    return response.json().then(data => { throw data; });
                                }
                                return response.json();
                            })
                            .then(data => {
                                if (data.success) {
                                    const tableBody = document.getElementById('isiTable');
                                    const newRowHtml = createTableRow(data.data);
                                    tableBody.insertAdjacentHTML('afterbegin', newRowHtml);
                                    document.getElementById('kategori-row-empty')?.remove();

                                    const modalInstance = bootstrap.Modal.getInstance(createModal);
                                    modalInstance.hide();

                                    Swal.fire({ icon: 'success', title: 'Berhasil!', text: data.message, showConfirmButton: false, timer: 1500 });
                                }
                            })
                            .catch(errorData => {
                                if (errorData.errors) {
                                        Object.keys(data.errors).forEach(key => {
                                            const input = createForm.querySelector(`[name="${key}"]`);
                                            const errorDiv = createForm.querySelector(`#${key}-error`);
                                            if (input) input.classList.add('is-invalid');
                                            if (errorDiv) errorDiv.textContent = errorData.errors[key][0];
                                        });
                                } else {
                                    Swal.fire({ icon: 'error', title: 'Gagal!', text: errorData.message || 'Terjadi kesalahan server.' });
                                }
                            });
                        });
                    }

                    // Slug otomatis
                    namaInput.addEventListener('change', function() {
                        fetch(`/dashboard/kategoriproduk/chekSlug?nama=${namaInput.value}`)
                            .then(response => response.json())
                            .then(data => slugInput.value = data.slug);
                    });

                    const cancelCreateBtn = createModal.querySelector('#cancel-create-button');
                    if (cancelCreateBtn) {
                        cancelCreateBtn.addEventListener('click', function(e) {
                            e.preventDefault();

                            const createForm = document.getElementById('createKategoriForm');
                            const modalInstance = bootstrap.Modal.getInstance(createModal);

                            createForm.reset();
                            createForm.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
                            createForm.querySelectorAll('.invalid-feedback').forEach(el => el.textContent = '');
                            createPond.removeFiles().then(() => {
                                modalInstance.hide();
                            });
                        });
                    }
                }

                // --- MODAL EDIT ---
                const editModal = document.getElementById('editModal');
                let editPond = null;
                const csrfToken = '{{ csrf_token() }}';

                if (editModal) {
                    const editForm = editModal.querySelector('#editKategoriForm');
                    const inputNama = editModal.querySelector('#edit_nama');
                    const inputSlug = editModal.querySelector('#edit_slug');
                    const inputStatus = editModal.querySelector('#edit_status');

                    editModal.addEventListener('show.bs.modal', function (event) {
                        const button = event.relatedTarget;
                        const dataUrl = button.getAttribute('data-url');
                        const updateUrl = button.getAttribute('data-update-url');

                        // Set action form untuk update
                        editForm.action = updateUrl;

                        fetch(dataUrl)
                            .then(response => response.json())
                            .then(data => {
                                inputNama.value = data.nama;
                                inputSlug.value = data.slug;
                                inputStatus.checked = data.status == 1;

                                const pondFiles = [];
                                if (data.img_kategori) {
                                    pondFiles.push(`/storage/${data.img_kategori}`);
                                }

                                editPond = FilePond.create(document.querySelector('#img_kategori_edit'), {
                                    labelIdle: `Seret & Lepas atau <span class="filepond--label-action">Cari</span>`,
                                    files: pondFiles,
                                    allowImagePreview: true,
                                    allowFileSizeValidation: true,
                                    maxFileSize: '2MB',
                                    allowImageCrop: true,
                                    imageCropAspectRatio: '1:1',
                                    acceptedFileTypes: ['image/png', 'image/jpeg', 'image/webp', 'image/svg+xml'],
                                    labelFileTypeNotAllowed: 'Jenis file tidak valid.',
                                    labelMaxFileSizeExceeded: 'Ukuran file terlalu besar',
                                    labelMaxFileSize: 'Ukuran file maksimum adalah 2MB',
                                    server: {
                                        process: {
                                            url: '{{ route("kategoriproduk.upload") }}',
                                            headers: { 'X-CSRF-TOKEN': csrfToken }
                                        },
                                        revert: {
                                            url: '{{ route("kategoriproduk.revert") }}',
                                            headers: { 'X-CSRF-TOKEN': csrfToken }
                                        }
                                    }
                                });

                                const submitEditBtn = editForm.querySelector('#submit-edit-button');
                                const pondEditInput = document.querySelector('#img_kategori_edit');

                                pondEditInput.addEventListener('FilePond:addfile', (e) => {
                                    submitEditBtn.disabled = true;
                                    submitEditBtn.innerHTML = `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Mengunggah...`;
                                });

                                pondEditInput.addEventListener('FilePond:processfile', (e) => {
                                    submitEditBtn.disabled = false;
                                    submitEditBtn.innerHTML = 'Simpan Perubahan';
                                });

                                pondEditInput.addEventListener('FilePond:removefile', (e) => {
                                    submitEditBtn.disabled = false;
                                    submitEditBtn.innerHTML = 'Simpan Perubahan';
                                });
                            })
                            .catch(error => console.error('Error fetching kategori data:', error));
                    });

                    editForm.addEventListener('submit', function(e) {
                        e.preventDefault();
                        const formData = new FormData(this);
                        const updateUrl = this.action;

                        fetch(updateUrl, {
                            method: 'POST', // Laravel handles PUT/PATCH via _method field
                            headers: {
                                'X-CSRF-TOKEN': csrfToken,
                                'Accept': 'application/json'
                            },
                            body: formData
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                const updatedRow = createTableRow(data.data);
                                const oldRow = document.getElementById(`kategori-row-${data.data.slug}`);
                                if (oldRow) {
                                    oldRow.outerHTML = updatedRow;
                                }
                                bootstrap.Modal.getInstance(editModal).hide();
                                Swal.fire({ icon: 'success', title: 'Berhasil!', text: data.message, showConfirmButton: false, timer: 1500 });
                            } else {
                                // Handle validation or other errors
                                Swal.fire({ icon: 'error', title: 'Gagal!', text: data.message || 'Terjadi kesalahan.' });
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Swal.fire('Error', 'Tidak dapat terhubung ke server.', 'error');
                        });
                    });

                    inputNama.addEventListener('change', function() {
                        fetch(`/dashboard/kategoriproduk/chekSlug?nama=${inputNama.value}`)
                            .then(response => response.json())
                            .then(data => inputSlug.value = data.slug);
                    });

                    const cancelEditBtn = editModal.querySelector('#cancel-edit-button');
                    if (cancelEditBtn) {
                        cancelEditBtn.addEventListener('click', function(e) {
                            e.preventDefault();

                            const newFile = editPond.getFiles().find(file =>
                                file.origin === FilePond.FileOrigin.INPUT &&
                                file.status === FilePond.FileStatus.PROCESSING_COMPLETE
                            );

                            const modalInstance = bootstrap.Modal.getInstance(editModal);

                            if (newFile && newFile.serverId) {
                                fetch('{{ route("kategoriproduk.revert") }}', {
                                    method: 'DELETE',
                                    headers: { 'X-CSRF-TOKEN': csrfToken },
                                    body: newFile.serverId
                                }).finally(() => {
                                    modalInstance.hide();
                                });
                            } else {
                                modalInstance.hide();
                            }
                        });
                    }

                    editModal.addEventListener('hidden.bs.modal', function () {
                        if (editPond) {
                            editPond.destroy();
                            editPond = null;
                        }
                    });
                }

                // --- MODAL DELETE ---
                const deleteModalEl = document.getElementById('deleteConfirmationModal');
                if (deleteModalEl) {
                    const deleteForm = deleteModalEl.querySelector('#deleteKategoriForm');
                    const modalBodyName = deleteModalEl.querySelector('#kategoriNameToDelete');
                    const deleteModalInstance = new bootstrap.Modal(deleteModalEl);
                    let kategoriSlugToDelete = null;

                    deleteModalEl.addEventListener('show.bs.modal', function (event) {
                        const button = event.relatedTarget;
                        kategoriSlugToDelete = button.getAttribute('data-kategori-slug');
                        const kategoriName = button.getAttribute('data-kategori-name');
                        modalBodyName.textContent = kategoriName;
                    });

                    deleteForm.addEventListener('submit', function(e) {
                        e.preventDefault();
                        if (!kategoriSlugToDelete) return;

                        const url = `/kategoriproduk/${kategoriSlugToDelete}`;

                        fetch(url, {
                            method: 'DELETE',
                            headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' }
                        })
                        .then(response => response.json().then(data => ({ ok: response.ok, data })))
                        .then(({ ok, data }) => {
                            deleteModalInstance.hide();
                            if (ok && data.success) {
                                Swal.fire({ icon: 'success', title: 'Berhasil!', text: data.message, timer: 2000, showConfirmButton: false });
                                document.getElementById(`kategori-row-${kategoriSlugToDelete}`).remove();
                            } else {
                                Swal.fire({ icon: 'error', title: 'Gagal!', text: data.message || 'Terjadi kesalahan.' });
                            }
                        })
                        .catch(error => {
                            deleteModalInstance.hide();
                            Swal.fire('Error', 'Tidak dapat terhubung ke server.', 'error');
                        });
                    });
                }


                // --- FILTER ---
                // Filter tabel
                const searchInput = document.getElementById('searchInput');
                const statusFilter = document.getElementById('posisiFilter'); // Nama ID dari HTML
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
                        const statusCell = row.cells[4]; // Status ada di kolom ke-5 (index 4)

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

                if(searchInput && statusFilter && tableBody) {
                    populateStatusFilter();
                    searchInput.addEventListener('keyup', filterTable);
                    statusFilter.addEventListener('change', filterTable);
                }

            });
        </script>
    @endpush
</x-layout>

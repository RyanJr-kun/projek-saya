<x-layout>
    @section('breadcrumb')
        @php
        // Definisikan item breadcrumb dalam bentuk array
        $breadcrumbItems = [
            ['name' => 'Dashboard', 'url' => '#'],
            ['name' => 'Manajemen Pelanggan', 'url' => route('pelanggan.index')],
        ];
        @endphp
        <x-breadcrumb :items="$breadcrumbItems" />
    @endsection

    <div class="container-fluid p-3">
        <div class="card mb-4">
            <div class="card-header pb-0 px-3 pt-2 mb-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-n1">List Pelanggan</h6>
                        <p class="text-sm mb-0">Kelola data pelangganmu.</p>
                    </div>
                    <div class="ms-md-auto mt-2" >
                        {{-- triger-modal-create --}}
                        <button class="btn btn-outline-info mb-0" data-bs-toggle="modal" data-bs-target="#createModal">
                            <i class="fa fa-plus cursor-pointer pe-2"></i>Pelanggan
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <div class="filter-container">
                    <div class="row g-3 align-items-center justify-content-between">
                        <div class="col-5 col-lg-3 ms-3">
                            <input type="text" id="searchInput" class="form-control" placeholder="cari Pelanggan ...">
                        </div>
                        <div class="col-5 col-lg-2 me-3">
                            <select id="statusFilter" class="form-select">
                                <option value="">Semua Status</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="table-responsive p-0 mt-3">
                    <table class="table table-hover align-items-center justify-content-start mb-0" id="tableData">
                        <thead>
                            <tr class="table-secondary">
                                <th class="text-uppercase text-dark text-xs font-weight-bolder">Nama</th>
                                <th class="text-uppercase text-dark text-xs font-weight-bolder ps-2">Kontak</th>
                                <th class="text-uppercase text-dark text-xs font-weight-bolder ps-2">Email</th>
                                <th class="text-uppercase text-dark text-xs font-weight-bolder ps-2">Alamat</th>
                                <th class="text-center text-uppercase text-dark text-xs font-weight-bolder">Status</th>
                                <th class="text-dark"></th>
                            </tr>
                        </thead>
                        <tbody id="isiTable">
                            @forelse ($pelanggans as $pelanggan)
                            <tr id="pelanggan-row-{{ $pelanggan->id }}">
                                <td>
                                    <p title="Nama Pelanggan" class="ms-3 text-xs text-dark fw-bold mb-0">{{ $pelanggan->nama }}</p>
                                </td>
                                <td>
                                    <p title="Kontak" class="text-xs text-dark fw-bold mb-0">{{ $pelanggan->kontak }}</p>
                                </td>
                                <td>
                                    <p title="Email" class="text-xs text-dark fw-bold mb-0" >{{ $pelanggan->email }}</p>
                                </td>
                                <td>
                                    <p title="Alamat" class="text-xs text-dark fw-bold mb-0">{{ Str::limit($pelanggan->alamat, 20) }}</p>
                                </td>

                                <td class="align-middle text-center text-sm">
                                    @if ($pelanggan->status)
                                        <span class="badge badge-success">Aktif</span>
                                    @else
                                        <span class="badge badge-secondary">Tidak Aktif</span>
                                    @endif
                                </td>

                                <td class="text-center align-middle">
                                    @if ($pelanggan->id != 1)
                                        <a href="#" class="text-dark fw-bold px-3 text-xs"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editModal"
                                            data-url="{{ route('pelanggan.getjson', $pelanggan->id) }}"
                                            data-update-url="{{ route('pelanggan.update', $pelanggan->id) }}"
                                            title="Edit Pelanggan">
                                            <i class="bi bi-pencil-square text-dark text-sm opacity-10"></i>
                                        </a>
                                        <a href="#" class="text-dark delete-btn me-md-4"
                                            data-bs-toggle="modal"
                                            data-bs-target="#deleteConfirmationModal"
                                            data-pelanggan-id="{{ $pelanggan->id }}"
                                            data-pelanggan-name="{{ $pelanggan->nama }}"
                                            title="Hapus Pelanggan">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    @endif
                                </td>
                            </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-3 ">
                                        <p class=" text-dark text-sm fw-bold mb-0">Belum ada data Pelanggan.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="my-3 ms-3">
                        {{ $pelanggans->onEachSide(1)->links() }}
                    </div>
                </div>
            </div>
        </div>
        {{-- modal-create --}}
        <div class="modal fade" id="createModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header border-0 mb-n3">
                        <h6 class="modal-title">Buat Pelanggan Baru</h6>
                        <button type="button" class="btn btn-close bg-danger rounded-3 me-1" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('pelanggan.store') }}" method="post">
                            @csrf
                            <div class="mb-2">
                                <label for="nama" class="form-label">Nama</label>
                                <input id="nama" name="nama" type="text" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama') }}" required>
                                @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-1">
                                <label for="kontak" class="form-label">Kontak</label>
                                <input id="kontak" name="kontak" type="text" class="form-control @error('kontak') is-invalid @enderror" value="{{ old('kontak') }}" required>
                                @error('kontak')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-1">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="example@gmail.com" value="{{ old('email') }}">
                                @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-1">
                                <label for="alamat" class="form-label">Alamat</label>
                                <textarea id="alamat" name="alamat" class="form-control @error('alamat') is-invalid @enderror" rows="3">{{ old('alamat') }}</textarea>
                                @error('alamat')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="justify-content-end form-check form-switch form-check-reverse mb-2">
                                <label class="me-auto fw-bold form-check-label" for="status">Status</label>
                                <input id="status" class="form-check-input" type="checkbox" name="status" value="1" checked>
                            </div>
                            <div class="modal-footer border-0 pb-0">
                                <button type="submit" class="btn btn-outline-info btn-sm">Buat Pelanggan</button>
                                <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">Batalkan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        {{-- Menggunakan komponen modal create pelanggan --}}
        <x-modal-create-customer
            id="createModal"
            formId="createPelangganForm"
            action="{{ route('pelanggan.store') }}"
            title="Buat Pelanggan Baru"
        />

        {{-- modal edit --}}
        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header border-0 mb-n3">
                        <h6 class="modal-title" id="editModalLabel">Edit Pelanggan</h6>
                        <button type="button" class="btn btn-close bg-danger rounded-3 me-1" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editPelangganForm" method="post">
                            @method('put')
                            @csrf
                            <div class="mb-3">
                                <label for="edit_nama" class="form-label">Nama</label>
                                <input id="edit_nama" name="nama" type="text" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="edit_kontak" class="form-label">Kontak</label>
                                <input id="edit_kontak" name="kontak" type="text" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="edit_email" class="form-label">Email</label>
                                <input id="edit_email" name="email" type="email" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="edit_alamat" class="form-label">Alamat</label>
                                <textarea id="edit_alamat" name="alamat" class="form-control" rows="3"></textarea>
                            </div>
                            <div class="justify-content-end form-check form-switch form-check-reverse mt-3">
                                <label class="me-auto form-check-label" for="edit_status">Status</label>
                                <input id="edit_status" class="form-check-input" type="checkbox" name="status" value="1" >
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
                        <p class="mb-0">Apakah Anda yakin ingin menghapus pelanggan ini?</p>
                        <h6 class="mt-2" id="pelangganNameToDelete"></h6>
                        <div class="mt-4">
                            <form id="deletePelangganForm" method="POST" action="#">
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
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // --- MODAL EDIT ---
            const editModal = document.getElementById('editModal');
            if (editModal) {
                editModal.addEventListener('show.bs.modal', function (event) {
                    const button = event.relatedTarget;
                    const dataUrl = button.getAttribute('data-url');
                    const updateUrl = button.getAttribute('data-update-url');

                    const editForm = document.getElementById('editPelangganForm');
                    const inputNama = document.getElementById('edit_nama');
                    const inputKontak = document.getElementById('edit_kontak');
                    const inputEmail = document.getElementById('edit_email');
                    const inputAlamat = document.getElementById('edit_alamat');
                    const inputStatus = document.getElementById('edit_status');

                    editForm.action = updateUrl;

                    fetch(dataUrl)
                        .then(response => response.json())
                        .then(data => {
                            inputNama.value = data.nama;
                            inputKontak.value = data.kontak;
                            inputEmail.value = data.email;
                            inputAlamat.value = data.alamat;
                            inputStatus.checked = data.status == 1;
                        })
                        .catch(error => console.error('Error fetching pelanggan data:', error));
                });
            }

            // --- MODAL DELETE ---
            const deleteModalEl = document.getElementById('deleteConfirmationModal');
            if (deleteModalEl) {
                const deleteForm = deleteModalEl.querySelector('#deletePelangganForm');
                const modalBodyName = deleteModalEl.querySelector('#pelangganNameToDelete');
                const deleteModalInstance = new bootstrap.Modal(deleteModalEl);
                let pelangganIdToDelete = null;

                deleteModalEl.addEventListener('show.bs.modal', function (event) {
                    const button = event.relatedTarget;
                    pelangganIdToDelete = button.getAttribute('data-pelanggan-id');
                    const pelangganName = button.getAttribute('data-pelanggan-name');

                    modalBodyName.textContent = pelangganName;
                });

                deleteForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    if (!pelangganIdToDelete) return;

                    const url = `/pelanggan/${pelangganIdToDelete}`;
                    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                    fetch(url, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json',
                        }
                    })
                    .then(response => response.json().then(data => ({ ok: response.ok, data })))
                    .then(({ ok, data }) => {
                        deleteModalInstance.hide();
                        if (ok && data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: data.message,
                                timer: 2000,
                                showConfirmButton: false
                            });
                            document.getElementById(`pelanggan-row-${pelangganIdToDelete}`).remove();
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal!',
                                text: data.message || 'Terjadi kesalahan.',
                            });
                        }
                    })
                    .catch(error => {
                        deleteModalInstance.hide();
                        Swal.fire('Error', 'Tidak dapat terhubung ke server.', 'error');
                    });
                });
            }

            // --- FILTER SEARCH & STATUS ---
            const searchInput = document.getElementById('searchInput');
            const statusFilter = document.getElementById('statusFilter');
            const tableBody = document.getElementById('isiTable');
            const rows = tableBody.getElementsByTagName('tr');

            function populateStatusFilter() {
                const statuses = ['Aktif', 'Tidak Aktif'];
                // Clear existing options except the first one
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
                    const statusCell = row.cells[4]; // Status is in the 5th column (index 4)

                    if (namaCell && statusCell) {
                        const namaText = namaCell.textContent.toLowerCase().trim();
                        const statusText = statusCell.textContent.trim();

                        const namaMatch = namaText.includes(searchText);
                        const statusMatch = (statusValue === "" || statusText === statusValue);

                        row.style.display = (namaMatch && statusMatch) ? "" : "none";
                    }
                }
            }

            populateStatusFilter();
            searchInput.addEventListener('keyup', filterTable);
            statusFilter.addEventListener('change', filterTable);

            // --- SHOW CREATE MODAL ON VALIDATION ERROR ---
            const hasError = document.querySelector('.is-invalid');
            if (hasError) {
                var createModal = new bootstrap.Modal(document.getElementById('createModal'));
                createModal.show();
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

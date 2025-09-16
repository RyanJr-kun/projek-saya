<x-layout>
    {{-- breadcrumb --}}
    @section('breadcrumb')
        @php
        // Definisikan item breadcrumb dalam bentuk array
        $breadcrumbItems = [
            ['name' => 'Page', 'url' => '#'],
            ['name' => 'Manajemen Pemasok', 'url' => route('pemasok.index')],
        ];
        @endphp
        <x-breadcrumb :items="$breadcrumbItems" />
    @endsection


    <div class="container-fluid p-3">
        <div class="card mb-4">
            <div class="card-header pb-0 px-3 pt-2 mb-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-n1">List Pemasok</h6>
                        <p class="text-sm mb-0">Kelola data pemasokmu.</p>
                    </div>
                    <div class="ms-md-auto mt-2">
                        {{-- triger-modal-create --}}
                        <button class="btn btn-outline-info mb-0" data-bs-toggle="modal" data-bs-target="#createModal">
                            <i class="fa fa-plus fixed-plugin-button-nav cursor-pointer pe-2"></i>Pemasok
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <div class="filter-container">
                    <div class="row g-3 align-items-center justify-content-between">
                        <div class="col-5 col-lg-3 ms-3">
                            <input type="text" id="searchInput" class="form-control" placeholder="cari Pemasok ...">
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
                                <th class="text-uppercase text-dark text-xs font-weight-bolder ps-2">Perusahaan</th>
                                <th class="text-uppercase text-dark text-xs font-weight-bolder ps-2">Kontak</th>
                                <th class="text-uppercase text-dark text-xs font-weight-bolder ps-2">Alamat</th>
                                <th class="text-uppercase text-dark text-xs font-weight-bolder ps-2">Catatan</th>
                                <th class="text-center text-uppercase text-dark text-xs font-weight-bolder">Status</th>
                                <th class="text-dark"></th>
                            </tr>
                        </thead>
                        <tbody id="isiTable">
                            @forelse ($pemasoks as $pemasok)
                            <tr>
                                <td>
                                    <p title="Nama Pemasok" class="ms-3 text-uppercase text-xs text-dark fw-bold mb-0">{{ $pemasok->nama }}</p>
                                </td>
                                <td>
                                    <p title="Nama Perusahaan" class="text-uppercase text-xs text-dark fw-bold mb-0">{{ $pemasok->perusahaan }}</p>
                                </td>
                                <td>
                                    <div class="d-block">
                                        <p title="Kontak" class="text-xs text-dark fw-bold mb-0">{{ $pemasok->kontak }}</p>
                                        <p title="Email" class="text-xs text-dark fw-bold mb-0" >{{ $pemasok->email }}</p>
                                    </div>
                                </td>
                                <td>
                                    <p title="Alamat" class="text-xs text-dark fw-bold mb-0">{{ Str::limit($pemasok->alamat, 40) }}</p>
                                </td>
                                <td>
                                    <p title="Note" class="text-xs text-dark fw-bold mb-0">{{ Str::limit($pemasok->note, 40) }}</p>
                                </td>

                                <td class="align-middle text-center text-sm">
                                    @if ($pemasok->status)
                                        <span class="badge badge-success">Aktif</span>
                                    @else
                                        <span class="badge badge-secondary">Tidak Aktif</span>
                                    @endif
                                </td>

                                <td class="text-center align-middle">
                                    <a href="#" class="text-dark fw-bold px-3 text-xs"
                                        data-bs-toggle="modal"
                                        data-bs-target="#editModal"
                                        data-url="{{ route('pemasok.getjson', $pemasok->id) }}"
                                        data-update-url="{{ route('pemasok.update', $pemasok->id) }}"
                                        title="Edit Pemasok">
                                        <i class="bi bi-pencil-square text-dark text-sm opacity-10"></i>
                                    </a>
                                    <a href="#" class="text-dark delete-btn me-md-4"
                                        data-bs-toggle="modal"
                                        data-bs-target="#deleteConfirmationModal"
                                        data-pemasok-id="{{ $pemasok->id }}"
                                        data-pemasok-name="{{ $pemasok->nama }}"
                                        title="Hapus Pemasok">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-3 ">
                                        <p class=" text-dark text-sm fw-bold mb-0">Belum ada data pemasok.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="my-3 ms-3">
                        {{ $pemasoks->onEachSide(1)->links() }}
                    </div>
                </div>
            </div>
        </div>
        {{-- modal-create --}}
        <div class="modal fade" id="createModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header border-0 mb-n3">
                        <h6 class="modal-title">Tambah Pemasok Baru</h6>
                        <button type="button" class="btn btn-close bg-danger rounded-3 me-1" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        {{-- PERBAIKAN: Form ini sekarang akan melakukan submit standar (full page refresh) --}}
                        <form action="{{ route('pemasok.store') }}" method="post">
                            @csrf
                            <x-pemasok-form-fields />
                            <div class="justify-content-end form-check form-switch form-check-reverse my-2">
                                <label class="me-auto fw-bold form-check-label" for="status">Status</label>
                                <input id="status" class="form-check-input" type="checkbox" name="status" value="1" checked>
                            </div>
                            <div class="modal-footer border-0 pb-0">
                                <button type="submit" class="btn btn-outline-info btn-sm">Buat Pemasok</button>
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
                        <h6 class="modal-title" id="editModalLabel">Edit Pemasok</h6>
                        <button type="button" class="btn btn-close bg-danger rounded-3 me-1" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editPemasokForm" method="post">
                            @method('put')
                            @csrf
                            <x-pemasok-form-fields prefix="edit_" :pemasok="new \App\Models\Pemasok" />
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
                        <p class="mb-0">Apakah Anda yakin ingin menghapus pemasok ini?</p>
                        <h6 class="mt-2" id="pemasokNameToDelete"></h6>
                        <div class="mt-4">
                            <form id="deletePemasokForm" method="POST" action="#">
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
        document.addEventListener('DOMContentLoaded', function () {
            // --- MODAL EDIT ---
            const editModal = document.getElementById('editModal');
            if (editModal) {
                editModal.addEventListener('show.bs.modal', function (event) {
                    const button = event.relatedTarget;
                    const dataUrl = button.getAttribute('data-url');
                    const updateUrl = button.getAttribute('data-update-url');

                    const editForm = document.getElementById('editPemasokForm');
                    const inputNama = document.getElementById('edit_nama');
                    const inputPerusahaan = document.getElementById('edit_perusahaan');
                    const inputKontak = document.getElementById('edit_kontak');
                    const inputEmail = document.getElementById('edit_email');
                    const inputAlamat = document.getElementById('edit_alamat');
                    const inputNote = document.getElementById('edit_note');
                    const inputStatus = document.getElementById('edit_status');

                    editForm.action = updateUrl;

                    fetch(dataUrl)
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.json();
                        })
                        .then(data => {
                            inputNama.value = data.nama;
                            inputPerusahaan.value = data.perusahaan;
                            inputKontak.value = data.kontak;
                            inputEmail.value = data.email;
                            inputAlamat.value = data.alamat;
                            inputNote.value = data.note;
                            inputStatus.checked = data.status == 1;
                        })
                        .catch(error => console.error('Error fetching pemasok data:', error));
                });
            }

            // --- MODAL DELETE ---
            const deleteModal = document.getElementById('deleteConfirmationModal');
            if (deleteModal) {
                deleteModal.addEventListener('show.bs.modal', function (event) {
                    const button = event.relatedTarget;
                    const pemasokId = button.getAttribute('data-pemasok-id');
                    const pemasokName = button.getAttribute('data-pemasok-name');
                    const modalBodyName = deleteModal.querySelector('#pemasokNameToDelete');
                    const deleteForm = deleteModal.querySelector('#deletePemasokForm');

                    modalBodyName.textContent = pemasokName;
                    // Pastikan route untuk delete sudah benar, contoh: /pemasok/{id}
                    deleteForm.action = `{{ url('pemasok') }}/${pemasokId}`;
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
                    // Cek jika baris adalah baris data (bukan header atau lainnya)
                    if (row.cells.length > 5) {
                        const namaCell = row.cells[0];
                        const statusCell = row.cells[5];

                        if (namaCell && statusCell) {
                            const namaText = namaCell.textContent.toLowerCase().trim();
                            const statusText = statusCell.textContent.trim();

                            const namaMatch = namaText.includes(searchText);
                            const statusMatch = (statusValue === "" || statusText === statusValue);

                            row.style.display = (namaMatch && statusMatch) ? "" : "none";
                        }
                    }
                }
            }
            if(searchInput) {
                populateStatusFilter();
                searchInput.addEventListener('keyup', filterTable);
                statusFilter.addEventListener('change', filterTable);
            }

            // --- SHOW CREATE MODAL ON VALIDATION ERROR ---
            const hasError = document.querySelector('.is-invalid');
            @if($errors->any())
                var createModal = new bootstrap.Modal(document.getElementById('createModal'));
                createModal.show();
            @endif

        });
    </script>
    @endpush
</x-layout>

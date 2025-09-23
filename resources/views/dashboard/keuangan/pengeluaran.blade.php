<x-layout>
    @push('styles')
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet">
    @endpush
    {{-- breadcrumb --}}
    @section('breadcrumb')
        @php
        $breadcrumbItems = [
            ['name' => 'Page', 'url' => '/dashboard'],
            ['name' => 'Data Pengeluaran', 'url' => route('pengeluaran.index')],
        ];
        @endphp
        <x-breadcrumb :items="$breadcrumbItems" />
    @endsection

    <div class="container-fluid p-3 ">
        <div class="card rounded-2">
            <div class="card-header pb-0 px-3 pt-2 mb-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-0">Data Pengeluaran</h6>
                        <p class="text-sm mb-0">
                            Kelola pengeluaranmu
                        </p>
                    </div>
                    <div class="ms-md-auto mt-2">
                        {{-- triger-modal-create --}}
                        <button class="btn btn-outline-info mb-0" data-bs-toggle="modal" data-bs-target="#createModal">
                            <i class="fa fa-plus fixed-plugin-button-nav cursor-pointer pe-2"></i> Pengeluaran
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <div class="filter-container">
                    <div class="row g-3 align-items-center justify-content-between">
                        <div class="col-5 col-lg-3 ms-3">
                            <input type="text" id="searchInput" class="form-control" placeholder="Cari keterangan...">
                        </div>
                        <div class="col-5 col-lg-2 me-3">
                            <select id="kategoriFilter" class="form-select">
                                <option value="">Semua Kategori</option>
                                @foreach ($kategoris as $kategori)
                                    <option value="{{ $kategori->nama }}">{{ $kategori->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="table-responsive p-0 my-3">
                    <table class="table table-hover align-items-center justify-content-start mb-0" id="tableData">
                        <thead>
                            <tr class="table-secondary">
                                <th class="text-uppercase text-dark text-xs font-weight-bolder">Referensi</th>
                                <th class="text-uppercase text-dark text-xs font-weight-bolder ps-2">Pengeluaran</th>
                                <th class="text-uppercase text-dark text-xs font-weight-bolder ps-2">Kategori</th>
                                <th class="text-uppercase text-dark text-xs font-weight-bolder ps-2">Detail</th>
                                <th class="text-uppercase text-dark text-xs font-weight-bolder ps-2">Tanggal</th>
                                <th class="text-uppercase text-dark text-xs font-weight-bolder ps-2">Jumlah</th>
                                <th class="text-uppercase text-dark text-xs font-weight-bolder ps-3">Pembuat</th>
                                <th class="text-dark"></th>
                            </tr>
                        </thead>
                        <tbody id="isiTable">
                            @forelse ($pengeluarans as $pengeluaran)
                            <tr>
                                <td>
                                    <p title="referensi" class="ms-3 text-xs text-dark fw-bold mb-0">{{ $pengeluaran->referensi ?? '-' }}</p>
                                </td>

                                <td>
                                    <p title="keterangan pengeluaran" class="text-xs text-dark fw-bold mb-0">{{ $pengeluaran->keterangan }}</p>
                                </td>
                                <td>
                                    <p title="kategori pengeluaran" class="text-xs text-dark fw-bold mb-0">{{ $pengeluaran->kategori_transaksi->nama }}</p>
                                </td>
                                <td>
                                    <p title="Deskripsi" class=" text-xs text-dark fw-bold mb-0">{{ $pengeluaran->deskripsi ? Str::limit(strip_tags($pengeluaran->deskripsi), 40) : '-' }}</p>
                                </td>
                                <td>
                                    <p title="tanggal pengeluaran" class="text-xs text-dark fw-bold mb-0">{{ $pengeluaran->tanggal }}</p>
                                </td>
                                <td>
                                    <p title="jumlah pengeluaran" class="text-xs text-dark fw-bold mb-0">{{ $pengeluaran->harga_formatted }}</p>
                                </td>
                                <td>
                                    <div title="foto & nama user" class="d-flex align-items-center px-2 py-1">
                                        @if ($pengeluaran->user->img_user)
                                            <img src="{{ asset('storage/' . $pengeluaran->user->img_user) }}" class="avatar avatar-sm me-3" alt="user_img">
                                        @else
                                            <img src="{{ asset('assets/img/user.webp') }}" class="avatar avatar-sm me-3" alt="Gambar User default">
                                        @endif
                                        <h6 class="mb-0 text-sm">{{ $pengeluaran->user->nama }}</h6>
                                    </div>
                                </td>

                                <td class="text-center">
                                    <a href="#" class="text-dark fw-bold px-3 text-xs"
                                        data-bs-toggle="modal"
                                        data-bs-target="#editModal"
                                        data-url="{{ route('pengeluaran.getjson', $pengeluaran->id) }}"
                                        data-update-url="{{ route('pengeluaran.update', $pengeluaran->id) }}"
                                        title="Edit pengeluaran">
                                        <i class="bi bi-pencil-square text-dark text-sm opacity-10"></i>
                                    </a>
                                    <a href="#" class="text-dark delete-pengeluaran-btn me-md-4"
                                        data-bs-toggle="modal"
                                        data-bs-target="#deleteConfirmationModal"
                                        data-pengeluaran-id="{{ $pengeluaran->id }}"
                                        data-pengeluaran-name="{{ $pengeluaran->keterangan }}"
                                        title="Hapus pengeluaran">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center py-3">
                                    <p class="text-sm text-dark fw-bold mb-0">Belum ada data pengeluaran.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="my-3 ms-3">{{ $pengeluarans->onEachSide(1)->links() }}</div>
                </div>
            </div>
        </div>

        {{-- modal-create --}}
        <div class="modal fade" id="createModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header border-0 mb-n3">
                        <h6 class="modal-title" id="ModalLabel">Buat Pengeluaran Baru</h6>
                        <button type="button" class="btn btn-close bg-danger rounded-3 me-1" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('pengeluaran.store') }}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="kategori_transaksi_id" class="form-label">Kategori</label>
                                    <select name="kategori_transaksi_id" id="kategori_transaksi_id" class="form-select @error('kategori_transaksi_id') is-invalid @enderror" required>
                                        <option value="">Pilih Kategori</option>
                                        @foreach ($kategoris as $kategori)
                                            <option value="{{ $kategori->id }}" {{ old('kategori_transaksi_id') == $kategori->id ? 'selected' : '' }}>{{ $kategori->nama }}</option>
                                        @endforeach
                                    </select>
                                    @error('kategori_transaksi_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="tanggal" class="form-label">Tanggal</label>
                                    <input id="tanggal" name="tanggal" type="date" class="form-control @error('tanggal') is-invalid @enderror" value="{{ old('tanggal', date('Y-m-d')) }}" required>
                                    @error('tanggal')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="jumlah" class="form-label">Jumlah</label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input id="jumlah" name="jumlah" type="number" class="form-control @error('jumlah') is-invalid @enderror" value="{{ old('jumlah') }}" required min="0">
                                    </div>
                                    @error('jumlah')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="referensi" class="form-label">Referensi</label>
                                    <input id="referensi" name="referensi" type="text" class="form-control @error('referensi') is-invalid @enderror" value="{{ old('referensi', $referensi_otomatis) }}" readonly>
                                    @error('referensi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="keterangan" class="form-label">Pengeluaran Untuk</label>
                                <input id="keterangan" name="keterangan" type="text" class="form-control @error('keterangan') is-invalid @enderror" value="{{ old('keterangan') }}" required>
                                @error('keterangan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="mb-3">
                                <label for="deskripsi" class="form-label">Detail</label>
                                <div id="quill-editor-create" style="min-height: 100px;">{!! old('deskripsi') !!}</div>
                                <input type="hidden" name="deskripsi" id="deskripsi-create" value="{{ old('deskripsi') }}">
                                @error('deskripsi')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            </div>
                            <div class="modal-footer border-0 pb-0">
                                <button type="submit" class="btn btn-outline-info btn-sm">Simpan</button>
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
                        <h6 class="modal-title" id="editModalLabel">Edit Pengeluaran</h6>
                        <button type="button" class="btn btn-close bg-danger rounded-3 me-1" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editPengeluaranForm" method="post">
                            @method('put')
                            @csrf

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="edit_kategori_transaksi_id" class="form-label">Kategori</label>
                                    <select name="kategori_transaksi_id" id="edit_kategori_transaksi_id" class="form-select" required>
                                        <option value="">Pilih Kategori</option>
                                        @foreach ($kategoris as $kategori)
                                            <option value="{{ $kategori->id }}">{{ $kategori->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="edit_tanggal" class="form-label">Tanggal</label>
                                    <input id="edit_tanggal" name="tanggal" type="date" class="form-control" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="edit_jumlah" class="form-label">Jumlah</label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input id="edit_jumlah" name="jumlah" type="number" class="form-control" required min="0">
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="edit_referensi" class="form-label">Referensi</label>
                                    <input id="edit_referensi" name="referensi" type="text" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="edit_keterangan" class="form-label">Pengeluaran Untuk</label>
                                <input id="edit_keterangan" name="keterangan" type="text" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="edit_deskripsi" class="form-label">Detail</label>
                                <div id="quill-editor-edit" style="min-height: 100px;"></div>
                                <input type="hidden" name="deskripsi" id="deskripsi-edit">
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
                        <p class="mb-0">Apakah Anda yakin ingin menghapus pengeluaran ini?</p>
                        <h6 class="mt-2" id="pengeluaranNameToDelete"></h6>
                        <div class="mt-4">
                            <form id="deletePengeluaranForm" method="POST" action="#">
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
        <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // --- INISIALISASI QUILL ---
                let quillCreate, quillEdit;

                // Inisialisasi Quill untuk modal CREATE
                const hiddenInputCreate = document.getElementById('deskripsi-create');
                quillCreate = new Quill('#quill-editor-create', {
                    theme: 'snow',
                    placeholder: 'Tulis detail pengeluaran di sini...',
                });
                quillCreate.on('text-change', () => {
                    hiddenInputCreate.value = quillCreate.root.innerHTML;
                });
                if (hiddenInputCreate.value) {
                    quillCreate.root.innerHTML = hiddenInputCreate.value;
                }

                // Inisialisasi Quill untuk modal EDIT
                const hiddenInputEdit = document.getElementById('deskripsi-edit');
                quillEdit = new Quill('#quill-editor-edit', {
                    theme: 'snow',
                    placeholder: 'Tulis detail pengeluaran di sini...',
                });
                quillEdit.on('text-change', () => {
                    hiddenInputEdit.value = quillEdit.root.innerHTML;
                });

                // --- MODAL EDIT ---
                const editModal = document.getElementById('editModal');
                if (editModal) {
                    editModal.addEventListener('show.bs.modal', function (event) {
                        const button = event.relatedTarget;
                        const dataUrl = button.getAttribute('data-url');
                        const updateUrl = button.getAttribute('data-update-url');

                        const editForm = document.getElementById('editPengeluaranForm');
                        editForm.action = updateUrl;

                        fetch(dataUrl)
                            .then(response => response.json())
                            .then(data => {
                                document.getElementById('edit_keterangan').value = data.keterangan;
                                document.getElementById('edit_kategori_transaksi_id').value = data.kategori_pengeluaran_id;
                                document.getElementById('edit_tanggal').value = data.tanggal;
                                document.getElementById('edit_jumlah').value = data.jumlah;
                                document.getElementById('edit_referensi').value = data.referensi;

                                // Isi editor Quill dan input hidden
                                quillEdit.root.innerHTML = data.deskripsi || '';
                                hiddenInputEdit.value = data.deskripsi || '';
                            })
                            .catch(error => console.error('Error fetching pengeluaran data:', error));
                    });
                }

                // --- MODAL DELETE ---
                const deleteModal = document.getElementById('deleteConfirmationModal');
                if (deleteModal) {
                    deleteModal.addEventListener('show.bs.modal', function (event) {
                        const button = event.relatedTarget;
                        const pengeluaranId = button.getAttribute('data-pengeluaran-id');
                        const pengeluaranName = button.getAttribute('data-pengeluaran-name');

                        const modalBodyName = deleteModal.querySelector('#pengeluaranNameToDelete');
                        const deleteForm = deleteModal.querySelector('#deletePengeluaranForm');

                        modalBodyName.textContent = pengeluaranName;
                        deleteForm.action = `/pengeluaran/${pengeluaranId}`;
                    });
                }

                // --- FILTER ---
                const searchInput = document.getElementById('searchInput');
                const kategoriFilter = document.getElementById('kategoriFilter');
                const tableBody = document.getElementById('isiTable');
                const rows = tableBody.getElementsByTagName('tr');

                function filterTable() {
                    const searchText = searchInput.value.toLowerCase();
                    const kategoriValue = kategoriFilter.value;

                    for (let i = 0; i < rows.length; i++) {
                        const row = rows[i];
                        const keteranganCell = row.cells[1];
                        const kategoriCell = row.cells[2];

                        if (keteranganCell && kategoriCell) {
                            const keteranganText = keteranganCell.textContent.toLowerCase().trim();
                            const kategoriText = kategoriCell.textContent.trim();

                            const searchMatch = keteranganText.includes(searchText);
                            const kategoriMatch = (kategoriValue === "" || kategoriText === kategoriValue);

                            row.style.display = (searchMatch && kategoriMatch) ? "" : "none";
                        }
                    }
                }

                if(searchInput) searchInput.addEventListener('keyup', filterTable);
                if(kategoriFilter) kategoriFilter.addEventListener('change', filterTable);

                // --- SHOW CREATE MODAL ON VALIDATION ERROR ---
                const hasError = document.querySelector('.is-invalid');
                if (hasError) {
                    var createModal = new bootstrap.Modal(document.getElementById('createModal'));
                    createModal.show();
                }

            });
        </script>
    @endpush
</x-layout>

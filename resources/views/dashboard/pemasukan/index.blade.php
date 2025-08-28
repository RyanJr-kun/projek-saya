<x-layout>
    {{-- breadcrumb --}}
    @section('breadcrumb')
        @php
        $breadcrumbItems = [
            ['name' => 'Page', 'url' => '/dashboard'],
            ['name' => 'Data Pemasukan', 'url' => route('pemasukan.index')],
        ];
        @endphp
        <x-breadcrumb :items="$breadcrumbItems" />
    @endsection

    {{-- notif --}}
    @if (session()->has('success') || session()->has('error'))
        @php
            $toastType = session()->has('success') ? 'success' : 'error';
            $toastMessage = session('success') ?? session('error');
            $toastHeaderBg = $toastType === 'success' ? 'bg-success' : 'bg-warning';
            $toastIcon = $toastType === 'success' ? 'bi bi-hand-thumbs-up-fill' : 'bi bi-exclamation-triangle';
        @endphp
        <div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 1055">
            <div id="notificationToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header {{ $toastHeaderBg }} text-white">
                    <span class="alert-icon text-light me-2"><i class="{{ $toastIcon }}"></i></span>
                    <strong class="me-auto">Notifikasi</strong>
                    <small class="text-light">Baru saja</small>
                    <button type="button" class="btn-close btn-light" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    {{ $toastMessage }}
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
                                <h6 class="mb-0">Data Pemasukan</h6>
                                <p class="text-sm mb-0">
                                    Kelola pemasukanmu
                                </p>
                            </div>
                            <div class="ms-md-auto mt-2">
                                {{-- triger-modal-create --}}
                                <button class="btn btn-outline-info mb-0" data-bs-toggle="modal" data-bs-target="#createModal">
                                    <i class="fa fa-plus fixed-plugin-button-nav cursor-pointer pe-2"></i> Pemasukan
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
                                        <th class="text-uppercase text-dark text-xs font-weight-bolder ps-2">Pemasukan</th>
                                        <th class="text-uppercase text-dark text-xs font-weight-bolder ps-2">Kategori</th>
                                        <th class="text-uppercase text-dark text-xs font-weight-bolder ps-2">Detail</th>
                                        <th class="text-uppercase text-dark text-xs font-weight-bolder ps-2">Tanggal</th>
                                        <th class="text-uppercase text-dark text-xs font-weight-bolder ps-2">Jumlah</th>
                                        <th class="text-uppercase text-dark text-xs font-weight-bolder ps-3">Pembuat</th>
                                        <th class="text-dark"></th>
                                    </tr>
                                </thead>
                                <tbody id="isiTable">
                                    @forelse ($pemasukans as $pemasukan)
                                    <tr>
                                        <td>
                                            <p title="referensi" class="ms-3 text-xs text-dark fw-bold mb-0">{{ $pemasukan->referensi ?? '-' }}</p>
                                        </td>

                                        <td>
                                            <p title="keterangan pemasukan" class="text-xs text-dark fw-bold mb-0">{{ $pemasukan->keterangan }}</p>
                                        </td>
                                        <td>
                                            <p title="kategori pemasukan" class="text-xs text-dark fw-bold mb-0">{{ $pemasukan->kategori_pemasukan->nama }}</p>
                                        </td>
                                        <td>
                                            <p title="Deskripsi" class=" text-xs text-dark fw-bold mb-0">{{ $pemasukan->deskripsi ? Str::limit(strip_tags($pemasukan->deskripsi), 40) : '-' }}</p>
                                        </td>
                                        <td>
                                            <p title="tanggal pemasukan" class="text-xs text-dark fw-bold mb-0">{{ $pemasukan->tanggal }}</p>
                                        </td>
                                        <td>
                                            <p title="jumlah pemasukan" class="text-xs text-dark fw-bold mb-0">{{ $pemasukan->harga_formatted }}</p>
                                        </td>
                                        <td>
                                            <div title="foto & nama user" class="d-flex align-items-center px-2 py-1">
                                                <img src="{{ asset('storage/' . $pemasukan->user->img_user) }}" class="avatar avatar-sm me-3" alt="user_img">
                                                <h6 class="mb-0 text-sm">{{ $pemasukan->user->nama }}</h6>
                                            </div>
                                        </td>

                                        <td class="text-center">
                                            <a href="#" class="text-dark fw-bold px-3 text-xs"
                                                data-bs-toggle="modal"
                                                data-bs-target="#editModal"
                                                data-url="{{ route('pemasukan.getjson', $pemasukan->id) }}"
                                                data-update-url="{{ route('pemasukan.update', $pemasukan->id) }}"
                                                title="Edit pemasukan">
                                                <i class="bi bi-pencil-square text-dark text-sm opacity-10"></i>
                                            </a>
                                            <a href="#" class="text-dark delete-pemasukan-btn me-md-4"
                                                data-bs-toggle="modal"
                                                data-bs-target="#deleteConfirmationModal"
                                                data-pemasukan-id="{{ $pemasukan->id }}"
                                                data-pemasukan-name="{{ $pemasukan->keterangan }}"
                                                title="Hapus pemasukan">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="8" class="text-center">
                                            <p class="text-xs text-dark fw-bold mb-0">Tidak ada data pemasukan.</p>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            <div class="my-3 ms-3">{{ $pemasukans->onEachSide(1)->links() }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- modal-create --}}
        <div class="modal fade" id="createModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header border-0 mb-n3">
                        <h6 class="modal-title" id="ModalLabel">Buat Pemasukan Baru</h6>
                        <button type="button" class="btn btn-close bg-danger rounded-3 me-1" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('pemasukan.store') }}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="kategori_pemasukan_id" class="form-label">Kategori</label>
                                    <select name="kategori_pemasukan_id" id="kategori_pemasukan_id" class="form-select @error('kategori_pemasukan_id') is-invalid @enderror" required>
                                        <option value="">Pilih Kategori</option>
                                        @foreach ($kategoris as $kategori)
                                            <option value="{{ $kategori->id }}" {{ old('kategori_pemasukan_id') == $kategori->id ? 'selected' : '' }}>{{ $kategori->nama }}</option>
                                        @endforeach
                                    </select>
                                    @error('kategori_pemasukan_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
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
                                    <label for="referensi" class="form-label">Referensi (Opsional)</label>
                                    <input id="referensi" name="referensi" type="text" class="form-control @error('referensi') is-invalid @enderror" value="{{ old('referensi') }}">
                                    @error('referensi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="keterangan" class="form-label">Pemasukan Untuk</label>
                                <input id="keterangan" name="keterangan" type="text" class="form-control @error('keterangan') is-invalid @enderror" value="{{ old('keterangan') }}" required>
                                @error('keterangan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="mb-3">
                                <label for="deskripsi" class="form-label">Detail</label>
                                <textarea id="deskripsi" name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" rows="3">{{ old('deskripsi') }}</textarea>
                                @error('deskripsi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="modal-footer border-0 pb-0">
                                <button type="submit" class="btn btn-info btn-sm">Simpan</button>
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
                        <h6 class="modal-title" id="editModalLabel">Edit Pemasukan</h6>
                        <button type="button" class="btn btn-close bg-danger rounded-3 me-1" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editPemasukanForm" method="post">
                            @method('put')
                            @csrf

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="edit_kategori_pemasukan_id" class="form-label">Kategori</label>
                                    <select name="kategori_pemasukan_id" id="edit_kategori_pemasukan_id" class="form-select" required>
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
                                    <label for="edit_referensi" class="form-label">Referensi (Opsional)</label>
                                    <input id="edit_referensi" name="referensi" type="text" class="form-control">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="edit_keterangan" class="form-label">Pemasukan Untuk</label>
                                <input id="edit_keterangan" name="keterangan" type="text" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="edit_deskripsi" class="form-label">Detail</label>
                                <textarea id="edit_deskripsi" name="deskripsi" class="form-control" rows="3"></textarea>
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
                        <p class="mb-0">Apakah Anda yakin ingin menghapus pemasukan ini?</p>
                        <h6 class="mt-2" id="pemasukanNameToDelete"></h6>
                        <div class="mt-4">
                            <form id="deletePemasukanForm" method="POST" action="#">
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

                        const editForm = document.getElementById('editPemasukanForm');
                        editForm.action = updateUrl;

                        fetch(dataUrl)
                            .then(response => response.json())
                            .then(data => {
                                document.getElementById('edit_keterangan').value = data.keterangan;
                                document.getElementById('edit_kategori_pemasukan_id').value = data.kategori_pemasukan_id;
                                document.getElementById('edit_tanggal').value = data.tanggal;
                                document.getElementById('edit_jumlah').value = data.jumlah;
                                document.getElementById('edit_referensi').value = data.referensi;
                                document.getElementById('edit_deskripsi').value = data.deskripsi;
                            })
                            .catch(error => console.error('Error fetching pemasukan data:', error));
                    });
                }

                // --- MODAL DELETE ---
                const deleteModal = document.getElementById('deleteConfirmationModal');
                if (deleteModal) {
                    deleteModal.addEventListener('show.bs.modal', function (event) {
                        const button = event.relatedTarget;
                        const pemasukanId = button.getAttribute('data-pemasukan-id');
                        const pemasukanName = button.getAttribute('data-pemasukan-name');

                        const modalBodyName = deleteModal.querySelector('#pemasukanNameToDelete');
                        const deleteForm = deleteModal.querySelector('#deletePemasukanForm');

                        modalBodyName.textContent = pemasukanName;
                        deleteForm.action = `/pemasukan/${pemasukanId}`;
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

                // --- TOAST NOTIFICATION ---
                var toastElement = document.getElementById('notificationToast');
                if (toastElement) {
                    var toast = new bootstrap.Toast(toastElement);
                    toast.show();
                }
            });
        </script>
    @endpush
</x-layout>

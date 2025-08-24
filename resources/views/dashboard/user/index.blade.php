<x-layout>
    {{-- breadcrumb --}}
    @section('breadcrumb')
        @php
        // Definisikan item breadcrumb dalam bentuk array
        $breadcrumbItems = [
            ['name' => 'Page', 'url' => '/dashboard'],
            ['name' => 'Manajemen User', 'url' => route('users.index')],
        ];
        @endphp

        {{-- Panggil component breadcrumb dan kirim datanya --}}
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
                <div class="card mb-3 ">
                    <div class="card-header pb-0 px-3 pt-2 mb-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="mb-0">Data Pengguna</h5>
                                    <p class="text-sm mb-0">
                                    Kelola data penggunamu
                                </p>
                            </div>
                            <div class="ms-auto my-auto mt-2">
                                <div class="ms-auto mb-0">
                                    {{-- triger modal create user baru --}}
                                    <a href="{{ route('users.create') }}">
                                        <button class="btn btn-outline-info"><i class="bi bi-plus-lg fixed-plugin-button-nav cursor-pointer pe-2"></i>Buat User</button>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="filter-container">
                            <div class="row g-3 align-items-center justify-content-between">
                                <div class="col-5 col-lg-3 ms-3">
                                    <input type="text" id="searchInput" class="form-control" placeholder="cari pengguna ...">
                                </div>
                                <div class="col-5 col-lg-2 me-3">
                                    <select id="posisiFilter" class="form-select">
                                        <option value="">Semua Posisi</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive p-0 my-3">
                            <table class="table table-hover align-items-center justify-content-start mb-0" id="tableData">
                                <thead>
                                    <tr class="table-secondary">
                                        <th class="text-uppercase text-dark text-xs font-weight-bolder">Nama</th>
                                        <th class="text-uppercase text-dark text-xs font-weight-bolder ps-2">kontak</th>
                                        <th class="text-uppercase text-dark text-xs font-weight-bolder ps-2">Posisi</th>
                                        <th class="text-uppercase text-dark text-xs font-weight-bolder text-center">Mulai Bekerja</th>
                                        <th class="text-uppercase text-dark text-xs font-weight-bolder text-center">status</th>
                                        <th class="text-dark"></th>
                                    </tr>
                                </thead>
                                <tbody id="isiTable">
                                    @foreach ($users as $user)
                                    <tr>
                                        <td>
                                            <div title="image & Nama User" class="d-flex align-items-center px-2 py-1">
                                                @if ($user->img_user)
                                                    <img src="{{ asset('storage/' . $user->img_user) }}" class="avatar avatar-sm me-3" alt="{{ $user->nama }}">
                                                @else
                                                    <img src="{{ asset('assets/img/user.webp') }}" class="avatar avatar-sm me-3" alt="Gambar produk default">
                                                @endif
                                                <h6 class="mb-0 text-sm">{{ $user->nama }}</h6>
                                            </div>
                                        </td>
                                        <td>
                                            <p title="nomer whatsapp" class="text-xs text-dark fw-bold mb-0">{{ $user->kontak }}</p>
                                            <p title="email" class="text-xs text-dark mb-0">{{ $user->email }}</p>
                                        </td>

                                        <td>
                                            <p title="Role user" class="text-xs text-dark fw-bold mb-0">{{ $user->role->nama }}</p>
                                        </td>

                                        <td class="align-middle text-center">
                                            <span class="text-dark text-xs fw-bold">{{ $user->mulai_kerja?->translatedFormat('d M Y')}}</span>
                                        </td>

                                        <td class="align-middle text-center text-sm">
                                            @if ($user->status)
                                                <span class="badge badge-success">Aktif</span>
                                            @else
                                                <span class="badge badge-secondary">Tidak Aktif</span>
                                            @endif
                                        </td>

                                        <td class="align-middle">
                                            <a href="{{ route('users.edit', $user->username) }}" class="text-dark fw-bold px-3 text-xs" data-toggle="tooltip" data-original-title="Edit user">
                                                <i class="bi bi-pencil-square text-dark text-sm opacity-10"></i>
                                            </a>
                                            <a href="#" class="text-dark delete-user-btn"
                                                data-bs-toggle="modal"
                                                data-bs-target="#deleteConfirmationModal"
                                                data-user-username="{{ $user->username }}"
                                                data-user-name="{{ $user->nama }}"
                                                title="Hapus User">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="my-3 ms-3">{{ $users->onEachSide(1)->links() }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body text-center mt-3 mx-n5">
                        <i class="bi bi-trash fa-3x text-danger mb-3"></i>
                        <p class="mb-0">Apakah Anda yakin ingin menghapus user ini?</p>
                        <h6 class="mt-2" id="userNameToDelete"></h6>
                        <div class="mt-4">
                            <form id="deleteUserForm" method="POST" action="#">
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
                const searchInput = document.getElementById('searchInput');
                const posisiFilter = document.getElementById('posisiFilter');
                const tableBody = document.getElementById('isiTable');
                const rows = tableBody.getElementsByTagName('tr');

            function populatePosisiFilter() {
                const posisiSet = new Set();
                for (let row of rows) {
                    // Kolom ke-3 (indeks 2) adalah Posisi
                    const posisiCell = row.getElementsByTagName('td')[2];
                    if (posisiCell) {
                        // Mengambil teks dari dalam <p>
                        const posisiText = posisiCell.querySelector('p').textContent.trim();
                        posisiSet.add(posisiText);
                    }
                }

                posisiSet.forEach(posisi => {
                    const option = document.createElement('option');
                    option.value = posisi;
                    option.textContent = posisi;
                    posisiFilter.appendChild(option);
                });
            }

            function filterTable() {
                const searchText = searchInput.value.toLowerCase();
                const posisiValue = posisiFilter.value;

                for (let i = 0; i < rows.length; i++) {
                    const row = rows[i];
                    // Kolom pertama (indeks 0) adalah Nama
                    const namaCell = row.getElementsByTagName('td')[0];
                    // Kolom ketiga (indeks 2) adalah Posisi
                    const posisiCell = row.getElementsByTagName('td')[2];

                    if (namaCell && posisiCell) {
                        // Mengambil teks dari dalam tag <h6>
                        const namaElement = namaCell.querySelector('h6');
                        const posisiElement = posisiCell.querySelector('p');

                        if(namaElement && posisiElement){
                            const namaText = namaElement.textContent.toLowerCase();
                            const posisiText = posisiElement.textContent;

                            // Cek kondisi filter
                            const namaMatch = namaText.includes(searchText);
                            const posisiMatch = (posisiValue === "" || posisiText === posisiValue);

                            // Tampilkan atau sembunyikan baris
                            if (namaMatch && posisiMatch) {
                                row.style.display = "";
                            } else {
                                row.style.display = "none";
                            }
                        }
                    }
                }
            }

            // Panggil fungsi untuk mengisi dropdown saat halaman dimuat
            populatePosisiFilter();

            // Tambahkan event listener ke input pencarian dan dropdown
            searchInput.addEventListener('keyup', filterTable);
            posisiFilter.addEventListener('change', filterTable);
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
            });
        </script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const deleteModal = document.getElementById('deleteConfirmationModal');
                if (deleteModal) {
                    deleteModal.addEventListener('show.bs.modal', function (event) {
                        const button = event.relatedTarget;

                        // Ambil 'username' dari atribut data-*
                        const userUsername = button.getAttribute('data-user-username'); // <-- DIUBAH DI SINI
                        const userName = button.getAttribute('data-user-name');

                        const modalBodyName = deleteModal.querySelector('#userNameToDelete');
                        const deleteForm = deleteModal.querySelector('#deleteUserForm');

                        modalBodyName.textContent = userName;

                        // Atur action form menggunakan username
                        deleteForm.action = `/users/${userUsername}`; // <-- DIUBAH DI SINI
                    });
                }
            });
        </script>
    @endpush
</x-layout>

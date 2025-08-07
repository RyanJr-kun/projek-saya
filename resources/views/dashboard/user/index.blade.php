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
    {{-- notif-success-create-user --}}
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

    <div class="container-fluid d-flex flex-column min-vh-100 p-3 mb-auto ">
        <div class="row ">
            <div class="col-12 ">
                <div class="card mb-4 ">
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
                        <!-- Filter Pencarian Nama & kategori role -->
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
                                            <div title="foto & nama user" class="d-flex ms-2 px-2 py-1 align-items-center">
                                                <div>
                                                    <img src="{{ asset('storage/' . $user->img_user) }}" class="avatar avatar-sm me-3">
                                                </div>
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">{{ $user->nama }}</h6>
                                                </div>
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
                                            {{-- <a href="#" class="text-dark fw-bold text-xs" data-toggle="tooltip" data-original-title="Delete user">
                                                <i class="bi bi-eye text-dark text-sm opacity-10"></i>
                                            </a> --}}
                                            <a href="{{ route('users.edit', $user->username) }}" class="text-dark fw-bold px-3 text-xs" data-toggle="tooltip" data-original-title="Edit user">
                                                <i class="bi bi-pencil-square text-dark text-sm opacity-10"></i>
                                            </a>
                                            <a href="#" class="text-dark fw-bold text-xs" data-toggle="tooltip" data-original-title="Delete user">
                                                <i class="bi bi-trash3 text-dark text-sm opacity-10"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <x-footer></x-footer>
    </div>

@push('scripts')
<script>
        // ngambil gambar dan tampilin dia area border
        // Get the necessary elements from the DOM (Document Object Model)
        const uploadInput = document.getElementById('img');
        const previewBox = document.getElementById('imagePreviewBox');

        // Add an event listener to the file input that triggers when a file is chosen
        uploadInput.addEventListener('change', function(event) {
            // Get the file selected by the user from the event object
            const file = event.target.files[0];

            // Check if a file was actually selected
            if (file) {
                // Create a new FileReader object to read the file
                const reader = new FileReader();

                // Define what happens once the reader has finished loading the file
                reader.onload = function(e) {
                    // Create a new image element
                    const img = document.createElement('img');
                    // Set the source of the image to the result of the file read
                    img.src = e.target.result;

                    // Apply some styles to make the image fit perfectly in the box
                    img.style.width = '100%';
                    img.style.height = '100%';
                    img.style.objectFit = 'cover'; // This prevents the image from being stretched
                    img.style.borderRadius = '0.25rem'; // Match the parent's border radius

                    // Clear the initial content (the icon and text) from the preview box
                    previewBox.innerHTML = '';
                    // Append the newly created image element to the preview box
                    previewBox.appendChild(img);
                };

                // Start reading the file. The result will be a base64 encoded string.
                reader.readAsDataURL(file);
            }
        });

</script>
<script>
    // buat fitur search berdasarkan nama dan filter berdasarkan roles atau posisi
    document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const posisiFilter = document.getElementById('posisiFilter');
    // Menggunakan ID tbody yang Anda berikan: 'isiTable'
    const tableBody = document.getElementById('isiTable');
    const rows = tableBody.getElementsByTagName('tr');

    // --- Fungsi untuk mengisi dropdown posisi secara dinamis ---
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

    // --- Fungsi utama untuk memfilter tabel ---
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
                // **PERUBAHAN PENTING**: Mengambil teks dari dalam tag <h6>
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
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var toastElement = document.getElementById('successToast');
        if (toastElement) {
            var toast = new bootstrap.Toast(toastElement);
            toast.show();
        }
    });
</script>
@endpush

</x-layout>

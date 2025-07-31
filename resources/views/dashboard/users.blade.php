<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>

   @if (session()->has('success'))
        <div class="toast-container position-fixed bottom-0 end-0 p-3">
            <div id="successToast" class="toast align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                <div class="toast-body">
                    <span class="alert-icon"><i class="ni ni-like-2 me-2"></i></span>
                    {{ session('success') }}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        </div>
    @endif
    <div class="toast align-items-center text-white bg-primary border-0" role="alert" aria-live="assertive" aria-atomic="true">
  <div class="d-flex">
    <div class="toast-body">
      Hello, world! This is a toast message.
    </div>
    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
  </div>
</div>
    <div class="container-fluid d-flex flex-column min-vh-100 p-3 mb-auto ">
        <div class="row ">
            <div class="col-12 ">
                <div class="card mb-4 ">
                    <div class="card-hrader pb-0 px-3 pt-2 mb-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="mb-0">Data Pengguna</h5>
                                    <p class="text-sm mb-0">
                                    Kelola data penggunamu
                                </p>
                            </div>
                            <div class="ms-auto my-auto mt-2">
                                <div class="ms-auto mb-0">
                                    {{-- button export pdf/excel user gak perlu ini --}}
                                    {{-- <a href="#Export-Pdf" type="button" class="btn btn-outline-primary me-2 p-2 mb-0" title="Export PDF" >
                                        <img src="assets/img/pdf.png" alt="Download PDF" width="20" height="20">
                                    </a>
                                    <a href="#Export-Excel" class="btn btn-outline-primary p-2 me-2 export mb-0 " data-type="csv" type="button" title="Export Excel">
                                        <img src="assets/img/xls.png" alt="Download PDF" width="20" height="20">
                                    </a> --}}

                                    {{-- triger-modal --}}
                                    <button class="btn bg-gradient-blue text-white " data-bs-toggle="modal" data-bs-target="#import"><i class="fa fa-plus fixed-plugin-button-nav cursor-pointer pe-2"></i>Buat User
                                    </button>
                                    {{-- start-modal-add-user--}}
                                    <div class="modal fade" id="import" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog mt-lg-4">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="ModalLabel">Buat Pengguna Baru</h5>
                                                    <button type="button" class="btn-close bg-dark me-1" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="/users" method="post">
                                                    @csrf
                                                        <div class="row">
                                                            <div class="d-flex align-items-center gap-3 mb-3">
                                                                <div id="imagePreviewBox" class="border rounded p-2 d-flex justify-content-center align-items-center" style="height: 150px; width: 150px; border-style: dashed !important; border-width: 2px !important;">
                                                                    <div class="text-center text-muted">
                                                                        <i class="fa-solid fa-cloud-arrow-up fs-4"></i>
                                                                        <p class="mb-0 small">Image Preview</p>
                                                                    </div>
                                                                </div>
                                                                <div class="ms-3 text-center">
                                                                    <label for="img" class="btn btn-outline-primary">Upload Image</label>
                                                                    <input type="file" id="img" class="d-none" accept="image/jpeg, image/png">
                                                                    <p class="text-muted mt-2 ps-2 small">JPEG, PNG up to 2MB</p>
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="form-group">
                                                                    <label for="nama" class="form-label">Nama <span class="text-danger">*</span></label>
                                                                    <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" placeholder="Nama" value="{{ old('nama') }}" required>
                                                                    @error('nama')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                    @enderror
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="username" class="form-label">Username <span class="text-danger">*</span></label>
                                                                    <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" name="username" placeholder="Username"  value="{{ old('username') }}" required>
                                                                    @error('username')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                    @enderror
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="role_id" class="form-label">Posisi <span class="text-danger">*</span></label>
                                                                    <select class="form-select" id="role_id" name="role_id" required>
                                                                        <option value="" disabled selected>Pilih Role...</option>
                                                                        @foreach ($roles as $role)
                                                                            <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}> {{ $role->nama }} </option>
                                                                        @endforeach
                                                                    </select>
                                                                    @error('role_id')
                                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                                    @enderror
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                                                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="example@gmail.com" value="{{ old('email') }}" required>
                                                                    @error('email')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                    @enderror
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="kontak" class="form-label">Kontak</label>
                                                                    <input type="tel" class="form-control" value="{{ old('kontak') }}" id="kontak" name="kontak">
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="mulai_kerja" class="form-label">Mulai Bekerja</label>
                                                                    <input id="mulai_kerja" name="mulai_kerja" class="form-control datepicker" value="{{ old('mulai_kerja') }}" placeholder="Please select date" type="date" required>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="password">Password <span class="text-danger">*</span></label>
                                                                    <input name="password" id="password" class="form-control @error('password') is-invalid @enderror" type="password" placeholder="*****" required>
                                                                    @error('password')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                                <div class="justify-content-end mt-4 form-check form-switch form-check-reverse">
                                                                    <label class="me-auto form-check-label" for="status_toggle">Status</label>
                                                                    <input type="hidden" name="status" value="tidak">
                                                                    <input class="form-check-input" type="checkbox" role="switch" id="status_toggle" name="status" value="aktif" checked >
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-outline-success btn-sm">Buat User</button>
                                                            <button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal">Batalkan</button>
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
                                <!-- Filter Pencarian Nama -->
                                <div class="col-5 col-lg-3 ms-3">
                                    <input type="text" id="searchInput" class="form-control" placeholder="cari pengguna ...">
                                </div>
                                <!-- Filter Dropdown Posisi -->
                                <div class="col-5 col-lg-2 me-3">
                                    <select id="posisiFilter" class="form-select">
                                        <option value="">Semua Posisi</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive p-0 mt-4">
                            <table class="table table-hover align-items-center justify-content-start mb-0" id="tableData">
                                <thead>
                                    <tr class="table-secondary">
                                    <th class="text-uppercase text-dark text-xs font-weight-bolder">
                                    <input type="checkbox" id="check-all" class="me-4">Nama</th>
                                    <th class="text-uppercase text-dark text-xs font-weight-bolder ps-2">kontak</th>
                                    <th class="text-uppercase text-dark text-xs font-weight-bolder ps-2">Posisi</th>
                                    <th class="text-center text-uppercase text-dark text-xs font-weight-bolder">Mulai Bekerja</th>
                                    <th class="text-center text-uppercase text-dark text-xs font-weight-bolder">status</th>
                                    <th class="text-dark"></th>
                                    </tr>
                                </thead>
                                <tbody id="isiTable">
                                    @foreach ($users as $user)
                                    <tr>

                                        <td>
                                            <div class="d-flex ms-2 px-2 py-1 align-items-center">
                                                <input name="checkboxUser" type="checkbox" class="check-item me-4 dark mb-0">
                                                <div>
                                                    <img src="{{ $user->img_user }}" class="avatar avatar-sm me-3">
                                                </div>
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">{{ $user->nama }}</h6>
                                                </div>
                                            </div>
                                        </td>

                                        <td>
                                            <p class="text-xs text-dark fw-bold mb-0">{{ $user->kontak }}</p>
                                            <p class="text-xs text-dark mb-0">{{ $user->email }}</p>
                                        </td>

                                        <td>
                                            <p class="text-xs text-dark fw-bold mb-0">{{ $user->role->nama }}</p>
                                        </td>

                                        <td class="align-middle text-center">
                                            <span class="text-dark text-xs fw-bold">{{ $user->mulai_kerja?->translatedFormat('d M Y')}}</span>
                                        </td>

                                        <td class="align-middle text-center text-sm">
                                            <span class="badge {{ strtolower($user['status']) == 'aktif' ? 'badge-success' : 'badge-secondary' }}">{{ $user->status }} </span>
                                        </td>

                                        <td class="align-middle">
                                            <a href="/dashboard/user/{{ $user->id }}" class="text-dark fw-bold pe-3 text-xs" data-toggle="tooltip" data-original-title="Edit user">
                                                <i class="fa fa-pen-to-square text-dark text-sm opacity-10"></i>
                                            </a>
                                            <a href="#" class="text-dark fw-bold text-xs" data-toggle="tooltip" data-original-title="Delete user">
                                                <i class="fa fa-trash text-dark text-sm opacity-10"></i>
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
  // Wait for the document to be fully loaded
  document.addEventListener('DOMContentLoaded', function() {
    // Select the toast element by its ID
    var toastEl = document.getElementById('successToast');

    // If the toast element exists, create a new Bootstrap toast instance and show it
    if (toastEl) {
      var toast = new bootstrap.Toast(toastEl);
      toast.show();
    }
  });
</script>
@endpush
</x-layout>

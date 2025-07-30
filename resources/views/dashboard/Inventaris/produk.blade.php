<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>
    <div class="container-fluid d-flex flex-column min-vh-100 p-3 mb-auto ">
      <div class="row ">
        <div class="col-12 ">
          <div class="card mb-4 ">
            <div class="card-header pb-0 p-3 mb-3 ">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0">Data Produk</h5>
                            <p class="text-sm mb-0">
                            Kelola Data Produkmu
                        </p>
                    </div>
            <div class="ms-auto my-auto mt-lg-0 mt-4">
                <div class="ms-auto mb-3">
                    <div class="d-none d-md-block">
                        <a href="#Export-Pdf" type="button" class="btn btn-outline-primary me-2 p-2 mb-0" title="Export PDF">
                            <img src="assets/img/pdf.png" alt="Download PDF" width="20" height="20">
                        </a>
                        <a href="#Export-Excel" class="btn btn-outline-primary p-2 me-2 export mb-0" data-type="csv" type="button" title="Export Excel">
                            <img src="assets/img/xls.png" alt="Download Excel" width="20" height="20">
                        </a>
                        <button class="btn bg-gradient-blue text-white mb-0" data-bs-toggle="modal" data-bs-target="#import">
                            <i class="fa fa-plus cursor-pointer pe-2"></i>Buat produk
                        </button>
                    </div>
                    <div class="dropdown d-block d-md-none">
                        <button class="btn bg-gradient-blue text-white dropdown-toggle mb-0" type="button" id="aksiMobile" data-bs-toggle="dropdown" aria-expanded="false">Pilih Aksi</button>
                        <ul class="dropdown-menu" aria-labelledby="aksiMobile">
                            <li>
                                <a class="dropdown-item" href="#Export-Pdf">
                                    <img src="assets/img/pdf.png" alt="Download PDF" width="20" height="20" class="me-2">Export PDF
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item export" href="#Export-Excel" data-type="csv">
                                    <img src="assets/img/xls.png" alt="Download Excel" width="20" height="20" class="me-2">Export Excel
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#import">
                                    <i class="fa fa-plus cursor-pointer pe-2"></i>Buat produk
                                </a>
                            </li>
                        </ul>
                    </div>

                        {{-- start-modal-add-user--}}
            <div class="modal fade" id="import" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog mt-lg-4">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="ModalLabel">Buat Pengguna Baru</h5>
                            <button type="button" class="btn btn-close bg-danger rounded-3 me-1" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
        <div class="modal-body">
            <form>
                <div class="row">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div id="imagePreviewBox" class="border rounded p-2 d-flex justify-content-center align-items-center" style="height: 150px; width: 150px; border-style: dashed !important; border-width: 2px !important;">
                         {{-- area gambar --}}
                        <div class="text-center text-muted">
                            <i class="fa-solid fa-cloud-arrow-up fs-4"></i>
                            <p class="mb-0 small">Image Preview</p>
                        </div>
                    </div>
                        <div class="ms-3 text-center">
                            <label for="uploadImageInput" class="btn btn-outline-primary">Upload Image</label>
                            <input type="file" id="uploadImageInput" class="d-none" accept="image/jpeg, image/png">
                            <p class="text-muted mt-2 ps-2 small">JPEG, PNG up to 2MB</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="mb-3">
                            <label for="userInput" class="form-label">Nama <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="userInput" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="roleSelect" class="form-label">Role <span class="text-danger">*</span></label>
                            <select class="form-select" id="roleSelect" required>
                                <option selected>Choose...</option>
                                <option value="1">Admin</option>
                                <option value="2">Kasir</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="emailInput" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="emailInput" placeholder="example@gmail.com" required>
                        </div>
                        <div class="form-group">
                            <label for="phoneInput" class="form-label">Phone <span class="text-danger">*</span></label>
                            <input type="tel" class="form-control" id="phoneInput" required>
                        </div>
                    </div>
                  </div>
                  <div class="row mb-3">
                        <div class="col-12 col-sm-6">
                          <label for="passwordInput" >Password <span class="text-danger">*</span></label>
                          <input id="passwordInput" class="multisteps-form__input form-control" type="password" placeholder="******" onfocus="focused(this)" onfocusout="defocused(this)">
                        </div>
                        <div class="col-12 col-sm-6">
                          <label for="passwordRepeat">Repeat Password <span class="text-danger">*</span></label>
                          <input id="passwordRepeat" class="multisteps-form__input form-control" type="password" placeholder="******" onfocus="focused(this)" onfocusout="defocused(this)">
                        </div>
                      </div>
                            <div class="justify-content-end mt-4 form-check form-switch form-check-reverse">
                                <label class="me-auto form-check-label" for="switchCheckReverse">Status</label>
                                    <input class="form-check-input text-success" type="checkbox" role="switch" id="switchCheckReverse">
                            </div>
                        </form>
                    </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-success btn-sm">Submit</button>
                            <button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal">Cancel
                        </button>
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
                <div class="filter-container mb-3">
                    <div class="row g-3 align-items-center justify-content-between">
                        <!-- Filter Pencarian Nama -->
                        <div class="col-5 col-lg-3 ms-3">
                            <input type="text" id="searchInput" class="form-control" placeholder="cari produk ...">
                        </div>
                        <!-- Filter Dropdown Posisi -->
                        <div class="col-5 col-lg-2 me-3">
                            <select id="posisiFilter" class="form-select">
                                <option value="">Semua kategori</option>
                            </select>
                        </div>
                    </div>
                </div>
              <div class="table-responsive p-0 mt-4">
                <table class="table table-hover align-items-center pb-3" id="tableData">
                  <thead>
                    <tr class="table-secondary">
                      <th class="text-uppercase text-dark text-xs font-weight-bolder">
                      <input type="checkbox" id="check-all" class="me-4">SKU</th>
                      <th class="text-uppercase text-dark text-xs font-weight-bolder">Nama Produk</th>
                      <th class="text-uppercase text-dark text-xs font-weight-bolder ps-2">Kategori</th>
                      <th class="text-uppercase text-dark text-xs font-weight-bolder ps-2">Brand</th>
                      <th class="text-uppercase text-dark text-xs font-weight-bolder ps-2">Harga</th>
                      <th class="text-uppercase text-dark text-xs font-weight-bolder ps-2">Unit</th>
                      <th class="text-uppercase text-dark text-xs font-weight-bolder ps-2">Qty</th>
                      <th class="text-uppercase text-dark text-xs font-weight-bolder">Pembuat</th>
                      <th class="text-dark"></th>
                    </tr>
                  </thead>
                  <tbody id="isiTable">
                    @foreach ($produk as $produks)
                    <tr>
                        <td>
                            <div class="d-flex ms-2 px-2 py-1 align-items-center">
                                <input name="checkboxSKU" type="checkbox" class="check-item me-4 dark mb-0">
                                <p title="SKU" class="text-xs text-dark fw-bold mb-0 text-sm">{{ $produks->sku }}</p>
                            </div>
                      </td>
                      <td>
                        <div title="gambar & nama produk" class="d-flex px-2 py-1">
                          <div>
                            <img src="{{ $produks->user->img_user }}" class="avatar avatar-sm me-3" alt="produk1">
                          </div>
                          <div class="d-flex flex-column justify-content-center">
                            <h6 class="mb-0 text-sm">{{ $produks->nama_produk }}</h6>
                          </div>
                        </div>
                      </td>
                      <td>
                        <p title="kategori" class="text-xs text-dark fw-bold mb-0 ">{{ $produks->kategori_produk->nama }}</p>
                      </td>
                      <td>
                        <p title="brand" class="text-xs text-dark fw-bold mb-0 ">{{ $produks->brand->nama }}</p>
                      </td>
                      <td>
                        <p title="harga" class="text-xs text-dark fw-bold mb-0">{{ $produks->harga_formatted }}</p>
                      </td>
                      <td>
                        <p title="unit" class="text-xs text-dark fw-bold mb-0">{{ $produks->unit->nama }}</p>
                      </td>
                      <td>
                        <span title="qty" class="text-dark text-xs fw-bold ">{{ $produks->qty }}</span>
                      </td>
                      <td>
                        <div title="gambar & nama produk" class="d-flex px-2 py-1">
                          <div>
                            <img src="{{ $produks->user->img_user }}" class="avatar avatar-sm me-3" alt="produk1">
                          </div>
                          <div class="d-flex flex-column justify-content-center">
                            <h6 class="mb-0 text-sm">{{ $produks->user->nama }}</h6>
                          </div>
                        </div>
                      </td>
                      <td class="align-middle pe-3">
                        <a href="/produk/{{ $produks->slug }}" class="text-dark fw-bold pe-3 text-xs" data-toggle="tooltip" data-original-title="Detail produk">
                            <i class="fa fa-eye text-dark text-sm opacity-10"></i>
                        </a>
                        <a href="#" class="text-dark fw-bold pe-3 text-xs" data-toggle="tooltip" data-original-title="Edit produk">
                            <i class="fa fa-pen-to-square text-dark text-sm opacity-10"></i>
                        </a>
                        <a href="#" class="text-dark fw-bold text-xs" data-toggle="tooltip" data-original-title="Delete produk">
                            <i class="fa fa-trash text-dark text-sm opacity-10"></i>
                        </a>
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
                <div class="my-3 ms-3">{{ $produk ->onEachSide(1)->links() }}</div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <x-footer></x-footer>
    </div>
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
    // 1. Ambil semua elemen yang dibutuhkan
    const checkAll = document.getElementById('check-all');
    const checkItems = document.querySelectorAll('.check-item');

    // 2. Fungsi saat "Check All" di-klik
    checkAll.addEventListener('change', function () {
        // Ulangi semua checkbox item
        checkItems.forEach(item => {
            // Set status centang item sama dengan status "Check All"
            item.checked = this.checked;

            // Tambah atau hapus class 'row-checked' pada baris (tr)
            const row = item.closest('tr');
            if (this.checked) {
                row.classList.add('row-checked');
            } else {
                row.classList.remove('row-checked');
            }
        });
    });

    // 3. Fungsi saat salah satu item di-klik
    checkItems.forEach(item => {
        item.addEventListener('change', function () {
            const row = this.closest('tr');

            // Tambah atau hapus class 'row-checked' berdasarkan status centang
            if (this.checked) {
                row.classList.add('row-checked');
            } else {
                row.classList.remove('row-checked');
            }

            // Cek apakah semua item sudah dicentang
            // Jika ya, maka centang juga "Check All"
            const allChecked = Array.from(checkItems).every(i => i.checked);
            checkAll.checked = allChecked;
        });
    });

    });
</script>
{{-- untuk pencarian nama --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
    // Ambil elemen-elemen yang dibutuhkan
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
            const posisiCell = row.getElementsByTagName('td')[3];
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
            const namaCell = row.getElementsByTagName('td')[2];
            // Kolom ketiga (indeks 2) adalah Posisi
            const posisiCell = row.getElementsByTagName('td')[3];

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
{{-- untuk perhalus scrollbar di user windows --}}
<script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
</script>
@endpush
</x-layout>

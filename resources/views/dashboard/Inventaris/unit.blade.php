<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="container-fluid d-flex flex-column min-vh-100 p-3 mb-auto ">
        <div class="row ">
            <div class="col-12 ">
                <div class="card mb-4 ">
                    @if (session()->has('success'))
                         <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <span class="alert-icon"><i class="ni ni-like-2"></i></span>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    <div class="card-header pb-0 p-3 mb-3">
                        <div class="d-flex flex-sm-row justify-content-sm-center align-items-sm-center">
                            <div class="mb-0">
                                <h5 class="mb-0">Data Unit</h5>
                                    <p class="text-sm mb-0">
                                    Kelola Data Unit Produkmu
                                </p>
                            </div>
                            <div class="ms-auto my-auto mt-lg-0">
                                <div class="ms-auto mb-0">
                                    {{-- button export pdf/excel --}}
                                    {{-- <a href="#Export-Pdf" type="button" class="btn btn-outline-primary me-2 p-2 mb-0" title="Export PDF" >
                                    <img src="assets/img/pdf.png" alt="Download PDF" width="20" height="20"></a>
                                    <a href="#Export-Excel" class="btn btn-outline-primary p-2 me-2 export mb-0 " data-type="csv" type="button" title="Export Excel">
                                    <img src="assets/img/xls.png" alt="Download PDF" width="20" height="20"></a> --}}

                                    {{-- triger-modal --}}
                                    <button class="btn bg-gradient-primary mb-0" data-bs-toggle="modal" data-bs-target="#import"><i class="fa fa-plus fixed-plugin-button-nav cursor-pointer pe-2"></i>Buat Unit</button>

                                        {{-- start-modal-add-user--}}
                                    <div class="modal fade my-4" id="import" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog mt-lg-10">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="ModalLabel">Buat Unit Baru</h5>
                                                    <button type="button" class="btn btn-close bg-danger rounded-3 me-1" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="/unit" method="post" >
                                                        @csrf
                                                        <div class="row">
                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label for="nama" class="form-label ">Nama</label>
                                                                    <input type="string" class="form-control @error('nama') is-invalid @enderror" id="nama" value="{{ old('nama') }}" required>
                                                                    @error('nama')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="slug" class="form-label">Slug</label>
                                                                    <input type="string" class="form-control @error('slug') is-invalid @enderror" id="slug" value="{{ old('slug') }}" required>
                                                                    @error('slug')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="Deskripsi" class="form-label">Deskripsi</label>
                                                                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                                                                </div>
                                                                <div class="justify-content-end mt-4 form-check form-switch form-check-reverse">
                                                                    <label class="me-auto form-check-label" for="status_toggle">Status</label>
                                                                    <input type="hidden" name="status" value="tidak">
                                                                    <input class="form-check-input" type="checkbox" role="switch" id="status_toggle" name="status" value="aktif" checked >
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-outline-success btn-sm">Buat Unit</button>
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
                            <th class="text-uppercase text-dark text-xs font-weight-bolder">Nama</th>
                            <th class="text-uppercase text-dark text-xs font-weight-bolder ps-2">Slug</th>
                            <th class="text-uppercase text-dark text-xs font-weight-bolder ps-2">Jumlah Produk</th>
                            <th class="text-uppercase text-dark text-xs font-weight-bolder ps-2">Dibuat Tanggal</th>
                            <th class="text-center text-uppercase text-dark text-xs font-weight-bolder">status</th>
                            <th class="text-dark"></th>
                            </tr>
                        </thead>
                        <tbody id="isiTable">
                            @foreach ($units as $unit)
                            <tr>
                            <td>
                                <div class="d-flex ms-2 px-2 py-1 align-items-center">
                                    <p class="mb-0 text-xs text-dark fw-bold">{{ $unit->nama }}</p>
                                </div>
                            </td>
                            <td>
                                <p class="text-xs text-dark fw-bold mb-0">{{ $unit->slug }}</p>
                            </td>
                            <td>
                                <p class="text-xs text-dark fw-bold mb-0">{{ $unit->produks_count }}</p>
                            </td>
                            <td>
                                <p class="text-xs text-dark fw-bold mb-0">{{ $unit->created_at->translatedFormat('d M Y') }}</p>
                            </td>

                            <td class="align-middle text-center text-sm">
                                <span class="badge {{ strtolower($unit['status']) == 'aktif' ? 'badge-success' : 'badge-secondary' }}">{{ $unit->status }} </span>
                            </td>

                            <td class="align-middle">
                                <a href="/#" class="text-dark fw-bold pe-3 text-xs" data-toggle="tooltip"
                                    data-original-title="Detail user">
                                    <i class="fa fa-eye text-dark text-sm opacity-10"></i>
                                </a>
                                <a href="/#" class="text-dark fw-bold pe-3 text-xs" data-toggle="tooltip" data-original-title="Edit user">
                                    <i class="fa fa-pen-to-square text-dark text-sm opacity-10"></i>
                                </a>
                                <a href="/#" class="text-dark fw-bold text-xs" data-toggle="tooltip" data-original-title="Delete user">
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
                const posisiCell = row.getElementsByTagName('td')[4];
                if (posisiCell) {
                    // Mengambil teks dari dalam <p>
                    const posisiText = posisiCell.querySelector('span').textContent.trim();
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
                const posisiCell = row.getElementsByTagName('td')[4];

                if (namaCell && posisiCell) {
                    // **PERUBAHAN PENTING**: Mengambil teks dari dalam tag <h6>
                    const namaElement = namaCell.querySelector('h6');
                    const posisiElement = posisiCell.querySelector('span');

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

    <style>
        #ofBar {
            background: #fff;
            z-index: 999999999;
            font-size: 16px;
            color: #333;
            padding: 16px 24px;
            font-weight: 400;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: fixed;
            top: 40px;
            width: 80%;
            border-radius: 8px;
            left: 0;
            right: 0;
            margin-left: auto;
            margin-right: auto;
            box-shadow: 0 13px 27px -5px rgba(41,37,36,0.25), 0 8px 16px -8px rgba(41,37,36,0.3), 0 -6px 16px -6px rgba(41,37,36,0.025);
        }

        #ofBar-logo img {
            height: 40px;
        }

        #ofBar-content {
            display: inline;
            padding: 0 15px;
        }

        #ofBar-right {
            display: flex;
            align-items: center;
        }

        #ofBar b {
            font-size: 15px !important;
        }
        #count-down {
            display: initial;
            padding-left: 10px;
            font-weight: bold;
            font-size: 20px;
        }
        #close-bar {
            font-size: 17px;
            opacity: 0.5;
            cursor: pointer;
            color: #808080;
            font-weight: bold;
        }
        #close-bar:hover{
            opacity: 1;
        }
        #btn-bar, .btn-cta-style {
            background: #292524;
            color: #fff;
            border-radius: 4px;
            padding: 10px 20px;
            font-weight: bold;
            text-align: center;
            font-size: 12px;
            opacity: .95;
            margin-right: 20px;
            box-shadow: 0 5px 10px -3px rgba(0,0,0,.23), 0 6px 10px -5px rgba(0,0,0,.25);
        }
        #btn-bar,
        #btn-bar:hover,
        #btn-bar:focus,
        #btn-bar:active,
        .btn-cta-style,
        .btn-cta-style:hover,
        .btn-cta-style:focus,
        .btn-cta-style:active {
            text-decoration: none !important;
            color: #fff !important;
        }
        #btn-bar:hover,
        .btn-cta-style:hover {
            opacity: 1;
        }

        #btn-bar span,
        .btn-cta-style span,
        #ofBar-content span {
            color: red;
            font-weight: 700;
        }
        .btn-cta-style {
            display:inline-block;

        }

        .close-ai-card {
            cursor: pointer;
            font-weight: bold;
            font-size: 20px;
            position: absolute;
            right: 16px;
            top: 16px;
            background: #fff;
            color: #292524;
            width: 32px;
            height: 32px;
            border-radius: 32px;
            opacity: 0.8;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .close-ai-card:hover {
            opacity: 1;
        }

        #oldPriceBar {
            text-decoration: line-through;
            font-size: 16px;
            color: #fff;
            font-weight: 400;
            top: 2px;
            position: relative;
        }
        #newPrice{
            color: #fff;
            font-size: 19px;
            font-weight: 700;
            top: 2px;
            position: relative;
            margin-left: 7px;
        }

        #fromText {
            font-size: 15px;
            color: #fff;
            font-weight: 400;
            margin-right: 3px;
            top: 0px;
            position: relative;
        }

        #pls-contact-me-on-email {
            position: absolute;
            color: white;
            width: 100%;
            height: 100%;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0,0,0,0.9);
            z-index: 999;
            cursor: pointer;
            padding-top: 100px;
            padding-left: 50px;
        }

        @media(max-width: 991px){

        }
        @media (max-width: 768px) {
            #count-down {
            display: block;
            margin-top: 15px;
            }

            #ofBar {
            flex-direction: column;
            align-items: normal;
            }

            #ofBar-content {
            margin: 15px 0;
            text-align: center;
            font-size: 18px;
            }

            #ofBar-right {
            justify-content: flex-end;
            }
        }
    </style>
</x-layout>


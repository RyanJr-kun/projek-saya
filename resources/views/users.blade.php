@extends('layouts.main')

@section('container')

<div class="container-fluid d-flex flex-column min-vh-100 p-3 mb-auto ">
      <div class="row ">
        <div class="col-12 ">
          <div class="card mb-4 ">
            <div class="card-hrader pb-0 p-3 mb-3">
                <div class="d-lg-flex">
                    <div>
                        <h5 class="mb-0">Data Pengguna</h5>
                            <p class="text-sm mb-0">
                            Kelola data penggunamu
                        </p>
                    </div>
            <div class="ms-auto my-auto mt-lg-0 mt-4">
                <div class="ms-auto my-auto">
                    {{-- button export pdf/excel --}}
                <a href="#Export-Pdf" type="button" class="btn btn-outline-primary me-2 p-2 mb-0" title="Export PDF" >
                    <img src="assets/img/pdf.png" alt="Download PDF" width="20" height="20"></a>
                        <a href="#Export-Excel" class="btn btn-outline-primary p-2 me-2 export mb-0 " data-type="csv" type="button" title="Export Excel">
                            <img src="assets/img/xls.png" alt="Download PDF" width="20" height="20"></a>

                    {{-- triger-modal --}}
                        <button class="btn bg-gradient-primary mb-0" data-bs-toggle="modal" data-bs-target="#import"><i class="fa fa-plus fixed-plugin-button-nav cursor-pointer pe-2"></i>Add User</button>

                        {{-- start-modal-add-user--}}
            <div class="modal fade" id="import" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog mt-lg-10">
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
                          <label>Password <span class="text-danger">*</span></label>
                          <input class="multisteps-form__input form-control" type="password" placeholder="******" onfocus="focused(this)" onfocusout="defocused(this)">
                        </div>
                        <div class="col-12 col-sm-6">
                          <label>Repeat Password <span class="text-danger">*</span></label>
                          <input class="multisteps-form__input form-control" type="password" placeholder="******" onfocus="focused(this)" onfocusout="defocused(this)">
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
                <div class="filter-container">
                    <div class="row g-3 align-items-center">
                        <!-- Filter Pencarian Nama -->
                        <div class="col-md-6 mx-3 w-20">
                            <input type="text" id="searchInput" class="form-control" placeholder="Ketik nama user untuk mencari...">
                        </div>
                        <!-- Filter Dropdown Posisi -->
                        <div class="col-md-6 ms-md-auto pe-md-3 mx-3 w-10">
                            <select id="posisiFilter" class="form-select">
                                <option value="">Semua Posisi</option>
                            </select>
                        </div>
                    </div>
                </div>
              <div class="table-responsive p-0">
                <table class="table align-items-center mb-0" id="tableData">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-dark text-xs font-weight-bolder">Nama</th>
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
                        <div class="d-flex px-2 py-1">
                          <div>
                            <img src="{{ $user["img"] }}" class="avatar avatar-sm me-3" alt="user1">
                          </div>
                          <div class="d-flex flex-column justify-content-center">
                            <h6 class="mb-0 text-sm">{{ $user["nama"] }}</h6>
                          </div>
                        </div>
                      </td>
                      <td>
                        <p class="text-xs text-dark fw-bold mb-0">{{ $user["kontak"] }}</p>
                        <p class="text-xs text-dark mb-0">{{ $user["email"] }}</p>
                      </td>
                      <td>
                        <p class="text-xs text-dark fw-bold mb-0">{{ $user["posisi"] }}</p>
                      </td>
                      <td class="align-middle text-center">
                        <span class="text-dark text-xs fw-bold">{{ $user["mulai_kerja"] }}</span>
                      </td>
                      <td class="align-middle text-center text-sm">
                        <span class="badge badge-sm rounded-1 {{ strtolower($user['status']) == 'aktif' ? 'bg-success' : 'bg-danger' }}">{{ $user["status"] }} </span>
                      </td>
                      <td class="align-middle">
                        <a href="#" class="text-dark fw-bold pe-3 text-xs" data-toggle="tooltip" data-original-title="Detail user">
                            <i class="fa fa-eye text-dark text-sm opacity-10"></i>
                        </a>
                        <a href="#" class="text-dark fw-bold pe-3 text-xs" data-toggle="tooltip" data-original-title="Edit user">
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
@endsection
@section('corejs')
<script>

        // Get the necessary elements from the DOM (Document Object Model)
        const uploadInput = document.getElementById('uploadImageInput');
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
@endsection

<x-layout>
    @push('styles')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    @endpush
    
    @section('breadcrumb')
        @php
            $breadcrumbItems = [
                ['name' => 'Page', 'url' => '#'],
                ['name' => 'Daftar Invoice Pembelian', 'url' => route('pembelian.index')],
            ];
        @endphp
        <x-breadcrumb :items="$breadcrumbItems" />
    @endsection

    <form action="{{ route('pembelian.store') }}" method="post" id="form-pembelian">
        @csrf
        <div class="container-fluid p-3">
            <div class="card ">
                <div class="card-header pt-3 pb-0 mb-0 ">
                    <h6 class="">Informasi Pembelian</h6>
                </div>
                <div class="card-body px-4 pt-0">
                    <div class="row g-2">
                        <div class="col-md-3">
                            <label for="Pemasok" class="form-label">Pemasok <span class="text-danger">*</span></label>
                            <div class="d-flex">
                                <select class="form-select me-2 @error('pemasok_id') is-invalid @enderror" name="pemasok_id" id="Pemasok" required>
                                    <option value="" disabled selected>Pilih Pemasok</option>
                                    @foreach ($pemasok as $item)
                                        <option value="{{ $item->id }}" @selected(old('pemasok_id') == $item->id)>{{ $item->nama }}</option>
                                        @endforeach
                                </select>
                                @error('pemasok')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                                <button type="button" class="btn btn-outline-info btn-xs mb-0" data-bs-toggle="modal" data-bs-target="#createPemasokModal" title="Tambah Pemasok Baru">
                                    <i class="bi bi-plus-lg cursor-pointer"></i>
                                </button>
                            </div>
                        </div>
                        <div class="col-md-3 ">
                            <label for="tanggal" class="form-label">Tanggal</label>
                            <input id="tanggal" name="tanggal" type="date" class="form-control @error('tanggal') is-invalid @enderror" value="{{ old('tanggal', date('Y-m-d')) }}" required>
                            @error('tanggal')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-3 ms-auto">
                            <label for="referensi" class="form-label">No Invoice <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('referensi') is-invalid @enderror" id="referensi" name="referensi" value="{{ old('referensi', $nomer_referensi) }}" required>
                            @error('referensi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-12">
                            <div class="row g-md-3 g-3">
                                <div class="col-md-9 col-12">
                                    <label for="select2" class="form-label">Cari Produk:</label>
                                    <select name="select2" id="select2" class="form-control"></select>
                                </div>
                                <div class="col-md-1 col-4">
                                    <label for="sisa_stok" class="form-label">Stok:</label>
                                    <input type="number" id="sisa_stok" class="form-control" readonly>
                                </div>
                                <div class="col-md-1 col-4">
                                    <label for="qty" class="form-label">Qty:</label>
                                    <input type="number" id="qty" class="form-control" min="1">
                                </div>
                                <div class="col-md-1 col-4" style="padding-top: 30px">
                                    <button type="button" class="btn btn-outline-info"  id="btn-add">Tambah</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mb-3 table-responsive p-2">
                            <table class="table table-hover align-items-center" id="table-pembelian">
                                <thead class="table-secondary">
                                    <tr class="table-secondary">
                                        <th class="text-dark text-xs font-weight-bolder">Nama Produk</th>
                                        <th class="text-dark text-xs font-weight-bolder text-center">Qty</th>
                                        <th class="text-dark text-xs font-weight-bolder ps-2">Harga Beli</th>
                                        <th class="text-dark text-xs font-weight-bolder ps-2">Diskon (Rp)</th>
                                        <th class="text-dark text-xs font-weight-bolder ps-2">Subtotal</th>
                                        <th class="text-dark"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                        <div class="d-md-flex justify-items-between w-100">
                            <div class="row w-100">
                                <div class="col-md-3 form-group">
                                    <label for="ongkir" class="form-control-label fw-bolder">Ongkos Kirim</label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp.</span>
                                        <input type="number" name="ongkir" id="ongkir" class="form-control form-control-sm text-end" value="0" min="0">
                                    </div>
                                </div>
                                <div class="col-md-3 form-group">
                                    <label for="diskon-tambahan" class="form-control-label fw-bolder">Diskon Tambahan</label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp.</span>
                                        <input type="number" name="diskon_tambahan" id="diskon-tambahan" class="form-control form-control-sm text-end" value="0" min="0">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label for="statusBarang" class="form-label">Status Barang:</label>
                                    <select class="form-select me-2 @error('status_barang') is-invalid @enderror" name="status_barang" id="statusBarang" required>
                                        <option value="" disabled selected>Pilih</option>
                                        <option value="Diterima" @selected(old('status_barang') == 'Diterima')>Diterima</option>
                                        <option value="Belum Diterima" @selected(old('status_barang') == 'Belum Diterima')>Belum Diterima</option>
                                    </select>
                                </div>
                                <div class="col-md-3 mb-md-0 mb-3">
                                    <label for="statusBayar" class="form-label">Status Pembayaran:</label>
                                    <select class="form-select me-2 @error('status_pembayaran') is-invalid @enderror" name="status_pembayaran" id="statusBayar" required>
                                        <option value="" disabled selected>Pilih</option>
                                        <option value="Lunas" @selected(old('status_pembayaran') == 'Lunas')>Lunas</option>
                                        <option value="Lunas Sebagian" @selected(old('status_pembayaran') == 'Lunas Sebagian')>Lunas Sebagian</option>
                                        <option value="Belum Lunas" @selected(old('status_pembayaran') == 'Belum Lunas')>Belum Lunas</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row w-100 g-3 align-items-center justify-content-end">
                                <div class="col-md-5">
                                    <div class="row mb-2">
                                        <div class="col-7 text-end"><span class="fw-bolder text-sm">Subtotal Keseluruhan</span></div>
                                        <div class="col-5 text-start"><span id="subtotal-keseluruhan" class="fw-bold text-sm">Rp 0</span></div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-7 text-end"><span class="fw-bolder text-sm text-dark">TOTAL AKHIR</span></div>
                                        <div class="col-5 text-start"><span id="total-akhir" class="fw-bolder text-sm">Rp 0</span></div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-7 text-end"><span class="fw-bolder text-sm text-dark">Bayar</span></div>
                                        <div class="col-5 text-start">
                                            <input type="text" id="bayar" class="text-dark text-end form-control form-control-sm text-sm">
                                            <input type="hidden" name="jumlah_dibayar" id="jumlah_dibayar_hidden" value="0">
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-7 text-end"><span class="fw-bolder text-sm text-dark">Sisa / Kembalian</span></div>
                                        <div class="col-5 text-start"><span id="kembalian" class="fw-bolder text-sm text-dark">Rp 0</span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="catatan" class="form-label">Catatan</label>
                                <div id="quill-editor-catatan" style="min-height: 100px;">{!! old('catatan') !!}</div>
                                <input type="hidden" name="catatan" id="catatan" value="{{ old('catatan') }}">
                                @error('catatan') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end mt-2">
                        <button id="saveBtn" type="submit" class="btn btn-outline-info">Buat Transaksi</button>
                        <a href="{{ route('pembelian.index') }}" id="cancel-button" class="btn btn-danger ms-3">Batalkan</a>
                    </div>
                </div>
            </div>
        </div>
    </form>

    {{-- Modal Create Pemasok --}}
    <div class="modal fade" id="createPemasokModal" tabindex="-1" aria-labelledby="createPemasokModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0 mb-n3">
                    <h6 class="modal-title" id="createPemasokModalLabel">Tambah Pemasok Baru</h6>
                    <button type="button" class="btn btn-close bg-danger rounded-3 me-1" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="createPemasokForm" action="{{ route('pemasok.store') }}" method="post">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="nama" class="form-label">Nama</label>
                                <input id="nama" name="nama" type="text" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama') }}" required>
                                @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="perusahaan" class="form-label">Perusahaan</label>
                                <input id="perusahaan" name="perusahaan" type="text" class="form-control @error('perusahaan') is-invalid @enderror" value="{{ old('perusahaan') }}" required>
                                @error('perusahaan')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="kontak" class="form-label">Kontak</label>
                                <input id="kontak" name="kontak" type="text" class="form-control @error('kontak') is-invalid @enderror" value="{{ old('kontak') }}" required>
                                @error('kontak')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="example@gmail.com" value="{{ old('email') }}">
                                @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                <label for="alamat" class="form-label">Alamat</label>
                                <textarea id="alamat" name="alamat" class="form-control @error('alamat') is-invalid @enderror" rows="2">{{ old('alamat') }}</textarea>
                                @error('alamat')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                <label for="note" class="form-label">Catatan (Opsional)</label>
                                <textarea id="note" name="note" class="form-control @error('note') is-invalid @enderror" rows="2">{{ old('note') }}</textarea>
                                @error('note')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="justify-content-end form-check form-switch form-check-reverse my-2">
                            <label class="me-auto fw-bold form-check-label" for="status">Status</label>
                            <input id="status" class="form-check-input" type="checkbox" name="status" value="1" checked>
                        </div>
                        <div class="modal-footer border-0 pb-0">
                            <button type="submit" class="btn btn-info btn-sm">Buat Pemasok</button>
                            <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">Batalkan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
                // --- UTILITIES ---
                // Hapus atribut onfocus yang mungkin menyebabkan error dari skrip lain
                $("#qty").removeAttr("onfocus");

                const formatCurrency = (number) => new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(number);
                let itemCounter = 0;

                // --- SELECT2 INITIALIZATION ---
                function formatProduk(produk) {
                    if (!produk.id) {
                        return produk.text;
                    }

                    var defaultImage = "{{ asset('assets/img/produk.webp') }}";
                    var imageUrl = produk.img_produk ? `{{ asset('storage/') }}/${produk.img_produk}` : defaultImage;

                    var $produk = $(
                        `<div class="d-flex align-items-center">
                            <img src="${imageUrl}" class="avatar avatar-sm me-3" />
                            <div>
                                <h6 class="mb-0 text-sm">${produk.text}</h6>
                                <p class="text-xs text-muted mb-0">Stok: ${produk.qty}</p>
                            </div>
                        </div>`
                    );

                    return $produk;
                }

                $('#select2').select2({
                    theme: "bootstrap-5",
                    placeholder: 'Ketik untuk mencari produk...',
                    minimumInputLength: 0, // Izinkan dropdown terbuka tanpa input
                    templateResult: formatProduk,
                    templateSelection: function (produk) {
                        // Mengisi stok saat produk dipilih
                        if (produk.id) {
                            $("#sisa_stok").val(produk.qty);
                            $("#qty").val(1).focus(); // Auto-fill qty to 1 and focus
                        }
                        return produk.text;
                    },
                    ajax: {
                        url: "{{ route('get-data.produk') }}",
                        dataType: 'json',
                        delay: 250,
                        data: function(params) {
                            return {
                                search: params.term, // Kirim parameter 'search' ke controller
                                page: params.page || 1
                            };
                        },
                        processResults: function(data) {
                            // Transformasi data dari controller agar sesuai format Select2 ({id: '', text: ''})
                            return {
                                results: data.map(function(item) {
                                    return {
                                        id: item.id,
                                        text: item.nama_produk,
                                        img_produk: item.img_produk,
                                        qty: item.qty,
                                        harga_beli: item.harga_beli
                                    };
                                })
                            };
                        },
                        cache: true
                    }
                });

                // --- ADD ITEM TO TABLE ---
                $("#btn-add").on("click", function() {
                    const selectedData = $("#select2").select2('data')[0];
                    const qty = $("#qty").val();

                    if (!selectedData || !selectedData.id || !qty || parseInt(qty) <= 0) {
                        alert('Harap pilih produk dan tentukan jumlah yang valid.');
                        return;
                    }

                    const produkId = selectedData.id;
                    const produkNama = selectedData.text;
                    const produkImg = selectedData.img_produk;
                    const hargaBeli = selectedData.harga_beli || 0;
                    const qtyToAdd = parseInt(qty);

                    // Cek jika produk sudah ada di tabel
                    let existingRow = $(`#table-pembelian tbody tr[data-produk-id="${produkId}"]`);
                    if (existingRow.length > 0) {
                        let currentQtyInput = existingRow.find(".qty-pembelian");
                        let newQty = parseInt(currentQtyInput.val()) + qtyToAdd;
                        currentQtyInput.val(newQty).trigger('input'); // Update qty dan trigger kalkulasi
                    } else {
                        // Tambah baris baru
                        const defaultImage = "{{ asset('assets/img/produk.webp') }}";
                        const imageUrl = produkImg ? `{{ asset('storage/') }}/${produkImg}` : defaultImage;

                        const newRow = `
                            <tr data-produk-id="${produkId}">
                                <input type="hidden" name="items[${itemCounter}][produk_id]" value="${produkId}">
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="${imageUrl}" class="avatar avatar-sm me-3" alt="${produkNama}">
                                        <h6 class="mb-0 text-sm">${produkNama}</h6>
                                    </div>
                                </td>
                                <td class="align-middle">
                                    <div class="d-flex justify-content-center">
                                        <input type="number" name="items[${itemCounter}][qty]" class="form-control form-control-sm qty-pembelian w-md-30 w-100 text-center" value="${qtyToAdd}" min="1">
                                    </div>
                                </td>
                                <td>
                                    <input type="number" name="items[${itemCounter}][harga_beli]" class="form-control form-control-sm harga-beli w-md-60 w-100" value="${hargaBeli}" min="0">
                                </td>
                                <td>
                                    <input type="number" name="items[${itemCounter}][diskon]" class="form-control form-control-sm diskon-item w-md-60 w-100" value="0" min="0">
                                </td>
                                <td class="subtotal-item text-start text-sm">Rp 0</td>
                                <td>
                                    <button type="button" class="btn btn-link text-danger p-0 m-0 btn-remove">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        `;
                        $("#table-pembelian tbody").append(newRow);
                        itemCounter++;
                        calculateRow($(`#table-pembelian tbody tr[data-produk-id="${produkId}"]`));
                    }

                    // Reset inputs
                    $("#select2").val(null).trigger("change");
                    $("#qty").val("");
                    $("#sisa_stok").val("");
                    calculateGrandTotal();
                });

                // --- CALCULATIONS ---
                function calculateRow(row) {
                    const qty = parseFloat(row.find(".qty-pembelian").val()) || 0;
                    const hargaBeli = parseFloat(row.find(".harga-beli").val()) || 0;
                    const diskon = parseFloat(row.find(".diskon-item").val()) || 0;

                    const subtotal = (qty * hargaBeli) - diskon;

                    row.find(".subtotal-item").text(formatCurrency(subtotal));
                }

                function calculateGrandTotal() {
                    let subtotalKeseluruhan = 0;
                    $('#table-pembelian tbody tr').each(function() {
                        const qty = parseFloat($(this).find(".qty-pembelian").val()) || 0;
                        const hargaBeli = parseFloat($(this).find(".harga-beli").val()) || 0;
                        const diskon = parseFloat($(this).find(".diskon-item").val()) || 0;
                        subtotalKeseluruhan += (qty * hargaBeli) - diskon;
                    });

                    $("#subtotal-keseluruhan").text(formatCurrency(subtotalKeseluruhan));

                    const ongkir = parseFloat($("#ongkir").val()) || 0;
                    const diskonTambahan = parseFloat($("#diskon-tambahan").val()) || 0;

                    const totalAkhir = subtotalKeseluruhan - diskonTambahan + ongkir;

                    $("#total-akhir").text(formatCurrency(totalAkhir < 0 ? 0 : totalAkhir));
                    return totalAkhir < 0 ? 0 : totalAkhir;
                }

                function calculateChange() {
                    const totalAkhir = calculateGrandTotal();
                    const bayarValue = $("#bayar").val().replace(/[^0-9]/g, '');
                    const bayar = parseFloat(bayarValue) || 0;

                    // Simpan nilai bayar bersih ke hidden input untuk dikirim ke server
                    $("#jumlah_dibayar_hidden").val(bayar);

                    const sisa = bayar - totalAkhir;

                    // Tampilkan sisa/kembalian, bisa negatif
                    $("#kembalian").text(formatCurrency(sisa));

                    // Ubah warna teks jika sisa negatif (menandakan hutang)
                    if (sisa < 0) {
                        $("#kembalian").removeClass('text-dark').addClass('text-danger');
                    } else {
                        $("#kembalian").removeClass('text-danger').addClass('text-dark');
                    }
                }

                // --- EVENT LISTENERS ---
                // Recalculate row on input change
                $("#table-pembelian").on("input", ".qty-pembelian, .harga-beli, .diskon-item", function() {
                    calculateRow($(this).closest("tr"));
                    calculateChange();
                });

                // Recalculate grand total on footer input change
                $("#ongkir, #diskon-tambahan").on("input", function() {
                    calculateChange();
                });

                // Remove item from table
                $("#table-pembelian").on("click", ".btn-remove", function() {
                    $(this).closest("tr").remove();
                    calculateChange();
                });

                // Calculate change on payment input
                $("#bayar").on("input", function() {
                    calculateChange();
                });

                // Auto-fill payment when status is 'Lunas'
                $("#statusBayar").on("change", function() {
                    if ($(this).val() === 'Lunas') {
                        const totalAkhir = calculateGrandTotal();
                        // Set nilai input 'bayar' dengan angka bersih, lalu trigger 'input'
                        $("#bayar").val(totalAkhir).trigger('input');
                    } else {
                        // Kosongkan pembayaran jika status diubah ke 'Belum Lunas'
                        $("#bayar").val(0).trigger('input');
                    }
                });

                // Format input 'bayar' saat fokus hilang (blur)
                $("#bayar").on("blur", function() {
                    const value = $(this).val().replace(/[^0-9]/g, '');
                    const number = parseFloat(value) || 0;
                    // Tampilkan dengan format ribuan
                    $(this).val(new Intl.NumberFormat('id-ID').format(number));
                });

                // --- FORM SUBMISSION VALIDATION ---
                $("#form-pembelian").on("submit", function(e) {
                    const itemCount = $("#table-pembelian tbody tr").length;
                    if (itemCount === 0) {
                        e.preventDefault(); // Mencegah form untuk submit
                        // Menggunakan SweetAlert jika tersedia, atau alert biasa
                        if (typeof Swal !== 'undefined') {
                            Swal.fire('Peringatan', 'Harap tambahkan minimal satu produk ke dalam daftar pembelian.', 'warning');
                        } else {
                            alert('Harap tambahkan minimal satu produk ke dalam daftar pembelian.');
                        }
                    }
                });
            });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Inisialisasi Quill untuk catatan
            if (document.getElementById('quill-editor-catatan')) {
                const hiddenInputCatatan = document.getElementById('catatan');
                const quillCatatan = new Quill('#quill-editor-catatan', {
                    theme: 'snow',
                    placeholder: 'Tulis catatan pembelian di sini...',
                });

                quillCatatan.on('text-change', function() {
                    hiddenInputCatatan.value = quillCatatan.root.innerHTML;
                });

                // Jika ada old value, set ke editor
                if (hiddenInputCatatan.value) {
                    quillCatatan.root.innerHTML = hiddenInputCatatan.value;
                }
            }

            //create-pemasok
            const createPemasokForm = document.getElementById('createPemasokForm');
            const pemasokSelect = document.getElementById('Pemasok');
            const createPemasokModal = new bootstrap.Modal(document.getElementById('createPemasokModal'));

            createPemasokForm.addEventListener('submit', function (e) {
                e.preventDefault();

                const formData = new FormData(this);

                // Reset pesan error sebelumnya
                this.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
                this.querySelectorAll('.invalid-feedback').forEach(el => el.textContent = '');

                fetch(this.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    },
                    body: formData
                })
                .then(response => {
                    // Cek jika ada error validasi dari server
                    if (response.status === 422) {
                        return response.json().then(data => {
                            // lemparkan error agar ditangkap oleh .catch()
                            throw { errors: data.errors };
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        const newOption = new Option(data.data.nama, data.data.id, true, true);
                        pemasokSelect.appendChild(newOption);
                        pemasokSelect.dispatchEvent(new Event('change'));

                        createPemasokForm.reset();
                        createPemasokModal.hide();

                        // --- GANTI alert() DENGAN SWEETALERT ---
                        if (typeof Swal !== 'undefined') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: data.message,
                                showConfirmButton: false,
                                timer: 1500
                            });
                        } else {
                            alert(data.message);
                        }
                    }
                })
                .catch(error => {
                    if (error.errors) {
                        // Tampilkan error validasi
                        Object.keys(error.errors).forEach(key => {
                            const input = createPemasokForm.querySelector(`[name="${key}"]`);
                            if (input) {
                                input.classList.add('is-invalid');
                                // Cari elemen .invalid-feedback yang merupakan sibling dari input
                                const errorFeedback = input.nextElementSibling;
                                if (errorFeedback && errorFeedback.classList.contains('invalid-feedback')) {
                                    errorFeedback.textContent = error.errors[key][0];
                                }
                            }
                        });
                    } else {
                        console.error('Error:', error);
                        // Tampilkan notifikasi error umum dengan SweetAlert
                        if (typeof Swal !== 'undefined') {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Terjadi kesalahan. Silakan coba lagi.'
                            });
                        } else {
                            alert('Terjadi kesalahan. Silakan coba lagi.');
                        }
                    }
                });
            });
        });
    </script>
    @endpush
</x-layout>

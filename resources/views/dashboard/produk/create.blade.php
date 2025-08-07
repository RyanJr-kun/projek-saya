<x-layout>
    @push('styles')
        <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css"/>
        <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet">
    @endpush
    @section('breadcrumb')
        @php
        // Definisikan item breadcrumb dalam bentuk array
        $breadcrumbItems = [
            ['name' => 'Page', 'url' => '/dashboard'],
            ['name' => 'Manajemen Produk', 'url' => route('produk.index')],
            ['name' => 'Buat Produk Baru', 'url' => '#'],
        ];
        @endphp
        <x-breadcrumb :items="$breadcrumbItems" />
    @endsection

    {{-- Form Isian --}}
    <form action="{{ route('produk.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="card m-4">
            <div class="card-header pt-3 pb-0 mb-0 ">
                <h6 class="">Informasi Produk</h6>
            </div>
            <div class="card-body px-4 pt-0">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nama_produk" class="form-label">Nama Produk <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nama_produk') is-invalid @enderror" id="nama_produk" name="nama_produk" value="{{ old('nama_produk') }}" required>
                            @error('nama_produk')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="barcode" class="form-label">Item Barcode <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('barcode') is-invalid @enderror" id="barcode" name="barcode" value="{{ old('barcode') }}" required>
                            @error('barcode')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="slug" class="form-label">Slug <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug" name="slug" value="{{ old('slug') }}" required>
                            @error('slug')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="sku" class="form-label">SKU <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('sku') is-invalid @enderror" id="sku" name="sku" value="{{ old('sku') }}" required>
                            @error('sku')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="kategori" class="form-label">Kategori <span class="text-danger">*</span></label>
                            <select class="form-select @error('kategori') is-invalid @enderror" name="kategori" id="kategori" placeholder="Departure" required>
                                <option value="" disabled selected>Pilih</option>
                                {{-- @foreach ($roles as $role)
                                    <option value="{{ $role->id }}" {{ old('kategori') == $role->id ? 'selected' : '' }}>{{ $role->nama }}</option>
                                    @endforeach --}}
                            </select>
                            @error('kategori')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="brand" class="form-label">Brand <span class="text-danger">*</span></label>
                            <select class="form-select @error('brand') is-invalid @enderror" id="brand" name="brand" required>
                                <option value="" disabled selected>Pilih</option>
                                {{-- @foreach ($roles as $role)
                                <option value="{{ $role->id }}" {{ old('brand') == $role->id ? 'selected' : '' }}>{{ $role->nama }}</option>
                                @endforeach --}}
                            </select>
                            @error('brand')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="unit" class="form-label">Unit <span class="text-danger">*</span></label>
                            <select class="form-select @error('unit') is-invalid @enderror" id="unit" name="unit" required>
                                <option value="" disabled selected>Pilih</option>
                                {{-- @foreach ($roles as $role)
                                    <option value="{{ $role->id }}" {{ old('unit') == $role->id ? 'selected' : '' }}>{{ $role->nama } </option>
                                @endforeach --}}
                            </select>
                            @error('unit')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-12 mb-3">
                            <div class="form-group">
                                <label for="deskripsi" class="form-label">Deskripsi <span class="text-danger">*</span></label>
                                <div id="quill-editor" style="min-height: 100px;">{!! old('deskripsi') !!}</div>
                                <input type="hidden" name="deskripsi" id="deskripsi" value="{{ old('deskripsi') }}">
                                @error('deskripsi')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                </div>
            </div>
        </div>
        <div class="card m-4">
            <div class="card-header pt-3 pb-0 mb-0 ">
                <h6 class="">Stok & Harga</h6>
            </div>
            <div class="card-body px-4 pt-0">
                <div class="form-check mb-3">
                    <input class="form-check-input" type="radio" name="product_type" id="radioSingle" value="single" {{ old('product_type', 'single') == 'single' ? 'checked' : '' }}>
                    <label class="custom-control-label" for="radioSingle">Single Produk</label>
                </div>
                <div class="row">

                    <div class="col-md-4 mb-3">
                        <label for="single_stock" class="form-label">Stok <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('single_stock') is-invalid @enderror" id="single_stock" name="single_stock" value="{{ old('single_stock') }}">
                        @error('single_stock')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="single_price" class="form-label">Harga <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('single_price') is-invalid @enderror" id="single_price" name="single_price" value="{{ old('single_price') }}">
                        @error('single_price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="garansi" class="form-label">Garansi</label>
                        <select class="form-select @error('garansi') is-invalid @enderror" id="garansi" name="garansi">
                            <option value="" disabled selected>Pilih</option>
                        </select>
                        @error('garansi')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="stock_alert" class="form-label">Batas Stok Minimum <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('stock_alert') is-invalid @enderror" id="stock_alert" name="stock_alert" value="{{ old('stock_alert') }}">
                        @error('stock_alert')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                </div>
            </div>
        </div>
        <div class="card m-4">
            <div class="card-header pt-3 pb-0 mb-0 ">
                <h6 class="">Gambar Produk</h6>
            </div>
            <div class="card-body px-4 pt-0">
                <div class="dropzone custom-dropzone" id="image-upload-dropzone">

                    <div class="dz-message">
                        <div class="icon">
                            <i class="bi bi-cloud-upload-fill"></i>
                        </div>
                        <h5 class="message-text">Seret & Lepas file di sini</h5>
                        <span class="message-hint">atau klik untuk memilih file</span>
                    </div>
                </div>

                <input type="hidden" name="img_produk" id="image_path">

                @error('img_produk')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>
        </div>
        {{-- Tombol Aksi --}}
        <div class="d-flex justify-content-end mt-3 me-4">
            <button type="submit" class="btn btn-info">Buat Produk</button>
            <a href="{{ route('produk.index') }}" class="btn btn-danger ms-3">Batalkan</a>
        </div>
    </form>

    @push('scripts')
    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // quill
            const quill = new Quill('#quill-editor', {
                theme: 'snow',
                placeholder: 'Tulis deskripsi produk di sini...',
            });
            const hiddenInput = document.getElementById('deskripsi');
            quill.on('text-change', function() {
                hiddenInput.value = quill.root.innerHTML;
            });
            if (hiddenInput.value) {
                quill.root.innerHTML = hiddenInput.value;
            }

            // slug
            const nama_produk = document.querySelector('#nama_produk ')
            const slug = document.querySelector('#slug')

            nama_produk.addEventListener('change', function(){
                fetch('/dashboard/produk/chekSlug?nama_produk=' + nama_produk.value)
                    .then(response => response.json())
                    .then(data => slug.value = data.slug)
            });

            // dropzone
            Dropzone.autoDiscover = false;

            // Ambil token CSRF dari form
            const csrfToken = document.querySelector('input[name="_token"]').value;
            const imagePathInput = document.querySelector('#image_path');

            let myDropzone = new Dropzone("div#image-upload-dropzone", {
                url: "{{ route('produk.upload.gambar') }}", // Route untuk handle upload sementara
                paramName: "image",
                maxFiles: 1, // Hanya izinkan 1 file gambar produk
                maxFilesize: 5, // MB
                acceptedFiles: ".jpeg,.jpg,.png",
                addRemoveLinks: true,
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                dictRemoveFile: "Hapus",

                init: function() {
                    this.on("addedfile", file => {
                        // Hanya izinkan satu file, hapus yang lama jika ada yang baru
                        if (this.files.length > 1) {
                            this.removeFile(this.files[0]);
                        }
                    });

                    this.on("success", (file, response) => {
                        // Simpan path file dari server ke dalam hidden input
                        imagePathInput.value = response.path;
                    });

                    this.on("removedfile", file => {
                        // Hapus path file dari hidden input
                        imagePathInput.value = "";
                    });
                }
            });
        });
    </script>
    @endpush
</x-layout>

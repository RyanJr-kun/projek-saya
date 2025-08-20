<x-layout>
    @push('styles')
        <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet">
        <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">
        <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet">
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
    <form id="addform" method="post" action="{{ route('produk.store') }} " enctype="multipart/form-data">
        @csrf
        <div class="card m-4">
            <div class="card-header pt-3 pb-0 mb-0 ">
                <h6 class="">Informasi Produk</h6>
            </div>
            <div class="card-body px-4 pt-0">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="nama_produk" class="form-label">Nama Produk <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nama_produk') is-invalid @enderror" id="nama_produk" name="nama_produk" value="{{ old('nama_produk') }}" required autofocus>
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
                            @foreach ($kategoris as $kategori)
                                <option value="{{ $kategori->id }}" @selected(old('kategori') == $kategori->id)>{{ $kategori->nama }}</option>
                                @endforeach
                        </select>
                        @error('kategori')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="brand" class="form-label">Brand <span class="text-danger">*</span></label>
                        <select class="form-select @error('brand') is-invalid @enderror" id="brand" name="brand" required>
                            <option value="" disabled selected>Pilih</option>
                            @foreach ($brands as $brand)
                            <option value="{{ $brand->id }}" @selected(old('brand') == $brand->id)>{{ $brand->nama }}</option>
                            @endforeach
                        </select>
                        @error('brand')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="unit" class="form-label">Unit <span class="text-danger">*</span></label>
                        <select class="form-select @error('unit') is-invalid @enderror" id="unit" name="unit" required>
                            <option value="" disabled selected>Pilih</option>
                            @foreach ($units as $unit)
                                <option value="{{ $unit->id }}" @selected(old('unit') == $unit->id)>{{ $unit->nama }} </option>
                            @endforeach
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
                <div class="row">

                    <div class="col-md-4 mb-3">
                        <label for="qty" class="form-label">Stok <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('qty') is-invalid @enderror" id="qty" name="qty" value="{{ old('qty') }}">
                        @error('qty')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="harga" class="form-label">Harga <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('harga') is-invalid @enderror" id="harga" name="harga" value="{{ old('harga') }}">
                        @error('harga')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="garansi" class="form-label">Garansi</label>
                        <select class="form-select @error('garansi') is-invalid @enderror" id="garansi" name="garansi">
                            <option value="" disabled selected>Pilih</option>
                             @foreach ($garansis as $garansi)
                                    <option value="{{ $garansi->id }}" @selected(old('garansi') == $garansi->id)>{{ $garansi->nama }} </option>
                                @endforeach
                        </select>
                        @error('garansi')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="stok_minimum" class="form-label">Batas Stok Minimum <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('stok_minimum') is-invalid @enderror" id="stok_minimum" name="stok_minimum" value="{{ old('stok_minimum') }}">
                        @error('stok_minimum')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="card m-4 w-md-50">
            <div class="card-header pt-3 pb-0 mb-n3">
                <h6 class="">Gambar Produk</h6>
            </div>
            <div class="card-body">
                <input type="file" class="filepond" name="img_produk" id="image">
            </div>
        </div>

        <div class="d-flex justify-content-end mt-3 me-4">
            <button id="saveBtn" type="submit" class="btn btn-info">Buat Produk</button>
            <a href="{{ route('produk.index') }}" class="btn btn-danger ms-3">Batalkan</a>
        </div>
    </form>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
        <script src="https://unpkg.com/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.js"></script>
        <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
        <script src="https://unpkg.com/filepond-plugin-image-crop/dist/filepond-plugin-image-crop.js"></script>
        <script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
        <script src="https://unpkg.com/filepond-plugin-image-transform/dist/filepond-plugin-image-transform.js"></script>
        <script src="https://unpkg.com/filepond/dist/filepond.js"></script>

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
                const nama_produk = document.querySelector('#nama_produk')
                const slug = document.querySelector('#slug')

                nama_produk.addEventListener('change', function() {
                    fetch('/dashboard/produk/chekSlug?nama_produk=' + nama_produk.value)
                        .then(response => response.json())
                        .then(data => slug.value = data.slug)
                });

                // FilePond
                FilePond.registerPlugin(
                    FilePondPluginImagePreview,
                    FilePondPluginFileValidateSize,
                    FilePondPluginImageCrop,
                    FilePondPluginFileValidateType,
                    FilePondPluginImageTransform // Daftarkan plugin transform
                );

                const inputElement = document.querySelector('input[id="image"]');
                const pond = FilePond.create(inputElement, {
                    labelIdle: `Seret & Lepas gambar Anda atau <span class="filepond--label-action">Cari</span>`,
                    // Aktifkan pratinjau gambar
                    allowImagePreview: true,
                    imagePreviewHeight: 170,
                    // Aktifkan validasi ukuran file
                    allowFileSizeValidation: true,
                    maxFileSize: '2MB',
                    // Aktifkan crop gambar
                    allowImageCrop: true,
                    imageCropAspectRatio: '1:1',
                    labelMaxFileSizeExceeded: 'Ukuran file terlalu besar',
                    labelMaxFileSize: 'Ukuran file maksimum adalah 2MB',
                    // Validasi tipe file
                    acceptedFileTypes: ['image/png', 'image/jpeg', 'image/webp', 'image/svg+xml'],
                    labelFileTypeNotAllowed: 'Jenis file tidak valid. Hanya PNG, JPG, WEBP, dan SVG yang diizinkan.',
                    server: {
                        process: {
                            url: '/dashboard/produk/upload',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        },

                        // Anda bisa menambahkan endpoint 'revert' di sini untuk menghapus file sementara jika dibatalkan
                    }
                });
            });
        </script>
    @endpush
</x-layout>

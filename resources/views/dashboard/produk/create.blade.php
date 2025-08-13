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
    <form method="post" action="{{ route('produk.store') }}">
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
                                <option value="{{ $kategori->id }}" {{ old('kategori') == $kategori->id ? 'selected' : '' }}>{{ $kategori->nama }}</option>
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
                            <option value="{{ $brand->id }}" {{ old('brand') == $brand->id ? 'selected' : '' }}>{{ $brand->nama }}</option>
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
                                <option value="{{ $unit->id }}" {{ old('unit') == $unit->id ? 'selected' : '' }}>{{ $unit->nama }} </option>
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
                                    <option value="{{ $garansi->id }}" {{ old('garansi') == $garansi->id ? 'selected' : '' }}>{{ $garansi->nama }} </option>
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

        <div class="card m-4">
            <div class="card-header pt-3 pb-0 mb-0">
                <h6 class="">Gambar Produk</h6>
            </div>
            <div class="card-body px-4 pt-0">
                {{-- Area ini akan diubah oleh Uppy menjadi dashboard upload --}}
                <div id="drag-drop-area"></div>

                {{-- Input tersembunyi untuk menyimpan path gambar setelah di-upload --}}
                <input type="hidden" name="img_produk" id="image_path">

                @error('img_produk')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>
        </div>
        
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
            });
        </script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Panggil variabel global yang sudah kita siapkan di app.js
                const { Uppy, Dashboard, ImageEditor, XHRUpload } = window;
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                const uppy = new Uppy({ /* ... konfigurasi Anda ... */ });

                uppy.use(Dashboard, { /* ... konfigurasi Anda ... */ });
                uppy.use(ImageEditor, { /* ... konfigurasi Anda ... */ });
                uppy.use(XHRUpload, {
                    endpoint: '{{ route('produk.upload') }}',
                    fieldName: 'image',
                    headers: { 'X-CSRF-TOKEN': csrfToken }
                });

                uppy.on('upload-success', (file, response) => {
                    document.getElementById('image_path').value = response.body.path;
                });
            });
        </script>
    @endpush
</x-layout>

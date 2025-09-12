<x-layout>

    @push('styles')
        <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet">
        <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">
        <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet">
        <link href="https://unpkg.com/filepond-plugin-image-edit/dist/filepond-plugin-image-edit.css" rel="stylesheet">
    @endpush

    @section('breadcrumb')
        @php
        // Definisikan item breadcrumb dalam bentuk array
        $breadcrumbItems = [
            ['name' => 'Page', 'url' => '/dashboard'],
            ['name' => 'Manajemen Produk', 'url' => route('produk.index')],
            ['name' => 'Edit Produk', 'url' => '#'],
        ];
        @endphp
        <x-breadcrumb :items="$breadcrumbItems" />
    @endsection

    {{-- Form Isian --}}
    <form method="post" action="{{ route('produk.update', $produk->slug) }}" enctype="multipart/form-data">
        @method('put')
        @csrf
        {{-- informasi produk --}}
        <div class="card m-4">
            <div class="card-header pt-3 pb-0 mb-0 ">
                <h6 class="">Informasi Produk</h6>
            </div>
            <div class="card-body px-4 pt-0">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="nama_produk" class="form-label">Nama Produk <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nama_produk') is-invalid @enderror" id="nama_produk" name="nama_produk" value="{{ old('nama_produk', $produk->nama_produk) }}" required autofocus>
                        @error('nama_produk')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="barcode" class="form-label">Item Barcode <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('barcode') is-invalid @enderror" id="barcode" name="barcode" value="{{ old('barcode', $produk->barcode) }}" required>
                        @error('barcode')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="slug" class="form-label">Slug <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug" name="slug" value="{{ old('slug', $produk->slug) }}" required>
                        @error('slug')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="sku" class="form-label">SKU <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('sku') is-invalid @enderror" id="sku" name="sku" value="{{ old('sku', $produk->sku) }}" required>
                        @error('sku')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="kategori" class="form-label">Kategori <span class="text-danger">*</span></label>
                        <select class="form-select @error('kategori') is-invalid @enderror" name="kategori" id="kategori" placeholder="Departure" required>
                            <option value="" disabled selected>Pilih</option>
                            @foreach ($kategoris as $kategori)
                                <option value="{{ $kategori->id }}" @selected(old('kategori', $produk->kategori_produk?->id) == $kategori->id)>{{ $kategori->nama }}</option>
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
                            <option value="{{ $brand->id }}" @selected(old('brand', $produk->brand?->id) == $brand->id)>{{ $brand->nama }}</option>
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
                                <option value="{{ $unit->id }}" @selected(old('unit', $produk->unit?->id) == $unit->id)>{{ $unit->nama }} </option>
                            @endforeach
                        </select>
                        @error('unit')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-12 mb-3">
                        <div class="form-group">
                            <label for="deskripsi
                            " class="form-label">Deskripsi <span class="text-danger">*</span></label>
                            <div id="quill-editor" style="min-height: 100px;">{!! old('deskripsi', $produk->deskripsi) !!}</div>
                            <input type="hidden" name="deskripsi" id="deskripsi" value="{{ old('deskripsi', $produk->deskripsi) }}">
                            @error('deskripsi')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- stock & harga --}}
        <div class="card m-4">
            <div class="card-header pt-3 pb-0 mb-0 ">
                <h6 class="">Stok & Harga</h6>
            </div>
            <div class="card-body px-4 pt-0">
                <div class="row g-3">

                    <div class="col-md-3">
                        <label for="qty" class="form-label">Stok <span class="text-danger">*</span></label>
                        <input type="number" class="form-control @error('qty') is-invalid @enderror" id="qty" name="qty" value="{{ old('qty', $produk->qty) }}">
                        @error('qty')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-3 form-group">
                        <label for="harga_jual" class="form-control-label">Harga Jual <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">Rp.</span>
                            <input type="number" class="form-control @error('harga_jual') is-invalid @enderror" id="harga_jual" name="harga_jual" value="{{ old('harga_jual', $produk->harga_jual) }}">
                            @error('harga_jual')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <span class="input-group-text">.00</span>
                        </div>
                    </div>
                    <div class="col-md-3 form-group">
                        <label for="harga_beli" class="form-control-label">Harga Beli <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">Rp.</span>
                            <input type="number" class="form-control @error('harga_beli') is-invalid @enderror" id="harga_beli" name="harga_beli" value="{{ old('harga_beli', $produk->harga_beli) }}">
                            @error('harga_beli')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <span class="input-group-text">.00</span>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <label for="garansi" class="form-label">Garansi</label>
                        <select class="form-select @error('garansi') is-invalid @enderror" id="garansi" name="garansi">
                            <option value="" disabled selected>Pilih</option>
                             @foreach ($garansis as $garansi)
                                    <option value="{{ $garansi->id }}" @selected(old('garansi', $produk->garansi_id) == $garansi->id)>{{ $garansi->nama }} </option>
                                @endforeach
                        </select>
                        @error('garansi')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-3">
                        <label for="stok_minimum" class="form-label">Batas Stok Minimum <span class="text-danger">*</span></label>
                        <input type="number" class="form-control @error('stok_minimum') is-invalid @enderror" id="stok_minimum" name="stok_minimum" value="{{ old('stok_minimum', $produk->stok_minimum) }}">
                        @error('stok_minimum')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-3">
                        <label for="pajak" class="form-label">Pajak <span class="text-danger">*</span></label>
                        <select class="form-select @error('pajak') is-invalid @enderror" id="pajak" name="pajak" required>
                            <option value="" disabled selected>Pilih</option>
                            @foreach ($pajak as $item)
                                <option value="{{ $item->id }}" @selected(old('pajak', $produk->pajak_id) == $item->id)>{{ $item->nama_pajak }}</option>
                            @endforeach
                        </select>
                        @error('pajak')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- gambar --}}
        <div class="card m-4 ">
            <div class="card-header mb-n5">
                <h6 class="">Gambar Produk</h6>
            </div>
            <div class="card-body" >
                <input  type="file" class="filepond" name="img_produk" id="image" style="max-height: 100px;">
            </div>
        </div>

        {{-- button submit --}}
        <div class="d-flex justify-content-end mt-3 me-4">
            <button type="submit" class="btn btn-info" id="submit-edit-produk">Edit Produk</button>
            <a href="{{ route('produk.index') }}" id="cancel-button" class="btn btn-danger ms-3">Batalkan</a>
        </div>
    </form>

    @push('scripts')
        {{-- Panggil file JS yang sudah direfactor --}}
        <script src="{{ asset('assets/js/filepond-init.js') }}"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Opsi kustom untuk halaman edit: memuat gambar yang sudah ada
                const editOptions = {
                    files: [
                        @if($produk->img_produk && Storage::disk('public')->exists($produk->img_produk))
                        { source: '{{ asset('storage/' . $produk->img_produk) }}', options: { type: 'local' } }
                        @endif
                    ]
                };

                // Panggil fungsi setup FilePond dengan opsi tambahan
                setupProductFilePond('#image', '#submit-edit-produk', '#cancel-button', 'editProductForm', editOptions);

                // Inisialisasi Quill
                if (document.getElementById('quill-editor')) {
                    const hiddenInputDeskripsi = document.getElementById('deskripsi');
                    const quill = new Quill('#quill-editor', {
                        theme: 'snow',
                        placeholder: 'Tulis deskripsi produk di sini...',
                    });

                    quill.on('text-change', function() {
                        hiddenInputDeskripsi.value = quill.root.innerHTML;
                    });

                    // Jika ada old value, set ke editor
                    if (hiddenInputDeskripsi.value) {
                        quill.root.innerHTML = hiddenInputDeskripsi.value;
                    }
                }
            });
        </script>
    @endpush
</x-layout>

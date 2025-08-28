<x-layout>
   @section('breadcrumb')
        @php
        // Definisikan item breadcrumb dalam bentuk array
        $breadcrumbItems = [
            ['name' => 'Page', 'url' => '/dashboard'],
            ['name' => 'Manajemen Produk', 'url' => route('produk.index')],
            ['name' => 'Detail Produk', 'url' => '#'],
        ];
        @endphp
        <x-breadcrumb :items="$breadcrumbItems" />
    @endsection
    <div class="container-fluid d-flex flex-column min-vh-90 p-3 mb-auto">
        <div class="card">
            <div class="card-header pb-0">
                <div class="d-md-flex d-block justify-content-between align-items-center">
                    <h5 class="mb-3">Detail Produk: {{ $produk->nama_produk }}</h5>
                    <div>
                        <a href="{{ route('produk.edit', $produk->slug) }}" class="btn btn-sm btn-info mb-0">Edit</a>
                        <a href="{{ route('produk.index') }}" class="btn btn-sm btn-outline-secondary mb-0">Kembali</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    {{-- Kolom Kiri: Detail Produk dalam Tabel --}}
                    <div class="col-lg-7">
                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <tbody>
                                    <tr><td class="fw-bold" style="width: 30%;">Nama Produk</td><td>: {{ $produk->nama_produk }}</td></tr>
                                    <tr><td class="fw-bold">SKU (Stock Keeping Unit)</td><td>: {{ $produk->sku }}</td></tr>
                                    <tr><td class="fw-bold">Barcode</td><td>: {{ $produk->barcode ?? '-' }}</td></tr>
                                    <tr><td class="fw-bold">Kategori</td><td>: {{ $produk->kategori_produk->nama }}</td></tr>
                                    <tr><td class="fw-bold">Brand</td><td>: {{ $produk->brand->nama }}</td></tr>
                                    <tr><td class="fw-bold">Unit</td><td>: {{ $produk->unit->nama }}</td></tr>
                                    <tr><td class="fw-bold">Harga</td><td>: Rp.{{ number_format($produk->harga, 0, ',', '.') }}</td></tr>
                                    <tr><td class="fw-bold">Stok Saat Ini</td><td>: {{ $produk->qty }}</td></tr>
                                    <tr><td class="fw-bold">Stok Minimum</td><td>: {{ $produk->stok_minimum }}</td></tr>
                                    <tr><td class="fw-bold">Garansi</td><td>: {{ $produk->garansi?->nama ?? 'Tidak ada garansi' }}</td></tr>
                                    <tr><td class="fw-bold">Dibuat oleh</td><td>: {{ $produk->user->nama }}</td></tr>
                                    <tr>
                                        <td class="fw-bold align-text-top">Deskripsi</td>
                                        <td class="align-text-top">: {!! $produk->deskripsi ?? '-' !!}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- Kolom Kanan: Gambar Produk --}}
                    <div class="col-lg-5 mt-4 mt-lg-0">
                        <h5 class="ms-2">Gambar Produk :</h5>
                        <div class="text-start ms-2 my-3">
                            @if($produk->img_produk && Storage::disk('public')->exists($produk->img_produk))
                                <img src="{{ asset('storage/' . $produk->img_produk) }}" class="img-fluid border-radius-lg shadow-lg" style="max-height: 500px;" alt="Gambar Produk {{ $produk->nama_produk }}">
                            @else
                                <img src="https://via.placeholder.com/400x400.png/f8f9fa/6c757d?text=Tidak+Ada+Gambar" class="img-fluid border-radius-lg" alt="Tidak ada gambar">
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>

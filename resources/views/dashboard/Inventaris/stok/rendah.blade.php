<x-layout>
    {{-- Breadcrumb --}}
    @section('breadcrumb')
        @php
            $breadcrumbItems = [
                ['name' => 'Stok', 'url' => '#'],
                ['name' => 'Laporan Stok Rendah', 'url' => route('stok.rendah')],
            ];
        @endphp
        <x-breadcrumb :items="$breadcrumbItems" />
    @endsection

    <div class="container-fluid  d-flex flex-column min-vh-90 p-3 mb-auto">
        <div class="card">
            <div class="card-header pb-0">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-0">Laporan Stok Rendah</h6>
                        <p class="text-sm mb-0">
                            Menampilkan produk dengan stok kurang dari atau sama dengan <strong class="text-danger">{{ $threshold }}</strong>.
                        </p>
                    </div>
                    {{-- Anda bisa menambahkan filter di sini jika diperlukan --}}
                </div>
            </div>
            <div class="card-body px-0 mt-1 pb-2">
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-dark text-xs font-weight-bolder">Produk</th>
                                <th class="text-uppercase text-dark text-xs font-weight-bolder ps-2">Kategori</th>
                                <th class="text-uppercase text-dark text-xs font-weight-bolder ps-2">Stok Saat Ini</th>
                                <th class="text-uppercase text-dark text-xs font-weight-bolder ps-2">Harga Jual</th>
                                <th class="text-dark"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($produks as $produk)
                                <tr>
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div>
                                                <img src="{{ $produk->img_produk ? asset('storage/' . $produk->img_produk) : asset('assets/img/produk.webp') }}" class="avatar avatar-lg me-3" alt="produk image">
                                            </div>
                                            <div class="d-flex flex-column justify-content-start">
                                                <h6 class="mb-0 text-sm">{{ $produk->nama_produk }}</h6>
                                                <p class="text-xs mb-0">{{ $produk->barcode ?? 'Tidak ada kode' }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">{{ $produk->kategori_produk->nama ?? 'N/A' }}</p>
                                    </td>
                                    <td>
                                        <span class="badge badge-sm badge-danger">{{ $produk->qty }}</span>
                                    </td>
                                    <td>
                                        <span class= text-xs font-weight-bold">Rp {{ number_format($produk->harga, 0, ',', '.') }}</span>
                                    </td>
                                    <td class="align-middle">
                                        <a href="{{ route('produk.edit', $produk->id) }}" class= font-weight-bold text-xs" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Produk">
                                            <i class="bi bi-pencil-square"></i> Edit
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5">
                                        <p class="text-muted mb-0">🎉 Hebat! Tidak ada produk dengan stok rendah saat ini.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-layout>

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

    <div class="container-fluid d-flex flex-column min-vh-90 p-3 mb-auto">
        <div class="card">
            <div class="card-header pb-0">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-0">Laporan Stok Rendah</h6>
                        {{-- Deskripsi diubah menjadi lebih akurat --}}
                        <p class="text-sm mb-0">
                            Menampilkan produk yang stoknya telah mencapai atau di bawah batas stok minimumnya.
                        </p>
                    </div>
                </div>
            </div>
            <div class="card-body px-0 mt-1 pb-2">
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-dark text-xs font-weight-bolder">Produk</th>
                                <th class="text-uppercase text-dark text-xs font-weight-bolder ps-2">Kategori</th>
                                <th class="text-uppercase text-dark text-xs font-weight-bolder ps-2">Stok (Minimum)</th>
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
                                                <p class="text-xs mb-0">{{ $produk->sku ?? 'Tidak ada SKU' }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">{{ $produk->kategori_produk->nama ?? 'N/A' }}</p>
                                    </td>
                                    <td>
                                        {{-- Tampilkan stok saat ini dan batas minimumnya --}}
                                        <span class="badge badge-sm bg-gradient-danger">{{ $produk->qty }}</span>
                                        <p class="text-xs text-secondary mb-0">Min: {{ $produk->stok_minimum }}</p>
                                    </td>
                                    <td>
                                        {{-- PERBAIKAN: class, dan variabel harga_jual --}}
                                        <span class="text-xs font-weight-bold">Rp {{ number_format($produk->harga_jual, 0, ',', '.') }}</span>
                                    </td>
                                    <td class="align-middle">
                                        <a href="{{ route('pembelian.create', ['produk_slug' => $produk->slug]) }}" class="mb-0 me-3" data-bs-toggle="tooltip" data-bs-placement="top" title="Beli Produk Ini">
                                            <i class="bi bi-cart-plus-fill bi-lg"></i>
                                        </a>
                                        {{-- PERBAIKAN: class, dan routing ke slug produk --}}
                                        <a href="{{ route('produk.edit', $produk->slug) }}" class="fw-bolder text-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Produk">
                                            <i class="bi bi-pencil-square bi-lg"></i>
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
                 <div class="d-flex justify-content-center mt-4">
                    {{ $produks->links() }}
                </div>
            </div>
        </div>
    </div>
</x-layout>

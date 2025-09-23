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
        <div class="card rounded-2">
            <div class="card-header pb-0 px-3 pt-2 mb-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-0">Laporan Stok Rendah</h6>
                        {{-- Deskripsi diubah menjadi lebih akurat --}}
                        <p class="text-sm mb-0 d-none d-md-block">
                            Menampilkan produk yang stoknya telah mencapai atau di bawah batas stok minimumnya.
                        </p>
                        <p class="text-sm mb-0 d-md-none d-block">
                            Menampilkan produk dengan stok minim
                        </p>
                    </div>
                </div>
            </div>
            <div class="card-body px-0 mt-1 pb-2">
                {{-- Form Pencarian dan Filter --}}
                <div class="px-3 mb-4">
                    <form action="{{ route('stok.rendah') }}" method="GET">
                        <div class="row g-2">
                            <div class="col-md-4">
                                <input type="text" name="search" class="form-control" placeholder="Cari nama produk..."
                                    value="{{ request('search') }}">
                            </div>
                            <div class="col-md-3">
                                <select name="kategori" class="form-select">
                                    <option value="">Semua Kategori</option>
                                    @foreach ($kategoris as $kategori)
                                        <option value="{{ $kategori->id }}" @selected(request('kategori') == $kategori->id)>
                                            {{ $kategori->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2 d-grid">
                                <button type="submit" class="btn btn-primary"><i class="bi bi-search me-1"></i> Cari</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="table-responsive p-0">
                    <table class="table table-hover align-items-center mb-0">
                        <thead class="table-secondary">
                            <tr>
                                <th class="text-uppercase text-dark text-xs font-weight-bolder">Produk</th>
                                <th class="text-uppercase text-dark text-xs font-weight-bolder ps-2">Kategori</th>
                                <th class="text-uppercase text-dark text-xs font-weight-bolder ps-2">Pemasok Terakhir</th>
                                <th class="text-uppercase text-dark text-xs font-weight-bolder text-center">Stok Tersedia</th>
                                <th class="text-uppercase text-dark text-xs font-weight-bolder text-center">Stok Minimum</th>
                                <th class="text-uppercase text-dark text-xs font-weight-bolder ps-2">Harga Jual</th>
                                <th class="text-uppercase text-dark text-xs font-weight-bolder ps-2">Terakhir Terjual</th>
                                <th class="text-dark"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($produks as $produk)
                                <tr>
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div>
                                                <img src="{{ $produk->img_produk ? asset('storage/' . $produk->img_produk) : asset('assets/img/produk.webp') }}" class="avatar avatar-sm me-3" alt="produk image">
                                            </div>
                                            <div class="d-flex flex-column justify-content-start">
                                                <h6 class="mb-0 text-sm">{{ $produk->nama_produk }}</h6>
                                                <p class="text-xs mb-0">{{ $produk->sku ?? 'Tidak ada SKU' }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-bold mb-0">{{ $produk->kategori_produk->nama ?? 'N/A' }}</p>
                                    </td>
                                    <td>
                                        @if ($pemasok = $produk->latestPurchaseDetail?->pembelian?->pemasok)
                                            <div class="d-flex flex-column justify-content-start">
                                                <p class="text-sm font-weight-bold mb-0">{{ $pemasok->nama }}</p>
                                                <p class="text-xs text-muted mb-0">{{ $pemasok->kontak }}</p>
                                            </div>
                                        @else
                                            <span class="text-xs text-muted fst-italic">Belum ada riwayat</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        {{-- Tampilkan stok saat ini dan batas minimumnya --}}
                                        <span class="badge badge-sm badge-danger">{{ $produk->qty }}</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge badge-sm badge-secondary">{{ $produk->stok_minimum }}</span>
                                    </td>
                                    <td>
                                        <span class="text-sm font-weight-bold">Rp {{ number_format($produk->harga_jual, 0, ',', '.') }}</span>
                                    </td>
                                    <td>
                                        @if ($produk->last_sale_date)
                                            <span class="text-sm">{{ \Carbon\Carbon::parse($produk->last_sale_date)->translatedFormat('d M Y') }}</span>
                                        @else
                                            <span class="text-xs text-muted fst-italic">Belum Pernah</span>
                                        @endif
                                    </td>
                                    <td class="align-middle">
                                        <a href="{{ route('pembelian.create')}}" class="mb-0 me-3" data-bs-toggle="tooltip" data-bs-placement="top" title="Beli Produk Ini">
                                            <i class="bi bi-cart-plus-fill bi-lg"></i>
                                        </a>
                                        <a href="{{ route('produk.edit', $produk->slug) }}" class="fw-bolder text-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Produk">
                                            <i class="bi bi-pencil-square bi-lg"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-4">
                                        <p class="text-muted mb-0 text-sm fw-bolder">Tidak ada produk dengan stok rendah saat ini.</p>
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

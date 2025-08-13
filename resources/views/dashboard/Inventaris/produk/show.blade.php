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

    <div class="card m-4 p-3">
        <div class="card-header p-0 mx-3 mt-3 position-relative z-index-1">
            <p class="text-dark ms-2 my-0">{{ $produk->sku }}</p>
            <a href="javascript:;" class="d-block">
            <img src="{{ $produk->user->img_user }}" class="w-10 h-10 border-radius-lg">
            </a>
        </div>
        <div class="card-body pt-2">
            <span class="text-gradient text-primary text-uppercase text-xs font-weight-bold my-2">{{ $produk->brand->nama }}</span>
            <span class="text-gradient text-primary text-uppercase text-xs font-weight-bold my-2">{{ $produk->kategori_produk->nama }}</span>
            <a href="javascript:;" class="card-title h5 d-block text-darker">
            {{ $produk->nama }}
            </a>
            <h3 class=" mb-4"> Rp.{{ $produk->harga_formatted }}</h3>
            <div class="author align-items-center">
                <img src="{{ $produk->user->img_user }}" alt="..." class="avatar shadow">
                <div class="name ps-3">
                    <span>{{ $produk->user->nama }}</span>
                    <div class="stats">
                        <p class="text-dark">sisa produk <small class=" fw-bold text-dark">{{ $produk->qty }}</small></p>
                    </div>
                </div>
            </div>
        </div>
        <a href="/produk">
            <button class="btn btn-sm btn-outline-danger">Back</button>
        </a>
    </div>

</x-layout>



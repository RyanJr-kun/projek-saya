<x-marketLayout>

    {{-- Hero Section --}}
    @if ($mainBanners->isNotEmpty())
        <div class="container py-4">
            <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    @foreach ($mainBanners as $key => $banner)
                        <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="{{ $key }}" class="{{ $loop->first ? 'active' : '' }}" aria-current="{{ $loop->first ? 'true' : 'false' }}" aria-label="Slide {{ $key + 1 }}"></button>
                    @endforeach
                </div>
                <div class="carousel-inner rounded-3">
                    @foreach ($mainBanners as $banner)
                        <div class="carousel-item {{ $loop->first ? 'active' : '' }}" data-bs-interval="5000">
                            <a href="{{ $banner->url_tujuan ?? '#' }}">
                                <img src="{{ asset('storage/' . $banner->img_banner) }}" class="d-block w-100" alt="{{ $banner->judul ?? 'Banner' }}">
                            </a>
                        </div>
                    @endforeach
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
    @else
        {{-- Tampilkan hero section default jika tidak ada banner --}}
        <div class="container col-xxl-8 px-4 py-5">
            <div class="row flex-lg-row-reverse align-items-center g-5 py-5">
                <div class="col-10 col-sm-8 col-lg-6">
                    <img src="https://via.placeholder.com/700x500/CCCCCC/FFFFFF?text=Produk+Unggulan" class="d-block mx-lg-auto img-fluid rounded" alt="Bootstrap Themes" width="700" height="500" loading="lazy">
                </div>
                <div class="col-lg-6">
                    <h1 class="display-5 fw-bold lh-1 mb-3">Selamat Datang di Jo-Pos Market</h1>
                    <p class="lead">Temukan berbagai macam komponen dan aksesoris komputer berkualitas dengan harga terbaik. Kami menyediakan semua kebutuhan Anda, mulai dari perakitan hingga upgrade.</p>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-start">
                        <a href="{{ route('market.produk') }}" type="button" class="btn btn-info btn-lg px-4 me-md-2">Lihat Produk</a>
                        <a href="#" type="button" class="btn btn-outline-secondary btn-lg px-4">Hubungi Kami</a>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Promo & Bestseller Section --}}
    @if ($promoVertikalBanners->isNotEmpty() || $bestsellerBanners->isNotEmpty())
    <div class="container px-4 py-5">
        <div class="row g-4">
            {{-- Kolom untuk Promo Vertikal --}}
            @if ($promoVertikalBanners->isNotEmpty())
                <div class="col-lg-4 d-flex flex-column gap-4">
                    @foreach ($promoVertikalBanners->take(2) as $banner) {{-- Ambil maksimal 2 banner vertikal --}}
                        <div class="promo-banner-vertikal rounded overflow-hidden shadow-sm">
                             <a href="{{ $banner->url_tujuan ?? '#' }}">
                                <img src="{{ asset('storage/' . $banner->img_banner) }}" class="img-fluid" alt="{{ $banner->judul ?? 'Promo' }}">
                            </a>
                        </div>
                    @endforeach
                </div>
            @endif

            {{-- Kolom untuk Bestseller Banner (mengambil sisa ruang) --}}
            @if ($bestsellerBanners->isNotEmpty())
                <div class="col-lg-8">
                    <a href="{{ $bestsellerBanners->first()->url_tujuan ?? '#' }}">
                        <img src="{{ asset('storage/' . $bestsellerBanners->first()->img_banner) }}" class="img-fluid rounded shadow-sm" alt="{{ $bestsellerBanners->first()->judul ?? 'Bestseller' }}">
                    </a>
                </div>
            @endif
        </div>
    </div>
    @endif

    {{-- Featured Products Section --}}
    <div class="album py-5 bg-light">
        <div class="container">
            <h2 class="text-center mb-5 fw-bold">Produk Unggulan</h2>
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-3">
                {{-- Contoh Card Produk (Ulangi untuk setiap produk) --}}
                @for ($i = 0; $i < 8; $i++)
                <div class="col">
                    <div class="card shadow-sm product-card h-100">
                        <a href="{{ route('market.produk.detail', ['slug' => 'contoh-produk-'.$i]) }}" class="text-decoration-none text-dark">
                            <img src="https://via.placeholder.com/300x200/EEEEEE/000000?text=Produk+{{$i+1}}" class="card-img-top" alt="Produk {{$i+1}}">
                            <div class="card-body">
                                <h5 class="card-title">Nama Produk {{$i+1}}</h5>
                                <p class="card-text text-muted">Deskripsi singkat mengenai produk ini.</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <p class="text-info fw-bold fs-5 mb-0">Rp 1.500.000</p>
                                    <small class="text-success">Stok Tersedia</small>
                                </div>
                            </div>
                        </a>
                        <div class="card-footer bg-transparent border-top-0 pb-3">
                             <button type="button" class="btn btn-sm btn-outline-info w-100">
                                <i class="bi bi-cart-plus"></i> Tambah ke Keranjang
                            </button>
                        </div>
                    </div>
                </div>
                @endfor
                {{-- Akhir Contoh Card Produk --}}
            </div>
            <div class="text-center mt-5">
                <a href="{{ route('market.produk') }}" class="btn btn-outline-dark">Lihat Semua Produk</a>
            </div>
        </div>
    </div>

    {{-- Features Section --}}
    <div class="container px-4 py-5">
        <h2 class="pb-2 border-bottom text-center mb-5">Kenapa Memilih Kami?</h2>
        <div class="row g-4 py-5 row-cols-1 row-cols-lg-3">
            <div class="feature col text-center">
                <div class="feature-icon-small d-inline-flex align-items-center justify-content-center text-bg-info bg-gradient fs-2 mb-3 rounded-3" style="width: 3rem; height: 3rem;"><i class="bi bi-collection"></i></div>
                <h3 class="fs-4">Produk Lengkap</h3>
                <p>Kami menyediakan berbagai macam produk dari brand ternama untuk memenuhi semua kebutuhan Anda.</p>
            </div>
            <div class="feature col text-center">
                <div class="feature-icon-small d-inline-flex align-items-center justify-content-center text-bg-info bg-gradient fs-2 mb-3 rounded-3" style="width: 3rem; height: 3rem;"><i class="bi bi-patch-check"></i></div>
                <h3 class="fs-4">Kualitas Terjamin</h3>
                <p>Semua produk yang kami jual adalah original dan bergaransi resmi, menjamin kualitas terbaik.</p>
            </div>
            <div class="feature col text-center">
                <div class="feature-icon-small d-inline-flex align-items-center justify-content-center text-bg-info bg-gradient fs-2 mb-3 rounded-3" style="width: 3rem; height: 3rem;"><i class="bi bi-truck"></i></div>
                <h3 class="fs-4">Pengiriman Cepat</h3>
                <p>Nikmati layanan pengiriman yang cepat dan aman ke seluruh penjuru Indonesia.</p>
            </div>
        </div>
    </div>

</x-marketLayout>

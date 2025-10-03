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

    {{-- Browse by Category Section --}}
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold mb-0">Jelajahi Kategori</h2>
        </div>
        <div class="position-relative category-scroll-wrapper">
            <div id="category-scroll-container" class="d-flex gap-3 overflow-hidden">
                @foreach ($kategoris as $kategori)
                    <div class="category-item" style="flex: 0 0 auto; width: 200px;">
                        {{-- Ganti '#' dengan link ke halaman kategori jika ada --}}
                        <a href="#" class="text-decoration-none text-dark ">
                            <div class="card category-card h-100 bg-light shadow-sm mx-2 mb-2 overflow-hidden">
                                <img src="{{ $kategori->img_kategori ? asset('storage/' . $kategori->img_kategori) : asset('assets/img/produk.webp') }}" class="card-img-top" alt="{{ $kategori->nama }}" style="height: 150px;">
                                <div class="card-body p-2 text-center">
                                    <h6 class="card-title fw-bold text-truncate mb-1" title="{{ $kategori->nama }}">{{ $kategori->nama }}</h6>
                                    <p class="card-text text-muted small">{{ $kategori->produks_count }} Produk</p>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
            <button id="category-scroll-prev" class="btn btn-light rounded-circle category-scroll-btn prev" aria-label="Kategori Sebelumnya">
                <i class="bi bi-arrow-left"></i>
            </button>
            <button id="category-scroll-next" class="btn btn-light rounded-circle category-scroll-btn next" aria-label="Kategori Berikutnya">
                <i class="bi bi-arrow-right"></i>
            </button>
        </div>
    </div>

    {{-- Promo Section --}}
    @if ($promoVertikalBanners->isNotEmpty())
    <div class="container px-4 py-5">
        <div class="row g-4">
            {{-- Kolom untuk Promo Vertikal --}}
            {{-- Sembunyikan di mobile (d-none) dan tampilkan di desktop (d-lg-block) --}}
            <div class="col-lg-4 d-none d-lg-block">
                <div id="promoVertikalCarousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner rounded-3">
                        @foreach ($promoVertikalBanners as $banner)
                            <div class="carousel-item {{ $loop->first ? 'active' : '' }}" data-bs-interval="7000">
                                <a href="{{ $banner->url_tujuan ?? '#' }}">
                                    <img src="{{ asset('storage/' . $banner->img_banner) }}" class="d-block w-100" alt="{{ $banner->judul ?? 'Promo' }}">
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Kolom untuk 4 produk promo --}}
            <div class="col-lg-8">
                <div class="row row-cols-2 row-cols-md-4 g-3">
                    {{-- Placeholder untuk 4 produk promo, Anda bisa menggantinya dengan loop produk promo nanti --}}
                    @for ($i = 0; $i < 4; $i++)
                    <div class="col product-card">
                        <div class="card shadow-sm h-100">
                            <a href="#" class="text-decoration-none text-dark">
                                <img src="https://via.placeholder.com/300x200/FFC107/000000?text=Promo+{{$i+1}}" class="card-img-top" alt="Produk Promo {{$i+1}}">
                                <div class="card-body p-2">
                                    <h6 class="card-title small">Nama Produk Promo</h6>
                                    <p class="text-danger fw-bold mb-0">Rp 99.000</p>
                                    <small class="text-muted text-decoration-line-through">Rp 150.000</small>
                                </div>
                            </a>
                        </div>
                    </div>
                    @endfor
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- Bestseller Section (Full Container) --}}
    @if ($bestsellerBanners->isNotEmpty())
    <div class="container px-4 py-5">
        <h2 class="text-center mb-4 fw-bold">Produk Terlaris</h2>
        <div class="row">
            <div class="col-12">
                <div id="bestsellerCarousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-indicators">
                        @foreach ($bestsellerBanners as $key => $banner)
                            <button type="button" data-bs-target="#bestsellerCarousel" data-bs-slide-to="{{ $key }}" class="{{ $loop->first ? 'active' : '' }}" aria-current="{{ $loop->first ? 'true' : 'false' }}" aria-label="Slide {{ $key + 1 }}"></button>
                        @endforeach
                    </div>
                    <div class="carousel-inner rounded-3 shadow-sm">
                        @foreach ($bestsellerBanners as $banner)
                            <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                                <a href="{{ $banner->url_tujuan ?? '#' }}">
                                    <img src="{{ asset('storage/' . $banner->img_banner) }}" class="d-block w-100" alt="{{ $banner->judul ?? 'Bestseller Banner' }}">
                                </a>
                            </div>
                        @endforeach
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#bestsellerCarousel" data-bs-slide="prev">
                        <button class="carousel-control-prev" type="button" data-bs-target="#bestsellerCarousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#bestsellerCarousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                </div>
            </div>
        </div>
        {{-- Loop untuk 6 produk terlaris --}}
        @if($produkTerlaris->isNotEmpty())
        <div class="row row-cols-2 row-cols-md-3 row-cols-lg-6 g-3 mt-4">
            @foreach ($produkTerlaris as $produk)
            <div class="col">
                <div class="card shadow-sm product-card h-100 overflow-hidden">
                    <a href="{{ route('market.produk.detail', ['slug' => $produk->slug]) }}" class="text-decoration-none text-dark">
                        <img src="{{ $produk->img_produk ? asset('storage/' . $produk->img_produk) : asset('assets/img/produk.webp') }}" class="card-img-top" alt="{{ $produk->nama_produk }}">
                        <div class="card-body p-2">
                            <h6 class="card-title small text-truncate" title="{{ $produk->nama_produk }}">{{ $produk->nama_produk }}</h6>
                            <p class="text-info fw-bold mb-0">{{ $produk->harga_formatted }}</p>
                            <small class="text-muted">Terjual: {{ $produk->total_terjual }} {{ $produk->unit->singkat }}</small>
                        </div>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
        @endif

    </div>
    @endif

    {{-- Featured Products Section --}}
    <div class="album py-5 bg-light">
        <div class="container">
            <h2 class="text-center mb-5 fw-bold">Produk Unggulan</h2>
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-3">
                {{-- Contoh Card Produk (Ulangi untuk setiap produk) --}}
                @for ($i = 0; $i < 8; $i++)
                <div class="col ">
                    <div class="card shadow-sm product-card h-100">
                        <a href="{{ route('market.produk.detail', ['slug' => 'contoh-produk-'.$i]) }}" class="text-decoration-none text-dark">
                            <img src="https://via.placeholder.com/300x200/EEEEEE/000000?text=Produk+{{$i+1}}" class="card-img-top rounded-2" alt="Produk {{$i+1}}">
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

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const container = document.getElementById('category-scroll-container');
            const prevBtn = document.getElementById('category-scroll-prev');
            const nextBtn = document.getElementById('category-scroll-next');

            // Atur transisi scroll pada kontainer kategori untuk animasi yang halus
            container.style.scrollBehavior = 'smooth';

            // Scroll sejauh lebar satu item kategori
            const scrollAmount = () => {
                const firstItem = container.querySelector('.category-item');
                // Lebar item + gap
                return firstItem ? firstItem.offsetWidth + parseInt(getComputedStyle(container).gap) : 216;
            };

            let autoScrollInterval;

            const startAutoScroll = () => {
                autoScrollInterval = setInterval(() => {
                    // Jika sudah di ujung, kembali ke awal
                    if (container.scrollLeft + container.clientWidth >= container.scrollWidth - 1) {
                        container.scrollLeft = 0;
                    } else {
                        container.scrollLeft += scrollAmount();
                    }
                }, 3000); // Geser setiap 3 detik
            };

            const stopAutoScroll = () => clearInterval(autoScrollInterval);

            prevBtn.addEventListener('click', () => container.scrollLeft -= scrollAmount());
            nextBtn.addEventListener('click', () => container.scrollLeft += scrollAmount());

            // Mulai auto-scroll saat halaman dimuat
            startAutoScroll();
            // Hentikan auto-scroll saat mouse masuk ke area, dan mulai lagi saat keluar
            container.parentElement.addEventListener('mouseenter', stopAutoScroll);
            container.parentElement.addEventListener('mouseleave', startAutoScroll);
        });
    </script>
    @endpush

</x-marketLayout>

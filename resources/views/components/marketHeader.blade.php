<header class="sticky-top bg-white shadow-0">
    {{-- 2. MAIN HEADER (Logo, Search, Icons) --}}
    <div class="main-header container-fluid container-xl border-bottom ">
        <div class="d-flex justify-content-between align-items-center py-3 border-top">
            {{-- Desktop: Logo --}}
            <a class="navbar-brand d-none d-lg-block" href="{{ url('/') }}">
                <img src="{{ asset('assets/img/logomiring.svg') }}" alt="gambar logo" style="height: 50px;">
            </a>
            {{-- Mobile: Logo --}}
            <a class="navbar-brand d-lg-none" href="{{ url('/') }}">
                <img src="{{ asset('assets/img/logomiring.svg') }}" alt="gambar logo" style="height: 45px;">
            </a>

            {{-- Desktop: Search Form --}}
            <div class="d-none d-lg-block w-50">
                <form>
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Cari produk, kategori, atau brand..." aria-label="Cari produk">
                    </div>
                </form>
            </div>


            {{-- All Devices: Action Icons --}}
            <div class="d-flex align-items-center justify-content-end">
                <div class="dropdown d-flex align-items-center">
                @auth
                    <a class="text-dark d-flex align-items-center me-3" href="https://wa.me/6281318000699" target="_blank" rel="noopener noreferrer">
                        <i class="bi bi-whatsapp bi-lg me-lg-2 text-success"></i>
                        <div class="d-none d-lg-block">
                            <p class="mb-0 fw-bold" style="font-size: 0.8rem; line-height: 1.2;">Bantuan & Layanan</p>
                            <p class="mb-0 text-muted" style="font-size: 0.9rem; line-height: 1.2;">0813-1800-0699</p>
                        </div>
                    </a>

                    <a href="#" class="text-dark d-lg-none" data-bs-toggle="offcanvas" data-bs-target="#offcanvasSearch" aria-controls="offcanvasSearch">
                        <i class="bi bi-search bi-lg"></i>
                    </a>

                    {{-- Logged In View --}}
                    <a href="#" class="nav-link text-dark p-0 mx-3" data-bs-toggle="dropdown" aria-expanded="false">
                        @if (auth()->user()->img_user)
                            <img src="{{ asset('storage/' . auth()->user()->img_user) }}" alt="Profile" class="avatar avatar-sm rounded-2">
                        @else
                            <i class="bi bi-person-circle fs-4"></i>
                        @endif
                    </a>
                    <button class="navbar-toggler border-0 p-0 d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNav" aria-controls="offcanvasNav">
                        <i class="bi bi-list bi-lg"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end p-2 mt-2">
                        <li class="text-start d-flex m-2">
                            @if (auth()->user()->img_user)
                                <img src="{{ asset('storage/' . auth()->user()->img_user) }}" alt="Profile" class="avatar avatar-sm rounded-circle cursor-pointer">
                            @else
                                <img src="{{ asset('assets/img/user.webp') }}" class="avatar avatar-sm me-3" alt="Gambar user default">
                            @endif
                            <div class="ms-2">
                                <p class="mb-0 text-xs fw-bolder">{{ auth()->user()->username }}</p>
                                <p class="text-xs text-secondary">{{ auth()->user()->role->nama }}</p>
                            </div>
                        </li>
                        <li>
                            <a class="dropdown-item border-radius-md" href="{{ route('dashboard') }}"><i class="bi bi-tv me-2"></i> Dashboard</a>
                        </li>
                        <li>
                            <a class="dropdown-item border-radius-md" href="{{ route('penjualan.create') }}"><i class="bi bi-person-fill me-2"></i> Point Of Sales</a>
                        </li>
                        <li>
                            <form action="{{ route('logout') }}" method="post">
                                @csrf
                                <button type="submit" class="dropdown-item border-radius-md w-100 text-danger" style="text-align: left;"><i class="bi bi-box-arrow-right me-2"></i>Log Out</button>
                            </form>
                        </li>
                    </ul>
                @else
                    <div class="d-flex align-items-center">

                        {{-- Tautan Bantuan WhatsApp --}}
                        <a class="text-dark d-flex align-items-center me-3" href="https://wa.me/6281318000699" target="_blank" rel="noopener noreferrer">
                            <i class="bi bi-whatsapp bi-lg me-lg-2 text-success"></i>
                            <div class="d-none d-lg-block">
                                <p class="mb-0 fw-bold" style="font-size: 0.8rem; line-height: 1.2;">Bantuan & Layanan</p>
                                <p class="mb-0 text-muted" style="font-size: 0.9rem; line-height: 1.2;">0813-1800-0699</p>
                            </div>
                        </a>
                        <a href="#" class="text-dark d-lg-none" data-bs-toggle="offcanvas" data-bs-target="#offcanvasSearch" aria-controls="offcanvasSearch">
                            <i class="bi bi-search bi-lg"></i>
                        </a>

                        {{-- Guest View: Login Icon --}}
                        <a href="/login" class="nav-link mx-3 text-dark p-0" title="Login/Register">
                            <i class="bi bi-person-circle bi-xl"></i>
                        </a>

                        <button class="navbar-toggler d-lg-none border-0 p-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNav" aria-controls="offcanvasNav">
                            <i class="bi bi-list bi-xl"></i>
                        </button>


                    </div>
                @endauth
                </div>
            </div>
        </div>
    </div>

    {{-- 3. NAVIGATION BAR (Desktop) --}}
    <nav class="navbar navbar-expand-lg navbar-light bg-white d-none d-lg-block shadow-none">
        <div class="container-fluid container-xl border-md-top">
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav">
                    <li class="nav-item me-4"><a class="nav-link text-sm nav-link-animated active" aria-current="page" href="#">Beranda</a></li>
                    <li class="nav-item dropdown me-4">
                        <a class="nav-link text-sm dropdown-toggle" href="#" id="kategoriDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Kategori</a>
                        <ul class="dropdown-menu dropdown-menu-end p-2 mt-2 rounded-2" aria-labelledby="kategoriDropdown">
                            <li><a class="dropdown-item border-radius-md" href="#">Laptop</a></li>
                            <li><a class="dropdown-item border-radius-md" href="#">PC Rakitan</a></li>
                            <li><a class="dropdown-item border-radius-md" href="#">Komponen</a></li>
                            <li><a class="dropdown-item border-radius-md" href="#">Aksesoris</a></li>
                        </ul>
                    </li>
                    <li class="nav-item me-4"><a class="nav-link text-sm nav-link-animated" href="#">Promo</a></li>
                    <li class="nav-item me-4"><a class="nav-link text-sm nav-link-animated" href="#">Tentang Kami</a></li>
                    <li class="nav-item"><a class="nav-link text-sm nav-link-animated" href="#">Kontak</a></li>
                </ul>
            </div>
        </div>
    </nav>

    {{-- Mobile Offcanvas Navigation --}}
    <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNav" aria-labelledby="offcanvasNavLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasNavLabel">Menu</h5>
            <i class="bi bi-x-lg p-3 cursor-pointer text-dark opacity-5 position-absolute end-0 top-0 d-xl-none" data-bs-dismiss="offcanvas" aria-label="Close"></i>
        </div>
        <div class="offcanvas-body">
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link fs-5" href="#">Beranda</a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle fs-5" href="#" id="offcanvasKategoriDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Kategori</a>
                    <ul class="dropdown-menu border-0" aria-labelledby="offcanvasKategoriDropdown">
                        <li><a class="dropdown-item" href="#">Laptop</a></li>
                        <li><a class="dropdown-item" href="#">PC Rakitan</a></li>
                        <li><a class="dropdown-item" href="#">Komponen</a></li>
                        <li><a class="dropdown-item" href="#">Aksesoris</a></li>
                    </ul>
                </li>
                <li class="nav-item"><a class="nav-link fs-5" href="#">Promo</a></li>
                <li class="nav-item"><a class="nav-link fs-5" href="#">Tentang Kami</a></li>
                <li class="nav-item"><a class="nav-link fs-5" href="#">Kontak</a></li>
            </ul>
        </div>
    </div>

    {{-- Mobile Offcanvas Search --}}
    <div class="offcanvas offcanvas-top" tabindex="-1" id="offcanvasSearch" aria-labelledby="offcanvasSearchLabel" style="height: auto;">
        <div class="offcanvas-body">
            <div class="container d-flex align-items-center justify-content-between">
                <form class="w-90" action="{{-- URL untuk halaman pencarian --}}" method="GET">
                    <input type="search" name="keyword" class="form-control" placeholder="Cari produk..." autofocus>
                </form>
                <i class="bi bi-x-lg py-4 px-3 cursor-pointer text-dark opacity-5 position-absolute end-0 top-0 d-xl-none" data-bs-dismiss="offcanvas" aria-label="Close"></i>
            </div>
        </div>
    </div>
</header>

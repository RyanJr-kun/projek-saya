<aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs fixed-start " id="sidenav-main">

    {{-- logo --}}
    <div class="sidenav-header">
      <a class="navbar-brand m-0" href="/dashboard" target="_blank">
        <img src="{{ asset('assets/img/logo.svg') }}" width="40px" height="40px" class="navbar-brand-img h-100" alt="main_logo">
        <span class="ms-1 font-weight-bold">Computer POS</span>
      </a>
      <i class="bi bi-x-lg p-3 cursor-pointer text-dark opacity-5 position-absolute end-0 top-0 d-xl-none" aria-hidden="true" id="iconSidenav"></i>
    </div>
    <hr class="horizontal dark my-2">

    {{-- sidebar content --}}
    <div class="collapse navbar-collapse h-auto pb-5 " id="sidenav-scrollbar">
        <ul class="navbar-nav">

            {{-- Dashboard --}}
            <li class="nav-item">
                <a class="nav-link hover {{ request()->is('dashboard') ? 'active' : '' }} " href="{{ route('dashboard') }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                    <i class="bi bi-tv text-dark text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Dashboard</span>
                </a>
            </li>

            {{-- penjualan --}}
            <li class="nav-item">@php $isPenjualanActive = request()->routeIs('penjualan.*', 'pelanggan.*'); @endphp
                <a data-bs-toggle="collapse" href="#penjualan" class="nav-link {{ $isPenjualanActive ? 'active' : '' }}" aria-controls="penjualan" role="button" aria-expanded="{{ $isPenjualanActive ? 'true' : 'false' }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="bi bi-bag-dash text-dark text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Penjualan</span>
                </a>
                <div class="collapse {{ $isPenjualanActive ? 'show' : '' }}" id="penjualan">
                    <ul class="nav ms-4">
                        <li class="nav-item ">
                            <a class="nav-link {{ request()->routeIs('penjualan.create') ? 'active' : '' }}" href="{{ route('penjualan.create') }}">
                                <span class="sidenav-normal"> Kasir </span>
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link {{ request()->routeIs('penjualan.index', 'penjualan.show') ? 'active' : '' }}" href="{{ route('penjualan.index') }}">

                            <span class="sidenav-normal"> Invoice Penjualan </span>
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link {{ request()->routeIs('pelanggan.*') ? 'active' : '' }}" href="{{ route('pelanggan.index') }}">

                            <span class="sidenav-normal"> Pelanggan </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            @if (Auth::user()->role_id == 1)
            {{-- pembelian --}}
            <li class="nav-item">@php $isPembelianActive = request()->routeIs('pembelian.*', 'pemasok.*'); @endphp
                <a data-bs-toggle="collapse" href="#pembelian" class="nav-link {{ $isPembelianActive ? 'active' : '' }}" aria-controls="pembelian" role="button" aria-expanded="{{ $isPembelianActive ? 'true' : 'false' }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="bi bi-bag-plus-fill text-dark text-sm opacity-10"></i>
                    </div>
                <span class="nav-link-text ms-1">Pembelian</span>
                </a>
                <div class="collapse {{ $isPembelianActive ? 'show' : '' }}" id="pembelian">
                    <ul class="nav ms-4">
                    <li class="nav-item ">
                        <a class="nav-link {{ request()->routeIs('pembelian.create') ? 'active' : '' }}" href="{{ route('pembelian.create') }}">
                        <span class="sidenav-normal"> Transaksi Baru </span>
                        </a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link {{ request()->routeIs('pembelian.index', 'pembelian.show') ? 'active' : '' }}" href="{{ route('pembelian.index') }}">
                        <span class="sidenav-normal"> Invoice Pembelian </span>
                        </a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link {{ request()->routeIs('pemasok.*') ? 'active' : '' }}" href="{{ route('pemasok.index') }}">
                        <span class="sidenav-normal"> Pemasok </span>
                        </a>
                    </li>
                    </ul>
                </div>
            </li>
            @endif

            <hr class="horizontal dark my-2">
            {{--inventaris --}}
            <li class="nav-item">
                <p class="ps-4 mb-0 text-uppercase text-xs font-weight-bolder">Inventaris</p>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('produk.*') ? 'active' : '' }} " href="{{ route('produk.index') }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                    <i class="bi bi-box-fill text-dark text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Produk</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('kategoriproduk.*') ? 'active' : '' }}" href="{{ route('kategoriproduk.index') }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="bi bi-bookmarks text-dark text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Kategori Produk</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('brand.*') ? 'active' : '' }}" href="{{ route('brand.index') }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                    <i class="bi bi-shop-window text-dark text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Brand</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('unit.*') ? 'active' : '' }} " href="{{ route('unit.index') }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                    <i class="bi bi-view-list text-dark text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Unit</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('garansi.*') ? 'active' : '' }}" href="{{ route('garansi.index') }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                    <i class="bi bi-award-fill text-dark text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Garansi</span>
                </a>
            </li>
            <hr class="horizontal dark my-2">
            {{-- Administrasi --}}
            <li class="nav-item">
                <p class="ps-4 mb-0 text-uppercase text-xs font-weight-bolder">Managemen</p>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('stok-opname.*') ? 'active' : '' }}" href="#">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                    <i class="bi bi-stack text-dark text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Stok Opname</span> {{-- Placeholder --}}
                </a>
            </li>
            <li class="nav-item">@php $isPemasukanActive = request()->routeIs('pemasukan.*', 'kategoripemasukan.*'); @endphp
                <a data-bs-toggle="collapse" href="#Pemasukan" class="nav-link {{ $isPemasukanActive ? 'active' : '' }}" aria-controls="Pemasukan" role="button" aria-expanded="{{ $isPemasukanActive ? 'true' : 'false' }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                    <i class="bi bi-cart-plus text-dark text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Pemasukan</span>
                </a>
                <div class="collapse {{ $isPemasukanActive ? 'show' : '' }}" id="Pemasukan">
                    <ul class="nav ms-4">
                    <li class="nav-item ">
                        <a class="nav-link {{ request()->routeIs('pemasukan.*') ? 'active' : '' }}" href="{{ route('pemasukan.index') }}">
                        <span class="sidenav-normal"> Pemasukan </span>
                        </a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link {{ request()->routeIs('kategoripemasukan.*') ? 'active' : '' }}" href="{{ route('kategoripemasukan.index') }}">
                        <span class="sidenav-normal"> Kategori Pemasukan </span>
                        </a>
                    </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">@php $isPengeluaranActive = request()->routeIs('pengeluaran.*', 'kategoripengeluaran.*'); @endphp
                <a data-bs-toggle="collapse" href="#pengeluaran" class="nav-link {{ $isPengeluaranActive ? 'active' : '' }}" aria-controls="pengeluaran" role="button" aria-expanded="{{ $isPengeluaranActive ? 'true' : 'false' }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                    <i class="bi bi-cart-dash text-dark text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Pengeluaran</span>
                </a>
                <div class="collapse {{ $isPengeluaranActive ? 'show' : '' }}" id="pengeluaran">
                    <ul class="nav ms-4">
                    <li class="nav-item ">
                        <a class="nav-link {{ request()->routeIs('pengeluaran.*') ? 'active' : '' }}" href="{{ route('pengeluaran.index') }}">
                        <span class="sidenav-normal"> Pengeluaran </span>
                        </a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link {{ request()->routeIs('kategoripengeluaran.*') ? 'active' : '' }}" href="{{ route('kategoripengeluaran.index') }}">
                        <span class="sidenav-normal"> Kategori Pengeluaran </span>
                        </a>
                    </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">@php $isLaporanActive = request()->routeIs('stok.rendah'); @endphp {{-- Tambahkan route laporan lain di sini --}}
                <a data-bs-toggle="collapse" href="#laporan" class="nav-link {{ $isLaporanActive ? 'active' : '' }}" aria-controls="laporan" role="button" aria-expanded="{{ $isLaporanActive ? 'true' : 'false' }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                    <i class="bi bi-bar-chart-fill text-dark text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Laporan</span>
                </a>
                <div class="collapse {{ $isLaporanActive ? 'show' : '' }}" id="laporan">
                    <ul class="nav ms-4">
                    <li class="nav-item ">
                        <a class="nav-link {{ request()->routeIs('stok.rendah') ? 'active' : '' }}" href="{{ route('stok.rendah') }}">
                        <span class="sidenav-normal"> Laporan Stok Rendah </span>
                        </a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link " href="#jual">
                        <span class="sidenav-normal"> Laporan Penjualan </span>
                        </a>
                    </li>
                    @if (Auth::user()->role_id == 1) {{-- TODO: Ganti dengan Gate atau Policy --}}
                    <li class="nav-item ">
                        <a class="nav-link " href="#beli">
                        <span class="sidenav-normal"> Laporan Pembelian </span>
                        </a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link " href="#laba">
                        <span class="sidenav-normal"> Laporan Laba Bersih </span>
                        </a>
                    </li>
                    @endif
                    </ul>
                </div>
            </li>

            @if (Auth::user()->role_id == 1) {{-- TODO: Ganti dengan Gate atau Policy --}}
            <hr class="horizontal dark my-2">
            {{-- Autentikasi --}}
            <li class="nav-item">
            <p class=" ps-4 mb-0 text-uppercase text-xs font-weight-bolder">Autentikasi</p>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }} " href="{{ route('users.index') }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                    <i class="bi bi-people-fill text-dark text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Users</span>
                </a>
            </li>
            @endif
        </ul>
    </div>
</aside>

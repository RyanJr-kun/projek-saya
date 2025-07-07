<aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4 " id="sidenav-main">
    <div class="absolut sidenav-header">
      <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
      <a class="navbar-brand m-0" href="/">
        <img src="../assets/img/logo.svg" width="33px" height="33px" class="navbar-brand-img h-100" alt="main_logo">
        <span class="ms-1 font-weight-bold">JoComputer</span>
      </a>
    </div>

    <hr class="horizontal dark mt-0">
{{-- start --}}
    <div class="collapse navbar-collapse h-auto pb-5 " id="sidenav-collapse-main">
      <ul class="navbar-nav">
        <li class="nav-item">
            {{-- setting 'active' untuk acuan page --}}
          <a class="nav-link active" href="/">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fa fa-tv text-dark text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Dashboard</span>
          </a>
        </li>
    <li class="nav-item">
        <a data-bs-toggle="collapse" href="#penjualan" class="nav-link " aria-controls="penjualan" role="button" aria-expanded="false">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fa fa-bag-shopping text-dark text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Penjualan</span>
          </a>
          <div class="collapse " id="penjualan">
            <ul class="nav ms-4">
              <li class="nav-item ">
                <a class="nav-link " href="#kasir">
                  <span class="sidenav-mini-icon"> K </span>
                  <span class="sidenav-normal"> Kasir </span>
                </a>
              </li>
              <li class="nav-item ">
                <a class="nav-link " href="#invoice">
                  <span class="sidenav-mini-icon"> I </span>
                  <span class="sidenav-normal"> Invoice Penjualan </span>
                </a>
              </li>
              <li class="nav-item ">
                <a class="nav-link " href="/pelanggan">
                  <span class="sidenav-mini-icon"> P </span>
                  <span class="sidenav-normal"> Pelanggan </span>
                </a>
              </li>
            </ul>
          </div>
        </li>
        <li class="nav-item">
        <a data-bs-toggle="collapse" href="#pembelian" class="nav-link " aria-controls="pembelian" role="button" aria-expanded="false">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fa fa-coins text-dark text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">pembelian</span>
          </a>
          <div class="collapse " id="pembelian">
            <ul class="nav ms-4">
              <li class="nav-item ">
                <a class="nav-link " href="#kasir">
                  <span class="sidenav-mini-icon"> K </span>
                  <span class="sidenav-normal"> Kasir </span>
                </a>
              </li>
              <li class="nav-item ">
                <a class="nav-link " href="#invoice">
                  <span class="sidenav-mini-icon"> I </span>
                  <span class="sidenav-normal"> Invoice pembelian </span>
                </a>
              </li>
              <li class="nav-item ">
                <a class="nav-link " href="/pemasok">
                  <span class="sidenav-mini-icon"> P </span>
                  <span class="sidenav-normal"> Pemasok </span>
                </a>
              </li>
            </ul>
          </div>
        </li>


            <hr class="horizontal dark mt-2">

        {{-- awal inventaris --}}
        <li class="nav-item mt-1">
          <p class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder">Inventaris</p>
        </li>
        <li class="nav-item">
          <a class="nav-link " href="/produk">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fa fa-dice-d6 text-dark text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Produk</span>
          </a>
        </li>
        <li class="nav-item">
        <a class="nav-link " href="#">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fa fa-arrow-trend-down text-dark text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Stok Rendah</span>
          </a>
        </li>
        <li class="nav-item">
        <a class="nav-link " href="#">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fa fa-layer-group text-dark text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Pergerakan Stok</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link " href="/kategoriproduk">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fa fa-list text-dark text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Kategori Produk</span>
          </a>
        </li>
        <li class="nav-item">
        <a class="nav-link " href="/brand">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fa fa-shop text-dark text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Brand</span>
          </a>
        </li>
        <li class="nav-item">
        <a class="nav-link " href="/unit">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fa fa-circle-info text-dark text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Unit</span>
          </a>
        </li>
        <li class="nav-item">
        <a class="nav-link " href="/garansi">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fa fa-award text-dark text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Garansi</span>
          </a>
        </li>
        {{-- akhir inventaris --}}

        <li  class="nav-item mt-3">
            <hr class="horizontal dark mt-0">
        </li>

        {{-- Administrasi --}}
        <li class="nav-item mt-3">
          <p class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder">Administrasi</p>
        </li>
        <li class="nav-item">
        <a data-bs-toggle="collapse" href="#Pemasukan" class="nav-link " aria-controls="Pemasukan" role="button" aria-expanded="false">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fa fa-sack-dollar text-dark text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Pemasukan</span>
          </a>
          <div class="collapse " id="Pemasukan">
            <ul class="nav ms-4">
              <li class="nav-item ">
                <a class="nav-link " href="/pemasukan">
                  <span class="sidenav-mini-icon"> p </span>
                  <span class="sidenav-normal"> Pemasukan </span>
                </a>
              </li>
              <li class="nav-item ">
                <a class="nav-link " href="/kategoripemasukan">
                  <span class="sidenav-mini-icon"> k </span>
                  <span class="sidenav-normal"> kategori pemasukan </span>
                </a>
              </li>
            </ul>
          </div>
        </li>
        <li class="nav-item">
        <a data-bs-toggle="collapse" href="#pengeluaran" class="nav-link " aria-controls="pengeluaran" role="button" aria-expanded="false">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fa fa-hand-holding-dollar text-dark text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Pengeluaran</span>
          </a>
          <div class="collapse " id="pengeluaran">
            <ul class="nav ms-4">
              <li class="nav-item ">
                <a class="nav-link " href="/pengeluaran">
                  <span class="sidenav-mini-icon"> P </span>
                  <span class="sidenav-normal"> Pengeluaran </span>
                </a>
              </li>
              <li class="nav-item ">
                <a class="nav-link " href="/kategoripengeluaran">
                  <span class="sidenav-mini-icon"> K </span>
                  <span class="sidenav-normal"> Kategori Pengeluaran </span>
                </a>
              </li>
            </ul>
          </div>
        </li>
        <li class="nav-item">
        <a data-bs-toggle="collapse" href="#laporan" class="nav-link " aria-controls="laporan" role="button" aria-expanded="false">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fa fa-chart-line text-dark text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Laporan</span>
          </a>
          <div class="collapse " id="laporan">
            <ul class="nav ms-4">
              <li class="nav-item ">
                <a class="nav-link " href="#stok">
                  <span class="sidenav-mini-icon"> S </span>
                  <span class="sidenav-normal"> Laporan Stok </span>
                </a>
              </li>
              <li class="nav-item ">
                <a class="nav-link " href="#jual">
                  <span class="sidenav-mini-icon"> J </span>
                  <span class="sidenav-normal"> Laporan Penjualan </span>
                </a>
              </li>
              <li class="nav-item ">
                <a class="nav-link " href="#beli">
                  <span class="sidenav-mini-icon"> B </span>
                  <span class="sidenav-normal"> Laporan Pembelian </span>
                </a>
              </li>
              <li class="nav-item ">
                <a class="nav-link " href="#laba">
                  <span class="sidenav-mini-icon"> L </span>
                  <span class="sidenav-normal"> Laporan Laba Bersih </span>
                </a>
              </li>
            </ul>
          </div>
        </li>
        {{-- end Administrasi --}}

        <li  class="nav-item mt-3">
            <hr class="horizontal dark mt-0">
        </li>
        <li class="nav-item mt-3">
          <p class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder">Setting</p>
        </li>

        <li class="nav-item">
          <a class="nav-link " href="#">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fa fa-user text-dark text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Profile</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link " href="/users">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fa fa-users text-dark text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Users</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link " href="#role">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fa fa-user-shield text-dark text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Roles & Permission</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link " href="../signup">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fa fa-right-from-bracket text-dark text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Logout</span>
          </a>
        </li>
      </ul>
    </div>
  </aside>

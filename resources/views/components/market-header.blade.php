<header>

    {{-- top Bar --}}
    <div class="top-bar py-2">
        <div class="container-fluid container-xl">
            <div class="row align-items-center">
                <div class="col-lg-4 d-none d-lg-flex">
                    <div class="me-3">
                        <i class="fa fa-whatsapp fs-14px text-black"></i>
                        <a class="fs-14px fw-bold text-black" href="http:\\wa.me/621318000699">0813-1800-0699</a>
                    </div>
                    <div class="">
                        <i class="fa fa-envelope fs-14px text-black"></i>
                        <a class="fs-14px fw-bold text-black" href="">081318000699</a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12 text-center">
                    <div class="">

                    </div>
                </div>
                <div class="col-lg-4 d-none d-lg-block justify-content-end">
                    <div class="d-flex justify-content-end">
                        <!-- Account -->
                        <div class="dropdown ">
                            <a href="#" data-bs-toggle="dropdown">
                                <i class="fa fa-circle-user"></i>
                            </a>
                            @auth
                            <div class="dropdown-menu">
                                <div class="dropdown-header">
                                    <p class="text-dark fs-16px fw-bold">Selamat Datang, {{ auth()->user()->nama }}</p>
                                    <p class="fs-14px mt-n3">Kelola Transaksi Anda.</p>
                                    <hr class="dropdown-divider">
                                </div>
                                <div class="dropdown-body mt-n3 mb-3 ">
                                    <a class="dropdown-item d-flex align-items-center" href="/dashboard">
                                        <i class="fa fa-tv me-3"></i>
                                        <span class="fw-bold">Dashboard</span>
                                    </a>
                                    <a class="dropdown-item d-flex align-items-center" href="/kasir">
                                        <i class="fa fa-cart-plus me-3"></i>
                                        <span class="fw-bold">Kasir</span>
                                    </a>
                                </div>
                                <div class="dropdown-footer mx-3">
                                    <form action="/logout" method="post">
                                        @csrf
                                        <button type="submit" class="btn btn-primary w-100 mb-2">
                                            <i class="fa fa-right-from-bracket me-2"></i>Log Out
                                        </button>
                                    </form>
                                </div>
                            </div>
                            @else
                            <div class="dropdown-menu">
                                <div class="dropdown-header">
                                    <p class="ms-2 text-dark fs-16px fw-bold">Selamat Datang di JO Computer</p>
                                    <p class="ms-2 fs-14px mt-n3">Akses Akun dan &amp; Kelola Transaksi</p>
                                    <hr class="dropdown-divider">
                                </div>
                                <div class="dropdown-footer mx-3 mt-n3">
                                <a href="/login" class="btn btn-primary w-100 mb-2">
                                    <i class="fa fa-right-to-bracket me-2"></i>Login</a>
                                </div>
                            </div>
                            @endauth
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Main Header --}}
{{--<div class="main-header">
      <div class="container-fluid container-xl">
        <div class="d-flex py-3 align-items-center justify-content-between">

          <!-- Logo -->
          <a href="index.html" class="logo d-flex align-items-center">
            <img class="me-2" width="70" height="70" src="assets/img/logo.svg" alt="logo-jocomputer">
            <h3 class="">Computer</h3>
          </a>

          <!-- Search -->
        <form class="bg-white border-radius-lg d-flex me-2" role="search">
            <input class="form-control border-0 ps-3" type="search" placeholder="Search" aria-label="Search"/>
            <button class="btn bg-gradient-primary my-1 me-1" type="submit">Search</button>
        </form>

          <!-- Actions -->
          <div class="header-actions d-flex align-items-center justify-content-end">

            <!-- Mobile Search Toggle -->
            <button class="header-action-btn mobile-search-toggle d-xl-none" type="button" data-bs-toggle="collapse" data-bs-target="#mobileSearch" aria-expanded="false" aria-controls="mobileSearch">
              <i class="fa fa-circle-user"> </i>
            </button>



            <!-- Wishlist -->
            <a href="account.html" class="header-action-btn d-none d-md-block">
              <i class="fa fa-heart"></i>
              <span class="badge">0</span>
            </a>
            <!-- Mobile Navigation Toggle -->
            <i class="mobile-nav-toggle d-xl-none fa fa-list me-0"></i>

                    </div>
                 </div>
             </div>
    </div>--}}



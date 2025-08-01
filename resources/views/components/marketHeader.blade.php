<header>
    {{-- top Bar --}}
    <div class="top-bar py-2">
        <div class="container-fluid container-xl">
            <div class="row align-items-center">
                {{-- Kolom Kontak --}}
                <div class="col-lg-4 d-none d-lg-flex">
                    <div class="me-3">
                        <i class="bi bi-whatsapp fs-14px text-black"></i>
                        <a class="fs-14px fw-bold text-black" href="https://wa.me/6281318000699">0813-1800-0699</a>
                    </div>
                    <div>
                        <i class="bi bi-envelope-fill fs-14px text-black"></i>
                        <a class="fs-14px fw-bold text-black" href="mailto:cs@jocomputer.com">cs@jocomputer.com</a>
                    </div>
                </div>

                {{-- Kolom Tengah (Kosong) --}}
                <div class="col-lg-4 col-md-12 text-center">
                </div>

                {{-- Kolom Akun Pengguna --}}
                <div class="col-lg-4 d-none d-lg-block">
                    <div class="d-flex justify-content-end">
                        <div class="dropdown">
                            @auth
                                {{-- Tampilan jika sudah login --}}
                                <a href="#" class="nav-link text-dark p-0" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    @if (auth()->user()->img_user)
                                        <img src="{{ asset('storage/' . auth()->user()->img_user) }}" alt="Profile" class="avatar avatar-sm rounded-circle cursor-pointer">
                                    @else
                                        {{-- Fallback jika tidak ada gambar profil --}}
                                        <i class="bi bi-person-circle cursor-pointer fs-4"></i>
                                    @endif
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end p-2" aria-labelledby="userDropdown">
                                    <li class="text-center px-2">
                                        <h6 class="mb-0">Selamat Datang,</h6>
                                        <p class="text-sm text-secondary">{{ auth()->user()->nama }}</p>
                                        <hr class="horizontal dark mt-2 mb-2">
                                    </li>
                                    <li>
                                        <a class="dropdown-item border-radius-md" href="{{ route('dashboard') }}">
                                            <i class="bi bi-tv me-2"></i> Dashboard
                                        </a>
                                    </li>
                                    <li>
                                        <form action="{{ route('logout') }}" method="post">
                                            @csrf
                                            <button type="submit" class="dropdown-item border-radius-md w-100 text-danger" style="text-align: left;">
                                                <i class="bi bi-box-arrow-right me-2"></i>Log Out
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            @else
                                {{-- Tampilan jika belum login --}}
                                <a href="#" class="nav-link text-dark p-0" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-person-circle cursor-pointer fs-4"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end p-2">
                                    <li class="text-center px-2 pb-1">
                                         <p class="fs-14px fw-bold">Anda belum login.</p>
                                        <a href="/login" class="btn btn-primary w-100">
                                            <i class="bi bi-box-arrow-in-right me-2"></i>Login
                                        </a>
                                    </li>
                                </ul>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Main Header (bisa Anda aktifkan nanti jika perlu) --}}
</header>

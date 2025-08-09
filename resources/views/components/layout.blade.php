<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/svg+xml" href="{{ asset('assets/img/logo.svg') }}">
    <link rel="alternate icon" href="{{ asset('favicon.ico') }}">
    <link rel="apple-touch-icon" href="{{ asset('assets/img/apple-touch-icon.png') }}">
    <title>Point Of Sales - JO Computer</title>
    @vite(['resources/scss/app.scss', 'resources/js/app.js','resources/js/argon-dashboard.min.js' ])
    @stack('styles')
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <script src="https://kit.fontawesome.com/939a218158.js" crossorigin="anonymous"></script>
    <script async defer src="https://buttons.github.io/buttons.js"></script>
</head>

<body class="g-sidenav-show bg-gray-100">
    <div style="height: 80px;" class="bg-gradient-blue position-absolute w-100"></div>
    <x-aside></x-aside>
    <main class="main-content position-relative border-radius-lg ">
        <nav class="navbar navbar-main navbar-expand-lg px-0 px-2 shadow-none border-radius-xl " id="navbarBlur" data-scroll="false">
            <div class="container-fluid py-0 px-3">
                @yield('breadcrumb')
                <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-4" id="navbar">
                    <div class="ms-md-auto pe-md-3 d-flex align-items-center"></div>
                    <ul class="navbar-nav justify-content-end">
                        <li class="nav-item d-xl-none me-2 d-flex align-items-center">
                            <a href="#" class="nav-link text-white p-0" id="iconNavbarSidenav">
                                <div class="sidenav-toggler-inner">
                                    <i class="sidenav-toggler-line bg-white"></i>
                                    <i class="sidenav-toggler-line bg-white"></i>
                                    <i class="sidenav-toggler-line bg-white"></i>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item dropdown d-flex align-items-center me-lg-2">
                            <a href="#notif" class="nav-link text-white me-n2 me-lg-0" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-bell-fill cursor-pointer"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end px-2 py-3" aria-labelledby="dropdownMenuButton">
                                <li>
                                    <a class="dropdown-item border-radius-md" href="#notif">
                                        <div class="d-flex py-1">
                                            <div class="my-auto"><img src="../assets/img/team-2.jpg" class="avatar avatar-sm me-3"></div>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="text-sm font-weight-normal mb-1">
                                                    <span class="font-weight-bold">New message</span> from Laur
                                                </h6>
                                                <p class="text-xs text-secondary mb-0"><i class="bi bi-clock-fill me-1"></i> 13 minutes ago</p>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item border-radius-md" href="#">
                                        <div class="d-flex py-1">
                                            <div class="my-auto"><img src="../assets/img/team-2.jpg" class="avatar avatar-sm me-3"></div>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="text-sm font-weight-normal mb-1">
                                                    <span class="font-weight-bold">New message</span> from Laur
                                                </h6>
                                                <p class="text-xs text-secondary mb-0"><i class="bi bi-clock-fill me-1"></i> 13 minutes ago</p>
                                            </div>
                                        </div>
                                    </a>
                                    <hr class="horizontal dark mt-2 mb-2">
                                </li>
                                <li>
                                    <a class="dropdown-item border-radius-md" href="/notifikasi">
                                        <h6 class="text-sm font-weight-normal mb-0">
                                            <span class="font-weight-bold">Notifikasi</span> Lainya
                                            <i class="bi bi-bold bi-chevron-double-right  ms-2"></i>
                                        </h6>

                                    </a>
                                </li>
                            </ul>
                        </li>
                        @auth
                        <li class="nav-item dropdown d-flex align-items-center">
                            <a href="#" class="nav-link text-white" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                @if (auth()->user()->img_user)
                                    <img src="{{ asset('storage/' . auth()->user()->img_user) }}" alt="Profile" class="avatar avatar-sm rounded-circle cursor-pointer">
                                @else
                                    <i class="bi bi-person-circle cursor-pointer fs-5"></i>
                                @endif
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end p-2" aria-labelledby="userDropdown">
                                <li class="text-center px-2">
                                    <h6 class="mb-0">Selamat Datang,</h6>
                                    <p class="text-sm text-secondary">{{ auth()->user()->nama }}</p>
                                    <hr class="horizontal dark mt-2 mb-2">
                                </li>
                                <li>
                                    <a class="dropdown-item border-radius-md" href="/">
                                        <i class="bi bi-shop me-2"></i> Web Market
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
                        </li>
                        @endauth
                    </ul>
                </div>
            </div>
        </nav>
        {{ $slot }}
    </main>
    @stack('scripts')
</body>
</html>

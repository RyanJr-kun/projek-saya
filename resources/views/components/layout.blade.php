<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="logo" sizes="100x100" href="../assets/img/logo.svg">
  <link rel="icon" type="image/svg" href="../assets/img/logo.svg">
  <title>Jo Computer Dashboard</title>
  @vite([
        'resources/scss/app.scss',
        'resources/js/app.js',
        'resources/js/core/popper.min.js',
        'resources/js/core/bootstrap.min.js',
        'resources/js/plugins/smooth-scrollbar.min.js',
        'resources/js/plugins/perfect-scrollbar.min.js',
        'resources/js/argon-dashboard.min.js'
    ])
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <script src="https://kit.fontawesome.com/939a218158.js" crossorigin="anonymous"></script>
  <script async defer src="https://buttons.github.io/buttons.js"></script>
</head>
<body class="g-sidenav-show bg-gray-100">
    <div class="min-height-300 bg-gradient-blue position-absolute w-100"></div>
    <x-aside></x-aside>
    <main class="main-content position-relative border-radius-lg ">
        <nav class="navbar navbar-main navbar-expand-lg px-0 px-2 shadow-none border-radius-xl " id="navbarBlur" data-scroll="false">
            <div class="container-fluid py-3 px-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-transparent mb-0 pb-0 py-1 px-0 me-sm-6 me-5">
                        <li class="breadcrumb-item text-sm"><a class="text-white" href="javascript:;">Pages</a></li>
                        <li class="breadcrumb-item text-sm text-white active" aria-current="page">{{ $title }}</li>
                    </ol>
                    <h6 class="font-weight-bolder text-white mb-0">{{ $title }}</h6>
                </nav>
                <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
                    <div class="ms-md-auto pe-md-3 d-flex align-items-center"></div>
                    <ul class="navbar-nav  justify-content-end">
                        <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
                            <a href="javascript:;" class="nav-link text-white p-0" id="iconNavbarSidenav">
                                <div class="sidenav-toggler-inner">
                                    <i class="sidenav-toggler-line bg-white"></i>
                                    <i class="sidenav-toggler-line bg-white"></i>
                                    <i class="sidenav-toggler-line bg-white"></i>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item px-3 d-flex align-items-center">
                            <a href="javascript:;" class="nav-link text-white p-0">
                                <i class="fa fa-cog fixed-plugin-button-nav cursor-pointer"></i>
                            </a>
                        </li>
                        <li class="nav-item dropdown pe-2 d-flex align-items-center">
                            <a href="javascript:;" class="nav-link text-white p-0" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa fa-bell cursor-pointer"></i>
                            </a>
                            <ul class="dropdown-menu  dropdown-menu-end  px-2 py-3 me-sm-n4" aria-labelledby="dropdownMenuButton">
                                <li class="mb-2">
                                    <a class="dropdown-item border-radius-md" href="javascript:;">
                                        <div class="d-flex py-1">
                                            <div class="my-auto"><img src="../assets/img/team-2.jpg" class="avatar avatar-sm  me-3 "></div>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="text-sm font-weight-normal mb-1">
                                                <span class="font-weight-bold">New message</span> from Laur
                                                </h6>
                                                <p class="text-xs text-secondary mb-0">
                                                <i class="fa fa-clock me-1"></i>
                                                13 minutes ago
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li class="mb-2">
                                    <a class="dropdown-item border-radius-md" href="javascript:;">
                                        <div class="d-flex py-1">
                                            <div class="my-auto"><img src="../assets/img/small-logos/logo-spotify.svg" class="avatar avatar-sm bg-gradient-dark  me-3 "></div>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="text-sm font-weight-normal mb-1"><span class="font-weight-bold">New album</span> by Travis Scott</h6>
                                                <p class="text-xs text-secondary mb-0"><i class="fa fa-clock me-1" info="Notifikasi"></i>1 day</p>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item d-flex ms-2 mb-n1 align-items-center">
                            <form action="/logout" method="post">
                                @csrf
                                <button type="submit" class="btn btn-outline-white w-100 mb-2"><i class="fa fa-right-from-bracket me-2"></i>Log Out</button>
                            </form>
                                {{-- <a href="javascript:;" class="nav-link active text-white font-weight-bold px-0">
                                    <i class="fa fa-right-from-bracket me-sm-1"></i><span class="d-sm-inline d-none">Log Out</span>
                                </a> --}}
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        {{ $slot }}
    </main>
</html>

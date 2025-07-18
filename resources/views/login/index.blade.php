<!DOCTYPE html>
    <html lang="en">
        <head>
            <meta charset="utf-8" />
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
            <link rel="logo" sizes="100x100" href="../assets/img/logo.svg">
            <link rel="icon" type="image/svg" href="../assets/img/logo.svg">
                <title>
                    Jo Computer Dashboard
                </title>
             @vite([
                    'resources/scss/app.scss',
                    'resources/js/app.js',
                    'resources/js/core/popper.min.js',
                    'resources/js/core/bootstrap.min.js',
                    'resources/js/plugins/perfect-scrollbar.min.js',
                    // 'resources/js/plugins/smooth-scrollbar.min.js',
                    // 'resources/js/argon-dashboard.min.js'
                ])
            <!--     Fonts and icons     -->
            <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
            <script src="https://kit.fontawesome.com/939a218158.js" crossorigin="anonymous"></script>
            <script async defer src="https://buttons.github.io/buttons.js"></script>
        </head>
    <body class="">
        <div class="container position-sticky z-index-sticky top-0">
            <div class="row">
            <div class="col-12">
                <!-- Navbar -->
                <nav class="navbar navbar-expand-lg blur border-radius-lg top-0 z-index-3 shadow position-absolute mt-4 py-2 start-0 end-0 mx-4">
                <div class="container-fluid">
                    <img src="../assets/img/logo.svg" width="30px" height="30px" class="navbar-brand-img h-100 me-3" alt="main_logo">
                    <h6><a class="navbar-brand font-weight-bolder ms-lg-0 ms-3 text-blue text-gradient-blue" href="/">
                    JO Computer
                    </a></h6>
                    <button class="navbar-toggler shadow-none ms-2" type="button" data-bs-toggle="collapse" data-bs-target="#navigation" aria-controls="navigation" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon mt-2">
                        <span class="navbar-toggler-bar bar1"></span>
                        <span class="navbar-toggler-bar bar2"></span>
                        <span class="navbar-toggler-bar bar3"></span>
                    </span>
                    </button>
                    <div class="collapse navbar-collapse" id="navigation">
                    <ul class="navbar-nav mx-auto">
                        <li class="nav-item">
                        <a class="nav-link d-flex align-items-center me-2 active" aria-current="page" href="/">
                            <i class="fa fa-chart-pie opacity-6 text-dark me-1"></i>
                            Beranda
                        </a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link me-2" href="/profile">
                            <i class="fa fa-user opacity-6 text-dark me-1"></i>
                            Profile
                        </a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link me-2" href="/toko">
                            <i class="fas fa-user-circle opacity-6 text-dark me-1"></i>
                            Market
                        </a>
                        </li>

                    </ul>

                    </div>
                </div>
                </nav>
                <!-- End Navbar -->
            </div>
            </div>
        </div>
        <main class="main-content  mt-0">
            <section>
            <div class="page-header min-vh-100">
                <div class="container">
                <div class="row">
                    <div class="col-xl-4 col-lg-5 col-md-7 d-flex flex-column mx-lg-0 mx-auto">
                    <div class="card card-plain">
                        @if (session()->has('loginError'))
                            <div class="alert alert-danger  alert-dismissible fade show" role="alert">
                                <span class="alert-icon"><i class="ni ni-like-2"></i></span>
                                {{ session('loginError') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                         @endif
                        <div class="card-header pb-0 text-start">
                        <h4 class="font-weight-bolder">Login</h4>
                        <p class="mb-0">masukan email dan password untuk login</p>
                        </div>
                        <div class="card-body">
                            {{-- setting auth --}}
                        <form role="form" action="/login" method="post">
                            @csrf
                            <div class="mb-3">
                            <input autocomplete="email" name="email" id="email" type="email" class="form-control form-control-lg @error('email') is-invalid @enderror" placeholder="Email" aria-label="Email" autofocus required>
                            @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            </div>
                            <div class="mb-3">
                            <input name="password" id="password" type="password" class="form-control form-control-lg" placeholder="Password" aria-label="Password" required>
                            </div>
                            <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="rememberMe">
                            <label class="form-check-label" for="rememberMe">Selalu Ingat Saya.</label>
                            </div>
                            <div class="text-center">
                            <button type="submit" class="btn btn-lg bg-gradient-blue text-white w-100 mt-4 mb-0" >Login</button>
                            </div>
                        </form>

                        </div>
                        <div class="card-footer text-center pt-0 px-lg-2 px-1">
                        <p class="mb-4 text-sm mx-auto">
                            Lupa Password?
                            <a href="javascript:;" class="text-blue font-weight-bold">Klik Disini.</a>
                        </p>
                        </div>
                    </div>
                    </div>
                    <div class="col-6 d-lg-flex d-none h-100 my-auto pe-0 position-absolute top-0 end-0 text-center justify-content-center flex-column">
                    <div class="position-relative bg-gradient-blue h-100 m-3 px-7 border-radius-lg d-flex flex-column justify-content-center overflow-hidden" >
                        <span class="mask bg-dark opacity-9 bg-gradient-blue"></span>
                        <h3 class="mt-5 text-white font-weight-bolder text-shadow-inherit position-relative">" Point Of Sales JO Computer "</h3>
                        <p class="text-white position-relative">Kelola data transaksi dan inventaris dengan lebih cepat dan akurat.</p>
                    </div>
                    </div>
                </div>
                </div>
            </div>
            </section>
        </main>
        <script>
            var win = navigator.platform.indexOf('Win') > -1;
            if (win && document.querySelector('#sidenav-scrollbar')) {
            var options = {
                damping: '0.5'
            }
            Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
            }
        </script>
    </body>
</html>

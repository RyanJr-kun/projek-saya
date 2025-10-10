<!DOCTYPE html>
    <html lang="id">
        <head>
            <meta charset="utf-8" />
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
            <meta name="csrf-token" content="{{ csrf_token() }}">
            <link rel="icon" type="image/svg+xml" href="{{ asset('assets/img/logo.svg') }}">
            <link rel="alternate icon" href="{{ asset('favicon.ico') }}">
            <link rel="apple-touch-icon" href="{{ asset('assets/img/apple-touch-icon.png') }}">
                <title>
                    Jo Computer - Login
                </title>
             @vite(['resources/scss/app.scss', 'resources/js/app.js'])
            <!--     Fonts and icons     -->
            <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
            <script src="https://kit.fontawesome.com/939a218158.js" crossorigin="anonymous"></script>
            <script async defer src="https://buttons.github.io/buttons.js"></script>
        </head>
    <body>
        <main class="main-content mt-0">
            <section>
                <div class="page-header min-vh-100">
                    <div class="container">
                        <div class="row">
                            <div class="col-xl-4 col-lg-5 col-md-7 d-flex flex-column mx-lg-0 mx-auto">
                                <div class="card card-plain">
                                    <div class="card-header pb-0 text-start">
                                        <h4 class="font-weight-bolder">Login</h4>
                                        <p class="mb-0">masukan email dan password untuk login</p>
                                        @if (session()->has('loginError'))
                                            <div class="alert badge badge-warning fade show text-warning text-xs px-3 mt-3 mb-n4" role="alert">
                                                {{ session('loginError') }}
                                                <button type="button" class="btn-close ms-3" data-bs-dismiss="alert" aria-label="Close">

                                                </button>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="card-body">
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
                                            <div class="text-center">
                                                <button type="submit" class="btn btn-lg btn-info w-100 mt-4 mb-0" >Login</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 d-lg-flex d-none h-100 my-auto pe-0 position-absolute top-0 end-0 text-center justify-content-center flex-column">
                                <div class="position-relative bg-gradient-blue h-100 m-3 px-7 border-radius-lg d-flex flex-column justify-content-center overflow-hidden" >
                                    <span class="mask bg-dark opacity-9 bg-gradient-blue"></span>
                                    <h3 class="mt-5 text-white font-weight-bolder text-shadow-inherit position-relative">
                                        " Point Of Sales JO Computer "
                                    </h3>
                                    <p class="text-white position-relative">Kelola data transaksi dan inventaris dengan lebih cepat dan akurat.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </body>
</html>

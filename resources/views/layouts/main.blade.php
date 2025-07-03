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
  <x-link></x-link>
</head>

<body class="g-sidenav-show bg-gray-100">
  <div class="min-height-300 bg-dark position-absolute w-100"></div>
  <x-aside></x-aside>
  <main class="main-content position-relative border-radius-lg ">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl " id="navbarBlur" data-scroll="false">
      <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-white" href="javascript:;">Pages</a></li>
            <li class="breadcrumb-item text-sm text-white active" aria-current="page">Dashboard</li>
          </ol>
          <h6 class="font-weight-bolder text-white mb-0">Dashboard</h6>
        </nav>
    <x-navbar></x-navbar>
     </div>
    </nav>
    <!-- End Navbar -->
    @yield('container')
  </main>
  <x-fixed-navbar></x-fixed-navbar>
  <x-corejs></x-corejs>
  @yield('corejs')
</body>
</html>

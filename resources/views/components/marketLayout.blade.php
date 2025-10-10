<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/svg+xml" href="{{ asset('assets/img/logo.svg') }}">
    <title>JO Computer - Marketplace</title>
    @vite([
        'resources/scss/app.scss',
        'resources/js/app.js',
    ])
    @stack('styles')
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <script src="https://kit.fontawesome.com/939a218158.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <script async defer src="https://buttons.github.io/buttons.js"></script>
</head>
<body>
    <x-marketHeader></x-marketHeader>
    {{ $slot }}
    <x-marketFooter></x-marketFooter>
    @stack('scripts')
</body>
</html>

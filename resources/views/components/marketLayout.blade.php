<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/img/apple-touch-icon.png') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/img/favicon-32x32.png') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/img/favicon-16x16.png') }}">
        <link rel="manifest" href="{{ asset('assets/img/site.webmanifest') }}">

        <title>Marketplace | JO Computer</title>
        @vite(['resources/scss/app.scss', 'resources/js/app.js'])
        @stack('styles')
        <!--     Fonts and icons     -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
        <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
        <script src="https://kit.fontawesome.com/939a218158.js" crossorigin="anonymous"></script>
        <script async defer src="https://buttons.github.io/buttons.js"></script>
    </head>
<body>
    <x-marketHeader></x-marketHeader>
    {{ $slot }}
    <x-marketFooter></x-marketFooter>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 800,
            once: true,
        });
    </script>
    @stack('scripts')
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    @vite([
        'resources/scss/app.scss',
        'resources/js/app.js',
        'resources/js/argon-dashboard.min.js'
    ])
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <script src="https://kit.fontawesome.com/939a218158.js" crossorigin="anonymous"></script>
    <script async defer src="https://buttons.github.io/buttons.js"></script>
</head>
<body>
    <x-market-header></x-market-header>
    <main>
        {{ $slot }}
    </main>
    <x-market-footer></x-market-footer>
</body>
</html>

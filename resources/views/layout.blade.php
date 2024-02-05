<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Agenda - {{ $pageTitle }}</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Barlow&display=swap" rel="stylesheet">

        <!-- Styles -->
        <link rel="stylesheet" href="/css/app.css">

        <!-- JS -->
        <script src="https://kit.fontawesome.com/a783aedd26.js" crossorigin="anonymous"></script>
        <script src="/js/jquery-3.7.1.js"></script>
        <script src="/js/scripts.js"></script>
    </head>

    <body>
        @include('components.nav')

        <main>
            @yield('main')
        </main>

        <footer>
        </footer>
    </body>

</html>

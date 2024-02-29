@props(['title' => 'Sem título'])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Agenda | {{ $title }}</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Barlow&display=swap" rel="stylesheet">

        <!-- Styles -->
        <link rel="stylesheet" href="/css/app.css">

        <!-- JS -->
        <script src="https://kit.fontawesome.com/a783aedd26.js" crossorigin="anonymous"></script>
        <script src="/js/jquery-3.7.1.js"></script>
        <script src="/js/helpers.js"></script>
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    </head>

    <body>
        <x-loading-bar />
        <x-flash />
        {{ $slot }}
    </body>

</html>

@props(['calendarView', 'date'])

@php
    $title = match ($calendarView) {
        'year' => 'Ano ' . $date->year,
        'month' => $date->translatedFormat('F \\d\\e Y'),
        'week' => 'Semana de ' . $date->translatedFormat('j \\d\\e F \\d\\e Y'),
        'day' => $date->translatedFormat('l, j \\d\\e F \\d\\e Y'),
    };
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Agenda - {{ $title }}</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Barlow&display=swap" rel="stylesheet">

        <!-- Styles -->
        <link rel="stylesheet" href="/css/app.css">

        <!-- JS -->
        <script src="https://kit.fontawesome.com/a783aedd26.js" crossorigin="anonymous"></script>
        <script src="/js/jquery-3.7.1.js"></script>
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
        <script src="/js/scripts.js"></script>
    </head>

    <body x-data="{
        search: '',
        items: null,
    
        get filteredItems() {
            var keys = Object.keys(this.items)
            var arr = keys.map((key) => this.items[key])
    
            console.log(this.items)
            console.log(arr)
    
            if (this.search === '') {
                return arr;
            }
    
            return arr.filter(
                i => {
                    return i.title.toLowerCase().includes(this.search.toLowerCase())
                }
            )
        }
    }">
        <x-nav :calendar-view="$calendarView" :date="$date" />
        <main>
            <x-flash />
            <x-events.form action="{{ route('users.events.store', ['user' => 1]) }}" />
            {{ $slot }}
        </main>
    </body>

</html>

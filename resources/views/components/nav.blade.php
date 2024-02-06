@props(['calendarView', 'date'])

<nav class="navbar">
    @php
        $title = match ($calendarView) {
            'year' => $date->year,
            'month' => ucfirst($date->translatedFormat('F \\d\\e Y')),
            'day' => $date->translatedFormat('j \\d\\e F \\d\\e Y'),
        };

        $previousDate = match ($calendarView) {
            'year' => $date->subYear(),
            'month' => $date->subMonth(),
            'day' => $date->subDay(),
        };

        $nextDate = match ($calendarView) {
            'year' => $date->addYear(),
            'month' => $date->addMonth(),
            'day' => $date->addDay(),
        };

        $today = CarbonImmutable::today();

        $display = request()->query('display');
    @endphp

    <a href="{{ Helpers::formatToCalendarUrl($calendarView, $today, $display) }}" class="btn btn-primary">Hoje</a>
    <a href="{{ Helpers::formatToCalendarUrl($calendarView, $previousDate, $display) }}" class="btn btn-icon"><i
            class="fa-solid fa-chevron-left"></i></a>
    <a href="{{ Helpers::formatToCalendarUrl($calendarView, $nextDate, $display) }}" class="btn btn-icon"><i
            class="fa-solid fa-chevron-right"></i></a>
    <h1 class="navbar-title">{{ $title }}</h1>
    <a href="{{ Helpers::formatToCalendarUrl('day', $date, $display) }}"
        class="btn {{ $calendarView == 'day' ? 'navbar-active' : null }}">Dia</a>
    <a href="{{ Helpers::formatToCalendarUrl('month', $date, $display) }}"
        class="btn {{ $calendarView == 'month' ? 'navbar-active' : null }}">Mês</a>
    <a href="{{ Helpers::formatToCalendarUrl('year', $date, $display) }}"
        class="btn {{ $calendarView == 'year' ? 'navbar-active' : null }}">Ano</a>
    @if (request()->query('display') == 'list')
        <a href="{{ Helpers::formatToCalendarUrl($calendarView, $date) }}" class="btn btn-icon"><i
                class="fa-solid fa-calendar-days"></i></a>
    @else
        <a href="{{ Helpers::formatToCalendarUrl($calendarView, $date, 'list') }}" class="btn btn-icon"><i
                class="fa-solid fa-list"></i></a>
    @endif
</nav>

<nav class="navbar">
    <a href="/{{ $view }}/{{ formatToCalendarUrl($today) }}" class="btn btn-save">Hoje</a>

    @php
        $previousDate = match ($view) {
            'year' => $date->subYear(),
            'month' => $date->subMonth(),
            'day' => $date->subDay(),
        };
        $nextDate = match ($view) {
            'year' => $date->addYear(),
            'month' => $date->addMonth(),
            'day' => $date->addDay(),
        };
    @endphp

    <a href="/{{ $view }}/{{ formatToCalendarUrl($previousDate) }}" class="btn btn-icon"><i
            class="fa-solid fa-chevron-left"></i></a>
    <a href="/{{ $view }}/{{ formatToCalendarUrl($nextDate) }}" class="btn btn-icon"><i
            class="fa-solid fa-chevron-right"></i></a>
    <h1 class="navbar-title">{{ $navTitle }}</h1>
    {{-- <a href="/day/{{ formatToCalendarUrl($date) }}" class="btn btn-icon"><i class="fa-solid fa-calendar-days"></i>Dia</a> --}}
    <a href="/day/{{ formatToCalendarUrl($date) }}" class="btn btn-icon {{ $view != 'day' ?: 'navbar-active' }}">Dia</a>
    <a href="/month/{{ formatToCalendarUrl($date) }}"
        class="btn btn-icon {{ $view != 'month' ?: 'navbar-active' }}">Mês</a>
    <a href="/year/{{ formatToCalendarUrl($date) }}"
        class="btn btn-icon {{ $view != 'year' ?: 'navbar-active' }}">Ano</a>
    <a href="/{{ $view }}/{{ formatToCalendarUrl($date) }}?display=list" class="btn btn-icon"><i
            class="fa-solid fa-list"></i>
        Lista</a>
</nav>

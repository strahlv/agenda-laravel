<nav class="navbar">
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

        $display = request()->query('display');
    @endphp

    <a href="{{ Helpers::formatToCalendarUrl($view, $today, $display) }}" class="btn btn-primary">Hoje</a>
    <a href="{{ Helpers::formatToCalendarUrl($view, $previousDate, $display) }}" class="btn btn-icon"><i
            class="fa-solid fa-chevron-left"></i></a>
    <a href="{{ Helpers::formatToCalendarUrl($view, $nextDate, $display) }}" class="btn btn-icon"><i
            class="fa-solid fa-chevron-right"></i></a>
    <h1 class="navbar-title">{{ $navTitle }}</h1>
    <a href="{{ Helpers::formatToCalendarUrl('day', $date, $display) }}"
        class="btn {{ $view == 'day' ? 'navbar-active' : null }}">Dia</a>
    <a href="{{ Helpers::formatToCalendarUrl('month', $date, $display) }}"
        class="btn {{ $view == 'month' ? 'navbar-active' : null }}">Mês</a>
    <a href="{{ Helpers::formatToCalendarUrl('year', $date, $display) }}"
        class="btn {{ $view == 'year' ? 'navbar-active' : null }}">Ano</a>
    @if (request()->query('display') == 'list')
        <a href="{{ Helpers::formatToCalendarUrl($view, $date) }}" class="btn btn-icon"><i
                class="fa-solid fa-calendar-days"></i></a>
    @else
        <a href="{{ Helpers::formatToCalendarUrl($view, $date, 'list') }}" class="btn btn-icon"><i
                class="fa-solid fa-list"></i></a>
    @endif
</nav>

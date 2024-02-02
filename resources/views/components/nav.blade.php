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

        $formattedDate = formatToCalendarUrl($date);
        $display = request()->query('display') == 'list' ? '?display=list' : null;
    @endphp

    <a href="/{{ $view }}/{{ formatToCalendarUrl($today) }}{{ $display }}" class="btn btn-save">Hoje</a>
    <a href="/{{ $view }}/{{ formatToCalendarUrl($previousDate) }}{{ $display }}" class="btn btn-icon"><i
            class="fa-solid fa-chevron-left"></i></a>
    <a href="/{{ $view }}/{{ formatToCalendarUrl($nextDate) }}{{ $display }}" class="btn btn-icon"><i
            class="fa-solid fa-chevron-right"></i></a>
    <h1 class="navbar-title">{{ $navTitle }}</h1>
    <a href="/day/{{ $formattedDate }}{{ $display }}"
        class="btn btn-icon {{ $view != 'day' ?: 'navbar-active' }}">Dia</a>
    <a href="/month/{{ $formattedDate }}{{ $display }}"
        class="btn btn-icon {{ $view != 'month' ?: 'navbar-active' }}">Mês</a>
    <a href="/year/{{ $formattedDate }}{{ $display }}"
        class="btn btn-icon {{ $view != 'year' ?: 'navbar-active' }}">Ano</a>
    @if (request()->query('display') == 'list')
        <a href="/{{ $view }}/{{ $formattedDate }}" class="btn btn-icon"><i
                class="fa-solid fa-calendar-days"></i></a>
    @else
        <a href="/{{ $view }}/{{ $formattedDate }}?display=list" class="btn btn-icon"><i
                class="fa-solid fa-list"></i></a>
    @endif
</nav>

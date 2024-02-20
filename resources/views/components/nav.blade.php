@props(['calendarView', 'date'])

<nav class="navbar">
    @php

        $previousDate = match ($calendarView) {
            'year' => $date->subYear(),
            'month' => $date->subMonth(),
            'week' => $date->subWeek(),
            'day' => $date->subDay(),
        };

        $nextDate = match ($calendarView) {
            'year' => $date->addYear(),
            'month' => $date->addMonth(),
            'week' => $date->addWeek(),
            'day' => $date->addDay(),
        };

        $today = CarbonImmutable::today();

        $display = request()->query('display');
    @endphp

    {{-- NAVEGAÇÃO --}}
    <a href="{{ Helpers::formatToCalendarUrl($calendarView, $today, $display) }}" class="btn btn-primary">Hoje</a>
    <a href="{{ Helpers::formatToCalendarUrl($calendarView, $previousDate, $display) }}" class="btn btn-icon"><i
            class="fa-solid fa-chevron-left"></i></a>
    <a href="{{ Helpers::formatToCalendarUrl($calendarView, $nextDate, $display) }}" class="btn btn-icon"><i
            class="fa-solid fa-chevron-right"></i></a>

    @php
        $title = match ($calendarView) {
            'year' => $date->year,
            'month' => ucfirst($date->translatedFormat('F \\d\\e Y')),
            'week' => ucfirst($date->translatedFormat('F \\d\\e Y')),
            'day' => $date->translatedFormat('j \\d\\e F \\d\\e Y'),
        };
    @endphp

    <h1 class="navbar-title">{{ $title }}</h1>

    {{-- PESQUISAR --}}
    <div class="search-bar" x-data="{ showClearButton: false }">
        <i class="fa-solid fa-search"></i>
        <input x-model="search" type="text" placeholder="Pesquisar eventos..."
            @input="showClearButton = search !== ''">
        <button class="btn btn-icon btn-clear" x-show="showClearButton" @click="search = ''; showClearButton = false"><i
                class="fa-solid fa-xmark"></i></button>
    </div>

    {{-- TROCAR VIEW --}}
    @php
        $dropdownTitle = match ($calendarView) {
            'year' => 'Ano',
            'month' => 'Mês',
            'week' => 'Semana',
            'day' => 'Dia',
        };
    @endphp

    <x-dropdown :title="$dropdownTitle">
        <x-slot name="trigger">
            <button class="btn btn-primary">{{ $dropdownTitle }}<i class="fa-solid fa-chevron-down"></i></button>
        </x-slot>

        <x-dropdown.nav-link :href="Helpers::formatToCalendarUrl('day', $date, $display)" :active="$calendarView == 'day'">Dia</x-dropdown.nav-link>
        <x-dropdown.nav-link :href="Helpers::formatToCalendarUrl('week', $date, $display)" :active="$calendarView == 'week'">Semana</x-dropdown.nav-link>
        <x-dropdown.nav-link :href="Helpers::formatToCalendarUrl('month', $date, $display)" :active="$calendarView == 'month'">Mês</x-dropdown.nav-link>
        <x-dropdown.nav-link :href="Helpers::formatToCalendarUrl('year', $date, $display)" :active="$calendarView == 'year'">Ano</x-dropdown.nav-link>
    </x-dropdown>

    {{-- TROCAR DISPLAY --}}
    @if (request()->query('display') == 'list')
        <a href="{{ Helpers::formatToCalendarUrl($calendarView, $date) }}" class="btn btn-icon"><i
                class="fa-solid fa-calendar-days"></i></a>
    @else
        <a href="{{ Helpers::formatToCalendarUrl($calendarView, $date, 'list') }}" class="btn btn-icon"><i
                class="fa-solid fa-list"></i></a>
    @endif

    {{-- LOGOUT --}}
    @auth
        <form method="POST" action="/logout">
            @csrf

            <button type="submit">Sair</button>
        </form>
    @endauth
</nav>

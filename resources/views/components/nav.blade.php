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

        $display = request()->query('display');
    @endphp

    {{-- Navegação --}}
    <a href="{{ Helpers::formatToCalendarUrl($calendarView, today(), $display) }}" class="btn btn-primary">Hoje</a>
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

    {{-- Pesquisar --}}
    @auth
        @php
            $search = request()->query('search');
        @endphp

        <form method="GET" action="{{ url()->current() }}" class="search-bar" x-data="{
            search: '{{ $search ?: '' }}',
            showClearButton: {{ $search != null ? 'true' : 'false' }}
        }">
            <i class="fa-solid fa-search"></i>
            <input type="hidden" name="display" value="{{ $display }}">
            <input x-model="search" type="text" placeholder="Pesquisar eventos..." name="search" id="search"
                ::value="search" @@input="showClearButton = search !== ''">
            <button type="reset" class="btn btn-icon btn-clear" x-show="showClearButton"
                @@click="search = ''; showClearButton = false"><i class="fa-solid fa-xmark"></i></button>
        </form>

        {{-- Trocar View --}}
        @php
            $dropdownTitle = match ($calendarView) {
                'year' => 'Ano',
                'month' => 'Mês',
                'week' => 'Semana',
                'day' => 'Dia',
            };
        @endphp

        <x-dropdown>
            <x-slot name="trigger">
                <button class="btn btn-primary btn-with-icon">{{ $dropdownTitle }}<i
                        class="fa-solid fa-angle-down"></i></button>
            </x-slot>

            <x-dropdown.nav-link :href="Helpers::formatToCalendarUrl('day', $date, $display)" :active="$calendarView == 'day'">Dia</x-dropdown.nav-link>
            <x-dropdown.nav-link :href="Helpers::formatToCalendarUrl('week', $date, $display)" :active="$calendarView == 'week'">Semana</x-dropdown.nav-link>
            <x-dropdown.nav-link :href="Helpers::formatToCalendarUrl('month', $date, $display)" :active="$calendarView == 'month'">Mês</x-dropdown.nav-link>
            <x-dropdown.nav-link :href="Helpers::formatToCalendarUrl('year', $date, $display)" :active="$calendarView == 'year'">Ano</x-dropdown.nav-link>
        </x-dropdown>

        {{-- Trocar Display --}}
        @if (request()->query('display') == 'list')
            <a href="{{ Helpers::formatToCalendarUrl($calendarView, $date) }}" class="btn btn-icon"><i
                    class="fa-solid fa-calendar-days"></i></a>
        @else
            <a href="{{ Helpers::formatToCalendarUrl($calendarView, $date, 'list') }}" class="btn btn-icon"><i
                    class="fa-solid fa-list"></i></a>
        @endif
    @endauth

    {{-- Notificações --}}
    <x-notification.list />

    {{-- Autenticação --}}
    @guest
        <a href="/login" class="btn btn-with-icon"><i class="fa-solid fa-sign-in"></i> Entrar</a>
    @endguest

    @auth
        <x-dropdown>
            <x-slot name="trigger">
                <button class="btn btn-icon"><i class="fa-solid fa-user"></i></button>
            </x-slot>

            <img src="/imgs/avatar.avif" alt="Foto de {{ auth()->user()->name }}" width="96" height="96"
                class="self-center" style="border-radius: 50%">

            <p class="greeting">Olá, {{ auth()->user()->name }}!</p>

            <a href="/settings" class="btn btn-with-icon justify-start"><i class="fa-solid fa-gear"></i> Configurações</a>

            <x-form method="POST" action="/logout" class="flex-col">
                <button type="submit" class="btn btn-with-icon justify-start"><i class="fa-solid fa-sign-out"></i>
                    Sair</button>
            </x-form>
        </x-dropdown>
    @endauth
</nav>

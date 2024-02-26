@props(['calendarView', 'date'])

@php
    $title = match ($calendarView) {
        'year' => 'Ano ' . $date->year,
        'month' => $date->translatedFormat('F \\d\\e Y'),
        'week' => 'Semana de ' . $date->translatedFormat('j \\d\\e F \\d\\e Y'),
        'day' => $date->translatedFormat('l, j \\d\\e F \\d\\e Y'),
    };
@endphp

<x-layout :calendar-view="$calendarView" :date="$date" :title="$title">
    <x-nav :calendar-view="$calendarView" :date="$date" />
    <main class="calendar-container">
        <x-events.form :action="route('users.events.store', ['user' => auth()->id() ?? -1])" />
        {{ $slot }}
    </main>
</x-layout>

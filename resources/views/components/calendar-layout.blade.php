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
        @php
            $method = $errors->get('method')[0] ?? null;
        @endphp

        <div id="event-sidebar" class="sidebar {{ !$errors->any() ? 'hidden' : '' }}" :class="{ 'hidden': !show }"
            x-data="{
                show: {{ !$errors->any() ? 'false' : 'true' }},
                showContentType: '{{ $method === 'POST' ? 'create' : ($method === 'PATCH' ? 'edit' : 'none') }}',
                data: {},
                url: '/',
            }"
            @@show-event.window="showContentType = 'show'; show = true; data = $event.detail.data; console.log($event.detail)"
            @@create-event.window="showContentType = 'create'; show = true; data = $event.detail.data; url = $event.detail.url; console.log($event.detail)"
            @@edit-event.window="showContentType = 'edit'; show = true; data = $event.detail.data; url = $event.detail.url; console.log($event.detail)">
            <button type="button" class="btn btn-icon self-end" @@click="show = false"><i
                    class="fa-solid fa-xmark"></i></button>

            <x-events.show />

            <x-events.form id="create-event" method="POST" :action="route('users.events.store', ['user' => auth()->id() ?? -1])" x-show="showContentType === 'create'"
                @create-event.window="showCreateForm(data.date, data.time, data.isAllDay, url)" />

            <x-events.form id="edit-event" title="Editar evento" method="PATCH" x-show="showContentType === 'edit'"
                @edit-event.window="showEditForm(data, url)" />
        </div>
        {{ $slot }}
    </main>
</x-layout>

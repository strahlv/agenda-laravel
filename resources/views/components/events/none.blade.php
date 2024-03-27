@props(['date'])

<div class="no-events">
    <p>Nenhum evento encontrado.</p>

    @php
        $storeRoute = route('users.events.store', ['user' => auth()->user()->id ?? -1]);
    @endphp

    <button type="button" class="btn btn-primary" x-data
        @@click="$dispatch('create-event', { data: { date: '{{ $date->format('Y-m-d') }}', time: '{{ $date->format('H:i') }}', isAllDay: true }, url: '{{ $storeRoute }}' })">Criar
        evento</button>
</div>

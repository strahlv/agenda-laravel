@props(['date'])

<div class="no-events">
    <p>Nenhum evento encontrado.</p>

    @php
        $storeRoute = route('users.events.store', ['user' => auth()->user()->id ?? -1]);
    @endphp

    <button type="button" class="btn btn-primary"
        onclick="showCreateForm('{{ $date->format('Y-m-d') }}','{{ $date->format('H:i') }}', true, '{{ $storeRoute }}')">Criar
        evento</button>
</div>

@props(['method' => 'POST', 'action' => '/', 'id', 'title' => 'Criar evento'])

<x-form :id="$id" :method="$errors->get('method')[0] ?? $method" :action="$errors->get('action')[0] ?? $action" class="event-form" {{ $attributes }}>
    @php
        $isAllDay = !$errors->any() || old('is_all_day');
    @endphp

    <h1 id="form-title">{{ $title }}</h1>

    <x-input type="text" name="title" label="Título" />

    <div class="flex-row gap-10">
        <x-input type="date" name="start_date" label="Início" />
        <div id="end-date-control" @class(['flex-col', 'flex-1', 'hidden' => !$isAllDay])>
            <x-input type="date" name="end_date" label="Fim" />
        </div>
    </div>

    <div @class(['flex-col', 'hidden' => $isAllDay]) id="time-control">
        <div class="flex-row gap-10 align-end">
            <x-input.time name="start_time" label="de" />
            <x-input.time name="end_time" label="até"
                onchange="updateEndTimeConstraints(event, '#{{ $id }}')" />
        </div>
        <x-form-error error="start_time" />
        <x-form-error error="end_time" />
    </div>

    <x-input.checkbox name="is_all_day" label="O dia todo" :checked="$isAllDay"
        onchange="toggleTimeInputs('#{{ $id }}')" />

    <x-input.user-picker name="participants" label="Convidar participantes" placeholder="E-mail do convidado..." />

    <button type="submit" id="submit-button" class="btn btn-primary btn-save">Salvar</button>
</x-form>

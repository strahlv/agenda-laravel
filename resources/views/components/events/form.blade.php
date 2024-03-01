@props(['method' => 'POST', 'action' => '/', 'title' => 'Criar evento'])

@php
    $spoofMethod = '';
    $method = Str::of($method)->upper();
    if ($method == 'PUT' || $method == 'PATCH' || $method == 'DELETE') {
        $spoofMethod = $method;
        $method = 'POST';
    }
@endphp

<form method="{{ $method }}" action="{{ $errors->get('action')[0] ?? $action }}" @class(['event-form', 'hidden' => !$errors->any()])
    onsubmit="onSubmitForm(event)">
    @csrf
    @method($errors->get('method')[0] ?? $spoofMethod)

    @php
        $isAllDay = !$errors->any() || old('is_all_day');
    @endphp

    <div class="form-header">
        {{-- TODO: Deixar mais elegante --}}
        <h1 id="form-title">{{ !$errors->any() || $errors->get('method')[0] == 'POST' ? $title : 'Editar evento' }}</h1>
        <button type="button" class="btn btn-icon" onclick="hideForm()"><i class="fa-solid fa-xmark"></i></button>
    </div>

    <x-input type="text" name="title" label="Título" />
    <x-input type="date" name="start_date" label="Início" />
    <div id="end-date-control" @class(['flex-col', 'hidden' => !$isAllDay])>
        <x-input type="date" name="end_date" label="Fim" />
    </div>

    <div @class(['flex-col', 'hidden' => $isAllDay]) id="time-control">
        <div class="flex-row gap-10 align-end">
            <x-input.time name="start_time" label="de" />
            <x-input.time name="end_time" label="até" onchange="updateEndTimeConstraints(event)" />
        </div>
        <x-form-error error="start_time" />
        <x-form-error error="end_time" />
    </div>

    <x-input.checkbox name="is_all_day" label="Dia inteiro" :checked="$isAllDay" onchange="toggleTimeInputs()" />

    <x-input.array name="participants" label="Participantes" />

    <button type="submit" id="submit-button" class="btn btn-primary btn-save">Salvar</button>
</form>

@props(['method' => 'POST', 'title' => 'Criar evento'])

@php
    $spoofMethod = '';
    $method = Str::of($method)->upper();
    if ($method == 'PUT' || $method == 'PATCH' || $method == 'DELETE') {
        $spoofMethod = $method;
        $method = 'POST';
    }
@endphp

{{-- <form {{ $attributes }} method="{{ $method }}" @class(['event-form', 'hidden' => !$errors->any()]) --}}
<form {{ $attributes }} method="{{ $method }}" @class(['event-form', 'hidden' => false])
    @submit="document.getElementById('submit-button').disabled = true">
    @csrf
    @method($spoofMethod)

    <div class="form-header">
        <h1 id="form-title">{{ $title }}</h1>
        <button type="button" class="btn btn-icon" onclick="hideForm()"><i class="fa-solid fa-xmark"></i></button>
    </div>
    <div class="flex-col">
        <label for="title" class="form-label">Título</label>
        <input type="text" name="title" id="title" value="{{ old('title') }}">
        @error('title')
            {{-- TODO:
                * estilo css 
                * tradução da msg
            --}}
            <p style="color: red">{{ $message }}</p>
        @enderror
    </div>
    <div class="flex-col">
        <label for="start-date" class="form-label">Início</label>
        <input type="date" name="start_date" id="start-date" value="{{ old('start_date') }}">
        @error('start_date')
            {{-- TODO:
                    * estilo css 
                    * tradução da msg
                --}}
            <p style="color: red">{{ $message }}</p>
        @enderror
    </div>
    <div class="flex-col" id="end-date-control">
        <label for="end-date" class="form-label">Fim</label>
        <input type="date" name="end_date" id="end-date" value="{{ old('end_date') }}">
        @error('end_date')
            {{-- TODO:
                    * estilo css 
                    * tradução da msg
                --}}
            <p style="color: red">{{ $message }}</p>
        @enderror
    </div>
    <div class="flex-row gap-10 align-end hidden" id="time-control">
        <div class="flex-col flex-auto">
            <label for="start-time" class="form-label">Início</label>
            <input type="time" name="start_time" id="start-time" value="{{ old('start_time') }}"
                onchange="updateEndTimeConstraints(event)">
            @error('start_time')
                {{-- TODO:
                * estilo css 
                * tradução da msg
                --}}
                <p style="color: red">{{ $message }}</p>
            @enderror
        </div>
        <span>às</span>
        <div class="flex-col flex-auto">
            <label for="end-time" class="form-label">Fim</label>
            <input type="time" name="end_time" id="end-time" value="{{ old('end_time') }}">
            @error('end_time')
                {{-- TODO:
                    * estilo css 
                    * tradução da msg
                    --}}
                <p style="color: red">{{ $message }}</p>
            @enderror
        </div>
    </div>
    <div class="flex-row">
        <label for="is-all-day">
            <input type="checkbox" checked name="is_all_day" id="is-all-day" onchange="toggleTimeInputs()">
            <span>Dia inteiro</span>
        </label>
        @error('is_all_day')
            {{-- TODO:
                    * estilo css 
                    * tradução da msg
                    --}}
            <p style="color: red">{{ $message }}</p>
        @enderror
    </div>
    <div class="flex-col"></div>
    <button type="submit" id="submit-button" class="btn btn-primary btn-save">Salvar</button>
</form>

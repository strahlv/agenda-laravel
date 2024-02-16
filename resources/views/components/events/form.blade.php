@props(['method' => 'POST', 'title' => 'Criar evento'])

@php
    $spoofMethod = '';
    $method = Str::of($method)->upper();
    if ($method == 'PUT' || $method == 'PATCH' || $method == 'DELETE') {
        $spoofMethod = $method;
        $method = 'POST';
    }
@endphp

<form {{ $attributes }} method="{{ $method }}" @class(['event-form', 'hidden' => !$errors->any()])
    @submit="document.getElementById('submit-button').disabled = true">
    @csrf
    @method($spoofMethod)

    <div class="form-header">
        <h1 id="form-title">{{ $title }}</h1>
        <button type="button" class="btn btn-icon" onclick="hideForm()"><i class="fa-solid fa-xmark"></i></button>
    </div>
    <div class="form-control">
        <label for="title">Título</label>
        <input type="text" name="title" id="title" value="{{ old('title') }}">
        @error('title')
            {{-- TODO:
                * estilo css 
                * tradução da msg
            --}}
            <p style="color: red">{{ $message }}</p>
        @enderror
    </div>
    <div class="form-control">
        <label for="start-date">Início</label>
        <input type="date" name="start_date" id="start-date" value="{{ old('date') }}">
        @error('start_date')
            {{-- TODO:
                * estilo css 
                * tradução da msg
            --}}
            <p style="color: red">{{ $message }}</p>
        @enderror
    </div>
    <div class="form-control">
        <label for="end-date">Fim</label>
        <input type="date" name="end_date" id="end-date" value="{{ old('date') }}">
        @error('end_date')
            {{-- TODO:
                * estilo css 
                * tradução da msg
            --}}
            <p style="color: red">{{ $message }}</p>
        @enderror
    </div>
    <button type="submit" id="submit-button" class="btn btn-primary btn-save">Salvar</button>
</form>

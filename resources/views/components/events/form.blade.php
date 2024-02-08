@props(['method' => 'POST', 'title' => 'Criar evento'])

@php
    $spoofMethod = '';
    $method = Str::of($method)->upper();
    if ($method == 'PUT' || $method == 'PATCH' || $method == 'DELETE') {
        $spoofMethod = $method;
        $method = 'POST';
    }
@endphp

<form {{ $attributes }} method="{{ $method }}" class="event-form"
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
        <label for="date">Data</label>
        <input type="date" name="date" id="date" value="{{ old('date') }}">
        @error('date')
            {{-- TODO:
                * estilo css 
                * tradução da msg
            --}}
            <p style="color: red">{{ $message }}</p>
        @enderror
    </div>
    <button type="submit" id="submit-button" class="btn btn-primary btn-save">Salvar</button>
</form>

@props(['method' => 'POST', 'title' => 'Criar evento'])

@php
    $spoofMethod = '';
    $method = Str::of($method)->upper();
    if ($method == 'PUT' || $method == 'PATCH' || $method == 'DELETE') {
        $spoofMethod = $method;
        $method = 'POST';
    }
@endphp

<form {{ $attributes }} method="{{ $method }}" class="form-create-event"
    onsubmit="document.querySelector('#submit-button').disabled = true">
    @csrf
    @method($method)

    <div class="form-header">
        <h1 id="form-title">{{ $title }}</h1>
        <button type="button" class="btn btn-icon" onclick="hideForm()"><i class="fa-solid fa-xmark"></i></button>
    </div>
    <div class="form-control">
        <label for="title">Título</label>
        <input type="text" name="title" id="title" value="{{ old('title') }}">
    </div>
    <div class="form-control">
        <label for="date">Data</label>
        <input type="date" name="date" id="date">
    </div>
    {{-- VALIDAR INPUTS!!! --}}
    @if ($errors->any())
        {{ ddd($errors->all()) }}
    @endif
    @error('title')
        <h1>erro</h1>
        <h1>{{ $message }}</h1>
    @enderror
    <button type="submit" id="submit-button" class="btn btn-primary btn-save">Salvar</button>
</form>

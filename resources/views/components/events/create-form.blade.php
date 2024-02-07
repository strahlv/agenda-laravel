@props(['method' => 'POST', 'title' => 'Criar evento'])

<form action={{ $attributes['action'] }} method="POST" class="form-create-event hidden"
    onsubmit="document.querySelector('#submit-button').disabled = true">
    @csrf
    @method($method)

    <div class="form-header">
        <h1>{{ $title }}</h1>
        <button type="button" class="btn btn-icon" onclick="hideForm()"><i class="fa-solid fa-xmark"></i></button>
    </div>
    <div class="form-control">
        <label for="title">Título</label>
        <input type="text" name="title" id="title">
    </div>
    <div class="form-control">
        <label for="title">Data</label>
        <input type="date" name="date" id="date">
    </div>
    {{-- VALIDAR INPUTS!!! --}}
    <button type="submit" id="submit-button" class="btn btn-primary btn-save">Salvar</button>
</form>

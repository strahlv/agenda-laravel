@props(['formAction' => '/'])

<form action={{ $formAction }} class="form-create-event hidden">
    @csrf

    <div class="form-header">
        <h1>Criar evento </h1>
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
    <button type="submit" class="btn btn-primary btn-save">Salvar</button>
</form>

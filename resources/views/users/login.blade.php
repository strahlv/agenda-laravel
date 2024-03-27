{{-- !TODO: consertar css --}}
<x-layout title="Entrar">
    <main>
        <form method="POST" action="/login" class="event-form" onsubmit="onSubmitForm(event)">
            @csrf

            <h1>Entrar</h1>

            <x-input type="email" name="email" label="E-mail" />
            <x-input.password name="password" label="Senha" />

            <button type="submit" id="submit-button" class="btn btn-primary">Entrar</button>
            <p>Não possui uma conta? <a href="/register">Cadastrar</a></p>
        </form>
    </main>
</x-layout>

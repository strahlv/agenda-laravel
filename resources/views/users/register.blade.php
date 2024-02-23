<x-layout title="Cadastrar">
    <main>
        <form method="POST" action="/register" class="event-form" @@submit="disableSubmitButton(event)">
            @csrf

            <h1>Cadastrar</h1>

            <x-input type="text" name="name" label="Nome" />
            <x-input type="email" name="email" label="E-mail" />
            <x-input type="password" name="password" label="Senha" />
            <x-input type="password" name="password_confirmation" label="Confirmar senha" />

            <button type="submit" class="btn btn-primary"
                @@click="disableSubmitButton(event)">Cadastrar</button>
            <p>Já possui uma conta? <a href="/login">Entrar</a></p>
        </form>
    </main>
</x-layout>

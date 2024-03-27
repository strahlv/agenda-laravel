<x-layout title="Cadastrar">
    <main>
        <x-form method="POST" action="/register" class="form">
            <h1>Cadastrar</h1>

            <x-input type="text" name="name" label="Nome" />
            <x-input type="email" name="email" label="E-mail" />
            <x-input.password name="password" label="Senha" />
            <x-input.password name="password_confirmation" label="Confirmar senha" />

            <button type="submit" class="btn btn-primary">Cadastrar</button>
            <p>Já possui uma conta? <a href="/login">Entrar</a></p>
        </x-form>
    </main>
</x-layout>

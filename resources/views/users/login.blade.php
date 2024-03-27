<x-layout title="Entrar">
    <main>
        <x-form method="POST" action="/login" class="form">
            <h1>Entrar</h1>

            <x-input type="email" name="email" label="E-mail" />
            <x-input.password name="password" label="Senha" />

            <button type="submit" id="submit-button" class="btn btn-primary">Entrar</button>
            <p>Não possui uma conta? <a href="/register">Cadastrar</a></p>
        </x-form>
    </main>
</x-layout>

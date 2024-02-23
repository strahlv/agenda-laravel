<x-layout title="Configurações">
    <main>
        <x-flash />
        <nav class="navbar">
            <a href="/" class="btn btn-icon"><i class="fa-solid fa-chevron-left"></i></a>
            <h1 class="navbar-title">Configurações</h1>
        </nav>
        <section>
            <form method="POST" action="/settings" class="event-form">
                @csrf
                @method('PATCH')

                @php
                    $user = auth()->user();
                @endphp

                <h1>Dados do usuário</h1>

                <x-input type="text" name="name" label="Nome" placeholder="{{ $user->name }}" />
                <x-input type="email" name="email" label="E-mail" placeholder="{{ $user->email }}" />
                <x-input type="password" name="password" label="Senha" />
                <x-input type="password" name="password_confirmation" label="Confirmar senha" />

                <button type="submit" class="btn btn-primary btn-save">Salvar</button>
            </form>
        </section>
        <section>
            <form method="POST" action="/" class="event-form">
                @csrf
                @method('PATCH')

                <h1>Configurações do calendário</h1>

                <x-input.checkbox name="week_starts_monday" label="Semana começando na segunda-feira" />
                <x-input.checkbox name="year_starts_day_one" label="Ano começando dia primeiro" :checked="false" />
                <x-input.checkbox name="hide_holidays" label="Mostrar feriados" :checked="true" />

                <button type="submit" class="btn btn-primary btn-save">Salvar</button>
            </form>
        </section>
    </main>
</x-layout>

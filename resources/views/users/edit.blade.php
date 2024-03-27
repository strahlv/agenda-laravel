<x-layout title="Configurações">
    <main>
        <x-flash />
        <nav class="navbar">
            <a href="/" class="btn btn-icon"><i class="fa-solid fa-chevron-left"></i></a>
            <h1 class="navbar-title">Configurações</h1>
        </nav>
        <section>
            <x-form method="PATCH" action="/user" class="form">
                @php
                    $user = auth()->user();
                @endphp

                <h1>Dados do usuário</h1>

                <x-input type="text" name="name" label="Nome" placeholder="{{ $user->name }}" />
                <x-input type="email" name="email" label="E-mail" placeholder="{{ $user->email }}" />
                <x-input.password name="password" label="Senha" />
                <x-input.password name="password_confirmation" label="Confirmar senha" />

                <button type="submit" class="btn btn-primary btn-save">Salvar</button>
            </x-form>
        </section>
        <section>
            <x-form method="PATCH" action="/settings" class="form">
                @php
                    $settings = auth()->user()->settings;
                @endphp

                <h1>Configurações do calendário</h1>

                <x-input.checkbox name="week_starts_monday" label="Semana começando na segunda-feira"
                    :checked="$settings->week_starts_monday" />
                <x-input.checkbox name="year_starts_day_one" label="Ano começando dia primeiro" :checked="$settings->year_starts_day_one" />
                <x-input.checkbox name="show_holidays" label="Mostrar feriados" :checked="$settings->show_holidays" />

                <button type="submit" class="btn btn-primary btn-save">Salvar</button>
            </x-form>
        </section>
    </main>
</x-layout>

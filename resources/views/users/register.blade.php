<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Cadastrar usuário</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Barlow&display=swap" rel="stylesheet">

        <!-- Styles -->
        <link rel="stylesheet" href="/css/app.css">

        <!-- JS -->
        <script src="https://kit.fontawesome.com/a783aedd26.js" crossorigin="anonymous"></script>
        <script src="/js/jquery-3.7.1.js"></script>
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
        <script src="/js/scripts.js"></script>
    </head>

    <body>
        <main>
            <form method="POST" action="/register" class="event-form">
                @csrf

                <h1>Cadastrar</h1>
                <div class="flex-col">
                    <label for="name" class="form-label">Nome</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}">
                    @error('name')
                        {{-- TODO:
                            * estilo css 
                            * tradução da msg
                        --}}
                        <p style="color: red">{{ $message }}</p>
                    @enderror
                </div>
                <div class="flex-col">
                    <label for="email" class="form-label">E-mail</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}">
                    @error('email')
                        {{-- TODO:
                            * estilo css 
                            * tradução da msg
                        --}}
                        <p style="color:
                        red">{{ $message }}</p>
                    @enderror
                </div>
                <div class="flex-col">
                    <label for="password" class="form-label">Senha</label>
                    <input type="password" name="password" id="password">
                    @error('password')
                        {{-- TODO:
                            * estilo css 
                            * tradução da msg
                        --}}
                        <p style="color: red">{{ $message }}</p>
                    @enderror
                </div>
                <div class="flex-col">
                    <label for="password-confirm" class="form-label">Confirmar senha</label>
                    <input type="password" name="password_confirmation" id="password-confirmation">
                    @error('password_confirmation')
                        {{-- TODO:
                            * estilo css 
                            * tradução da msg
                        --}}
                        <p style="color: red">{{ $message }}</p>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Cadastrar</button>
                <p>Já possui uma conta? <a href="/login">Entrar</a></p>
            </form>
        </main>
    </body>

</html>

<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <title>Вход в систему</title>
</head>
<body>

<main>
    <div class="login">
        <div class="login__wrapper">
            <div class="login__title-wrapper">
                <x-logo mod="lg"/>

                <h1 class="login__title">ГеоКонтроль</h1>
                <div class="login__description">Система учёта геодезического оборудования</div>
            </div>

            <form action="{{ route('login') }}" method="post" class="login__form">
                @csrf

                <div class="login__form-title-wrapper">
                    <h2 class="login__form-title">Вход в систему</h2>
                    <div class="login__form-subtitle">Введите ваши учётные данные</div>
                </div>

                <div class="input-wrapper">
                    <label for="login">Логин</label>
                    <input type="text" name="login" id="login" placeholder="Введите ваш логин"
                           value="{{ old('login') }}" @class(['invalid' => $errors->has('login') || $errors->has('auth')])>

                    @error('login')
                    <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="input-wrapper">
                    <label for="password">Пароль</label>
                    <input type="password" name="password" id="password"
                           placeholder="Введите ваш пароль" @class(['invalid' => $errors->has('password') || $errors->has('auth')])>

                    @error('password')
                    <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="login__btn btn btn--primary">Войти</button>

                @error('auth')
                <div class="error">{{ $message }}</div>
                @enderror
            </form>

            <div class="login__copyright">© 2026 ГеоКонтроль. Все права защищены.</div>
        </div>
    </div>
</main>

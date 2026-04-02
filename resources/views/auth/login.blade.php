@extends('theme')
@section('title', 'Вход в систему')
@section('content')
    <div class="login-form">
        <div class="login-form__wrapper">
            <div class="login-form__title-wrapper">
                @include('components.logo', ['class' => 'login-form__logo'])

                <h1 class="login-form__title">ГеоКонтроль</h1>
                <div class="login-form__description">Система учёта геодезического оборудования</div>
            </div>

            <form action="{{ route('login') }}" method="post" class="login-form__form">
                @csrf

                <div class="login-form__form-title-wrapper">
                    <h2 class="login-form__form-title">Вход в систему</h2>
                    <div class="login-form__form-subtitle">Введите ваши учётные данные</div>
                </div>

                <div class="input-wrapper">
                    <label for="login">Логин</label>
                    <input type="text" name="login" id="login" placeholder="Введите ваш логин"
                           value="{{ old('login') }}" @class(['invalid' => $errors->has('login')])>

                    @error('login')
                    <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="input-wrapper">
                    <label for="password">Пароль</label>
                    <input type="password" name="password" id="password"
                           placeholder="Введите ваш пароль" @class(['invalid' => $errors->has('password')])>

                    @error('password')
                    <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="login-form__btn btn btn--primary">Войти</button>

                @error('auth')
                <div class="error">{{ $message }}</div>
                @enderror
            </form>

            <div class="login-form__copyright">© 2026 ГеоКонтроль. Все права защищены.</div>
        </div>
    </div>
@endsection

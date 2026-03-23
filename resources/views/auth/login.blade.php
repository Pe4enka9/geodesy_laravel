@extends('theme')
@section('title', 'Авторизация')
@section('content')
    <form action="{{ route('login') }}" method="post">
        @csrf
        <h1>Авторизация</h1>

        <div>
            <label for="login">Логин</label>
            <input type="text" name="login" id="login" placeholder="Введите ваш логин" value="{{ old('login') }}">

            @error('login')
            <div>{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="password">Пароль</label>
            <input type="password" name="password" id="password" placeholder="Введите ваш пароль">

            @error('password')
            <div>{{ $message }}</div>
            @enderror
        </div>

        <button type="submit">Войти</button>

        @error('auth')
        <div>{{ $message }}</div>
        @enderror
    </form>
@endsection

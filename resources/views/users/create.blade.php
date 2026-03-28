@use(App\Models\Users\Enums\UserPositionEnum, Position)
@extends('theme')
@section('title', 'Добавить сотрудника')
@section('content')
    <form action="{{ route('users.store') }}" method="post">
        @csrf
        <h1>Добавить сотрудника</h1>

        <div>
            <label for="name">Имя</label>
            <input type="text" name="name" id="name" placeholder="Иван Иванов" value="{{ old('name') }}">

            @error('name')
            <div>{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="login">Логин</label>
            <input type="text" name="login" id="login" placeholder="ivanov" value="{{ old('login') }}">

            @error('login')
            <div>{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="role">Роль</label>
            <select name="role" id="role">
                <option value="" hidden>Выберите роль</option>
                @foreach($roles as $role)
                    <option
                        value="{{ $role }}"
                        @selected(old('role') == $role->value)
                    >
                        {{ $role->label() }}
                    </option>
                @endforeach
            </select>

            @error('role')
            <div>{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="position">Должность</label>
            <select name="position" id="position">
                <option value="">Выберите должность</option>
                @foreach(Position::cases() as $position)
                    <option
                        value="{{ $position }}"
                        @selected(old('position') == $position->value)
                    >
                        {{ $position->label() }}
                    </option>
                @endforeach
            </select>

            @error('position')
            <div>{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="password">Пароль</label>
            <input type="password" name="password" id="password" placeholder="******">

            @error('password')
            <div>{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="password_confirmation">Повтор пароля</label>
            <input type="password" name="password_confirmation" id="password_confirmation" placeholder="******">
        </div>

        <button type="submit">Добавить</button>
    </form>
@endsection

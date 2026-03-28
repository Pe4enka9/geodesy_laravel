@use(App\Models\Users\Enums\UserPositionEnum,Position)
@use(App\Models\Users\Enums\UserRoleEnum, Role)
@extends('theme')
@section('title', 'Изменить сотрудника')
@section('content')
    <form action="{{ route('users.update', $user) }}" method="post">
        @csrf
        @method('PATCH')
        <h1>Изменить сотрудника</h1>

        <div>
            <label for="name">Имя</label>
            <input type="text" name="name" id="name" placeholder="Иван Иванов" value="{{ old('name', $user->name) }}">

            @error('name')
            <div>{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="login">Логин</label>
            <input type="text" name="login" id="login" placeholder="ivanov" value="{{ old('login', $user->login) }}">

            @error('login')
            <div>{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="role">Роль</label>
            <select name="role" id="role">
                <option value="" hidden>Выберите роль</option>
                @foreach(Role::cases() as $role)
                    <option
                        value="{{ $role }}"
                        @selected(old('role', $user->role->value) == $role->value)
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
                        @selected(old('position', $user->position?->value) == $position->value)
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

        <button type="submit">Изменить</button>
    </form>
@endsection

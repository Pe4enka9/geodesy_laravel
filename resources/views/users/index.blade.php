@extends('theme')
@section('title', 'Персонал')
@section('content')
    <h1>Персонал</h1>
    <a href="{{ route('users.create') }}">Добавить</a>

    <div style="display:flex; flex-direction: column; gap: 10px">
        @forelse($users as $user)
            <div style="background-color: #fff;border: 1px solid #000;">
                <div>{{ $user->name }} ({{ $user->login }})</div>
                <div>{{ $user->role->label() }}</div>

                @isset($user->position)
                    <div>{{ $user->position->label() }}</div>
                @endisset

                <a href="{{ route('users.edit', $user) }}">Редактировать</a>
                <form action="{{ route('users.destroy', $user) }}" method="post">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Удалить</button>
                </form>
            </div>
        @empty
            <h2>Ничего не найдено</h2>
    @endforelse
@endsection

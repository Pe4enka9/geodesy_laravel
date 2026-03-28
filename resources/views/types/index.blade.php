@extends('theme')
@section('title', 'Типы оборудования')
@section('content')
    <h1>Типы оборудования</h1>
    <a href="{{ route('types.create') }}">Добавить</a>

    <div style="display:flex; flex-direction: column; gap: 10px">
        @forelse($types as $type)
            <div style="background-color: #fff;border: 1px solid #000;">
                <div>{{ $type->name }}</div>
                <div>{{ $type->code }}</div>
                <div>{{ $type->description }}</div>

                <a href="{{ route('types.edit', $type) }}">Редактировать</a>
                <form action="{{ route('types.destroy', $type) }}" method="post">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Удалить</button>
                </form>
            </div>
        @empty
            <h2>Ничего не найдено</h2>
    @endforelse
@endsection

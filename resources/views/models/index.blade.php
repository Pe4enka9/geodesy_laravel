@extends('theme')
@section('title', 'Модели оборудования')
@section('content')
    <h1>Модели оборудования</h1>
    <a href="{{ route('models.create') }}">Добавить</a>

    <div style="display:flex; flex-direction: column; gap: 10px">
        @forelse($models as $model)
            <div style="background-color: #fff;border: 1px solid #000;">
                <div>{{ $model->name }}</div>

                <a href="{{ route('models.edit', $model) }}">Редактировать</a>
                <form action="{{ route('models.destroy', $model) }}" method="post">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Удалить</button>
                </form>
            </div>
        @empty
            <h2>Ничего не найдено</h2>
    @endforelse
@endsection

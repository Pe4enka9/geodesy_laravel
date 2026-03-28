@extends('theme')
@section('title', 'Изменить тип')
@section('content')
    <form action="{{ route('types.update', $type) }}" method="post">
        @csrf
        @method('PATCH')
        <h1>Изменить тип</h1>

        <div>
            <label for="name">Название</label>
            <input type="text" name="name" id="name" placeholder="GPS-приемник (GNSS)"
                   value="{{ old('name', $type->name) }}">

            @error('name')
            <div>{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="code">Код</label>
            <input type="text" name="code" id="code" placeholder="TACHEO" value="{{ old('code', $type->code) }}">

            @error('code')
            <div>{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="description">Описание</label>
            <textarea name="description" id="description"
                      placeholder="Описание типа...">{{ old('description', $type->description) }}</textarea>

            @error('description')
            <div>{{ $message }}</div>
            @enderror
        </div>

        <button type="submit">Изменить</button>
    </form>
@endsection

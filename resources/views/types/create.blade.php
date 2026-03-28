@extends('theme')
@section('title', 'Добавить тип')
@section('content')
    <form action="{{ route('types.store') }}" method="post">
        @csrf
        <h1>Добавить тип</h1>

        <div>
            <label for="name">Название</label>
            <input type="text" name="name" id="name" placeholder="GPS-приемник (GNSS)" value="{{ old('name') }}">

            @error('name')
            <div>{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="code">Код</label>
            <input type="text" name="code" id="code" placeholder="TACHEO" value="{{ old('code') }}">

            @error('code')
            <div>{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="description">Описание</label>
            <textarea name="description" id="description"
                      placeholder="Описание типа...">{{ old('description') }}</textarea>

            @error('description')
            <div>{{ $message }}</div>
            @enderror
        </div>

        <button type="submit">Добавить</button>
    </form>
@endsection

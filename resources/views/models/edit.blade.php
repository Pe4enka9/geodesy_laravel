@extends('theme')
@section('title', 'Изменить модель')
@section('content')
    <form action="{{ route('models.update', $model) }}" method="post">
        @csrf
        @method('PATCH')
        <h1>Изменить модель</h1>

        <div>
            <label for="name">Название</label>
            <input type="text" name="name" id="name" placeholder="Leica TS06" value="{{ old('name', $model->name) }}">

            @error('name')
            <div>{{ $message }}</div>
            @enderror
        </div>

        <button type="submit">Изменить</button>
    </form>
@endsection

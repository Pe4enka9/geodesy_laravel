@extends('theme')
@section('title', 'Добавить модель')
@section('content')
    <form action="{{ route('models.store') }}" method="post">
        @csrf
        <h1>Добавить модель</h1>

        <div>
            <label for="name">Название</label>
            <input type="text" name="name" id="name" placeholder="Leica TS06" value="{{ old('name') }}">

            @error('name')
            <div>{{ $message }}</div>
            @enderror
        </div>

        <button type="submit">Добавить</button>
    </form>
@endsection

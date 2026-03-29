@extends('theme')
@section('title', 'Запрос на передачу')
@section('content')
    <form action="{{ route('transfers.store') }}" method="post">
        @csrf
        <h1>Запрос на передачу</h1>

        <div>
            <label for="equipment">Оборудование</label>
            <select name="equipment" id="equipment">
                <option value="" hidden>Выберите оборудование</option>
                @foreach($equipments as $equipment)
                    <option
                        value="{{ $equipment->id }}"
                        @selected(old('equipment') == $equipment->id)
                    >
                        {{ $equipment->inventory_number }}
                    </option>
                @endforeach
            </select>

            @error('equipment')
            <div>{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="receiver">Кому передать</label>
            <select name="receiver" id="receiver">
                <option value="" hidden>Выберите человека</option>
                @foreach($receivers as $receiver)
                    <option
                        value="{{ $receiver->id }}"
                        @selected(old('receiver') == $receiver->id)
                    >
                        {{ $receiver->name }}
                    </option>
                @endforeach
            </select>

            @error('receiver')
            <div>{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="comment">Комментарий</label>
            <textarea name="comment" id="comment" placeholder="Комментарий">{{ old('comment') }}</textarea>

            @error('comment')
            <div>{{ $message }}</div>
            @enderror
        </div>

        <button type="submit">Создать</button>
    </form>
@endsection

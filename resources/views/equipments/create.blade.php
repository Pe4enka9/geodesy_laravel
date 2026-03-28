@extends('theme')
@section('title', 'Добавить оборудование')
@section('content')
    <form action="{{ route('equipments.store') }}" method="post">
        @csrf
        <h1>Добавить оборудование</h1>

        <div>
            <label for="type">Тип</label>
            <select name="type" id="type">
                <option value="" hidden>Выберите тип</option>
                @foreach($types as $type)
                    <option
                        value="{{ $type->id }}"
                        @selected(old('type') == $type->id)
                    >
                        {{ $type->name }}
                    </option>
                @endforeach
            </select>

            @error('type')
            <div>{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="inventory_number">Инвентарный номер</label>
            <input type="text" name="inventory_number" id="inventory_number" placeholder="Инвентарный номер"
                   value="{{ old('inventory_number') }}">

            @error('inventory_number')
            <div>{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="serial_number">Серийный номер</label>
            <input type="text" name="serial_number" id="serial_number" placeholder="Серийный номер"
                   value="{{ old('serial_number') }}">

            @error('serial_number')
            <div>{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="model">Модель</label>
            <select name="model" id="model">
                <option value="">Выберите модель</option>
                @foreach($models as $model)
                    <option
                        value="{{ $model->id }}"
                        @selected(old('model') == $model->id)
                    >
                        {{ $model->name }}
                    </option>
                @endforeach
            </select>

            @error('model')
            <div>{{ $message }}</div>
            @enderror
        </div>

        <button type="submit">Добавить</button>
    </form>
@endsection

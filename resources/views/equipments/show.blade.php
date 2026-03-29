@extends('theme')
@section('title', 'Оборудование | ' . $equipment->inventory_number)
@section('content')
    <h1>{{ $equipment->inventory_number }}</h1>

    <div style="background-color: #fff;border: 1px solid #000;">
        <div>Статус: {{ $equipment->status->label() }}</div>
        <div>Тип: {{ $equipment->type->name }}</div>
        <div>Текущий держатель: {{ $equipment->currentHolder->name ?? 'Нет' }}</div>

        @isset($equipment->serial_number)
            <div>Серийный номер: {{ $equipment->serial_number }}</div>
        @endisset

        @isset($equipment->model)
            <div>Модель: {{ $equipment->model->name }}</div>
        @endisset

        @isset($equipment->lastCalibration)
            <div>Поверка закончится: {{ $equipment->lastCalibration->expires_at->format('d.m.Y') }}</div>
        @endisset

        @admin
        <a href="{{ route('equipments.edit', $equipment) }}">Редактировать</a>
        <form action="{{ route('equipments.destroy', $equipment) }}" method="post">
            @csrf
            @method('DELETE')
            <button type="submit">Удалить</button>
        </form>
        @endadmin
    </div>
@endsection

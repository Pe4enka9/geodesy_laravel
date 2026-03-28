@extends('theme')
@section('title', 'Оборудование')
@section('content')
    <h1>Оборудование</h1>

    <form>
        <input
            type="search" name="search" id="search"
            placeholder="Введите инвентарный номер или модель"
            value="{{ request('search') }}"
        >

        <button type="submit">Найти</button>
    </form>

    @admin
    <a href="{{ route('equipments.create') }}">Добавить</a>
    @endadmin

    <div style="display:flex; flex-direction: column; gap: 10px">
        @forelse($equipments as $equipment)
            <div style="background-color: #fff;border: 1px solid #000;">
                <div>Инвентарный номер: {{ $equipment->inventory_number }}</div>
                <div>Статус: {{ $equipment->status->label() }}</div>
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

                @admin()
                <a href="{{ route('equipments.edit', $equipment) }}">Редактировать</a>
                <form action="{{ route('equipments.destroy', $equipment) }}" method="post">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Удалить</button>
                </form>
                @endadmin
            </div>
        @empty
            <h2>Ничего не найдено</h2>
        @endforelse
    </div>
@endsection

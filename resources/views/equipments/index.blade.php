@use(App\Models\Equipments\Enums\EquipmentStatusEnum,Status)
@php
    $statuses = [
        'calibration_expired' => 'error',
        'inactive' => 'inactive',
        'maintenance' => 'maintenance',
        'lost' => 'lost',
        'written_off' => 'voided',
        'active' => 'success',
];
@endphp
@extends('theme')
@section('title', 'Оборудование')
@section('content')
    <div class="tab">
        <h2 class="tab__title">Оборудование</h2>

        <div class="tab__content">
            @include('components.tab-actions', ['sorts' => Status::cases(), 'placeholder' => 'Поиск по номеру...'])

            <div class="table">
                <table>
                    <thead>
                    <tr>
                        <th>Инв. номер</th>
                        <th>Тип</th>
                        <th>Модель</th>
                        <th>Статус</th>
                        <th>Держатель</th>
                        <th>Действия</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($equipments as $equipment)
                        <tr>
                            <td class="table__equipment-td">
                                <div>{{ $equipment->inventory_number }}</div>
                                <div>{{ $equipment->serial_number ?? '' }}</div>
                            </td>

                            <td>{{ $equipment->type->name }}</td>
                            <td>{{ $equipment->model->name ?? '-' }}</td>
                            <td>
                                <div class="status status--{{ $statuses[$equipment->status->value] }}">
                                    {{ $equipment->status->label() }}
                                </div>
                            </td>
                            <td>{{ $equipment->currentHolder?->getInitials() ?? '-' }}</td>

                            <td>@include('components.actions', ['route' => 'equipments', 'item' => $equipment])</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="create-form">
        <form action="{{ route('equipments.store') }}" method="post" id="create-form">
            @csrf
            <h2>Добавить оборудование</h2>

            <div class="input-wrapper">
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

            <div class="input-wrapper">
                <label for="inventory_number">Инвентарный номер</label>
                <input type="text" name="inventory_number" id="inventory_number" placeholder="Инвентарный номер"
                       value="{{ old('inventory_number') }}">

                @error('inventory_number')
                <div>{{ $message }}</div>
                @enderror
            </div>

            <div class="input-wrapper">
                <label for="serial_number">Серийный номер</label>
                <input type="text" name="serial_number" id="serial_number" placeholder="Серийный номер"
                       value="{{ old('serial_number') }}">

                @error('serial_number')
                <div>{{ $message }}</div>
                @enderror
            </div>

            <div class="input-wrapper">
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

            <button type="button" class="btn btn--primary">Отмена</button>
            <button type="submit" class="btn btn--primary">Добавить</button>
        </form>
    </div>
@endsection

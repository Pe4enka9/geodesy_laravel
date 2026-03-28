@extends('theme')
@section('title', 'Поверки')
@section('content')
    <h1>Поверки</h1>
    <a href="{{ route('calibrations.create') }}">Добавить</a>

    <div style="display:flex; flex-direction: column; gap: 10px">
        @foreach($calibrations as $calibration)
            <div style="background-color: #fff;border: 1px solid #000;">
                <div>Оборудование: {{ $calibration->equipment->inventory_number }}</div>
                <div>Номер сертификата: {{ $calibration->certificate_number }}</div>

                <div>
                    <span>Ссылка на поверку:</span>

                    <a href="{{ $calibration->verification_url }}" target="_blank">
                        {{ $calibration->verification_url }}
                    </a>
                </div>

                <div>Даты: {{ $calibration->issued_at->format('d.m.Y') }}
                    - {{ $calibration->expires_at->format('d.m.Y') }}</div>
                <div>Статус: {{ $calibration->status->label() }}</div>

                @isset($calibration->created_by)
                    <div>Добавил: {{ $calibration->createdBy->name }}</div>
                @endisset

                <a href="{{ route('calibrations.edit', $calibration) }}">Редактировать</a>
                <form action="{{ route('calibrations.destroy', $calibration) }}" method="post">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Удалить</button>
                </form>
            </div>
        @endforeach
    </div>
@endsection

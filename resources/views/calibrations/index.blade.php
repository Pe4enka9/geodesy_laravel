@use(App\Models\Calibrations\Enums\CalibrationStatusEnum, Status)

@php
    $statuses = [
        'expired' => 'error',
        'active' => 'success',
        'voided' => 'voided',
];
@endphp

@extends('theme')
@section('title', 'Поверки')
@section('content')
    <div class="tab">
        <h2 class="tab__title">Поверки</h2>

        <div class="tab__content">
            @include('components.tab-actions', ['sorts' => Status::cases(), 'placeholder' => 'Поиск по номеру сертификата...'])

            <div class="table">
                <table>
                    <thead>
                    <tr>
                        <th>Оборудование</th>
                        <th>Сертификат</th>
                        <th>Получен</th>
                        <th>Действует до</th>
                        <th>Статус</th>
                        <th>Действия</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($calibrations as $calibration)
                        <tr>
                            <td class="table__calibration-td">
                                <div>{{ $calibration->equipment->inventory_number }}</div>
                            </td>

                            <td class="table__calibration-td">
                                <div>{{ $calibration->certificate_number }}</div>
                            </td>

                            <td>{{ $calibration->issued_at->format('d.m.Y') }}</td>
                            <td>{{ $calibration->expires_at->format('d.m.Y') }}</td>

                            <td>
                                <div class="status status--{{ $statuses[$calibration->status->value] }}">
                                    {{ $calibration->status->label() }}
                                </div>
                            </td>

                            <td>@include('components.actions')</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

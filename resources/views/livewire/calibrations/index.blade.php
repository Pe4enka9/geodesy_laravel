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
            <tr wire:key="{{ $calibration->id }}">
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

                <td>
                    <livewire:actions :item="$calibration">
                        @include('components.delete-btn', ['item' => $calibration])
                    </livewire:actions>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

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
            <tr wire:key="{{ $equipment->id }}">
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

                <td>
                    <livewire:actions :item="$equipment">
                        @include('components.delete-btn', ['item' => $equipment])
                    </livewire:actions>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

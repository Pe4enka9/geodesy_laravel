@use(App\Models\Equipments\Enums\EquipmentStatusEnum,Status)

<x-tab-content>
    @include('components.tab-actions', ['sorts' => Status::cases(), 'placeholder' => 'Поиск по номеру...'])

    <x-tables.table
        :headers="['Инв. номер', 'Тип', 'Модель', 'Статус', 'Держатель']"
        :items="$equipments"
        empty-text="Оборудование не найдено"
    >
        @foreach($equipments as $equipment)
            <x-tables.tr :key="$equipment->id">
                <x-tables.td mod="equipments">
                    <div>{{ $equipment->inventory_number }}</div>
                    <div>{{ $equipment->serial_number ?? '' }}</div>
                </x-tables.td>

                <x-tables.td>{{ $equipment->type->name }}</x-tables.td>
                <x-tables.td>{{ $equipment->model->name ?? '-' }}</x-tables.td>

                <x-tables.td>
                    <div class="status status--{{ $statuses[$equipment->status->value] }}">
                        {{ $equipment->status->label() }}
                    </div>
                </x-tables.td>

                <x-tables.td>{{ $equipment->currentHolder?->getInitials() ?? '-' }}</x-tables.td>

                <x-tables.td>
                    <x-actions :id="$equipment->id"/>
                </x-tables.td>
            </x-tables.tr>
        @endforeach
    </x-tables.table>
</x-tab-content>

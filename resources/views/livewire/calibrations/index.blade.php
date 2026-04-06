@use(App\Models\Calibrations\Enums\CalibrationStatusEnum,Status)

<x-tab-content>
    <x-tab-actions
        :current-filter="$currentFilter"
        :filters="Status::cases()"
        placeholder="Поиск по номеру сертификата..."
    />

    <x-tables.table
        :headers="['Оборудование', 'Сертификат', 'Получен', 'Действует до', 'Статус']"
        :items="$calibrations"
        empty-text="Поверки не найдены"
    >
        @foreach($calibrations as $calibration)
            <x-tables.tr :key="$calibration->id">
                <x-tables.td mod="calibrations">{{ $calibration->equipment->inventory_number }}</x-tables.td>
                <x-tables.td mod="calibrations">{{ $calibration->certificate_number }}</x-tables.td>
                <x-tables.td>{{ $calibration->issued_at->format('d.m.Y') }}</x-tables.td>
                <x-tables.td>{{ $calibration->expires_at->format('d.m.Y') }}</x-tables.td>

                <x-tables.td>
                    <div class="status status--{{ $statuses[$calibration->status->value] }}">
                        {{ $calibration->status->label() }}
                    </div>
                </x-tables.td>

                <x-tables.td>
                    <x-actions :id="$calibration->id"/>
                </x-tables.td>
            </x-tables.tr>
        @endforeach
    </x-tables.table>
</x-tab-content>

<?php

use App\Models\Equipments\Enums\EquipmentStatusEnum;
use App\Models\Equipments\Equipment;
use App\Models\TransferRequests\Enums\TransferRequestStatusEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Title('Оборудование')]
class extends Component {
    public array $statuses;
    public string $search = '';
    public ?EquipmentStatusEnum $currentFilter = null;
    public bool $isMyEquipment = false;

    #[On('equipment-updated')]
    public function refreshList(): void
    {
    }

    #[Computed]
    public function equipments(): Collection
    {
        return Equipment::with(['type', 'model'])
            ->when($this->search, function (Builder $query) {
                $query->where('inventory_number', 'like', "%$this->search%");
            })
            ->when($this->currentFilter, function (Builder $query) {
                $query->where('status', $this->currentFilter);
            })
            ->when($this->isMyEquipment, function (Builder $query) {
                $query->where('current_holder_id', auth()->id());
            })
            ->latest()
            ->get();
    }

    public function delete(int $id): void
    {
        $equipment = Equipment::findOrFail($id);
        $this->authorize('delete', $equipment);
        $equipment->delete();
    }

    public function take(int $id): void
    {
        $equipment = Equipment::findOrFail($id);
        $this->authorize('take', $equipment);
        $userId = auth()->id();

        $equipment->update([
            'current_holder_id' => $userId,
            'status' => EquipmentStatusEnum::ACTIVE,
        ]);

        $equipment->transfers()->create([
            'receiver_id' => $userId,
            'status' => TransferRequestStatusEnum::ACCEPTED,
            'resolved_at' => now(),
        ]);
    }

    public function release(int $id): void
    {
        $equipment = Equipment::findOrFail($id);
        $this->authorize('release', $equipment);

        $equipment->update([
            'current_holder_id' => null,
            'status' => EquipmentStatusEnum::INACTIVE,
        ]);

        $equipment->transfers()->create([
            'sender_id' => auth()->id(),
            'status' => TransferRequestStatusEnum::ACCEPTED,
            'resolved_at' => now(),
        ]);
    }

    public function setFilter(?EquipmentStatusEnum $currentFilter): void
    {
        $this->currentFilter = $currentFilter;
        $this->isMyEquipment = false;
    }

    public function setMyEquipment(): void
    {
        $this->currentFilter = null;
        $this->isMyEquipment = true;
    }

    public function mount(): void
    {
        $this->statuses = [
            'calibration_expired' => 'error',
            'inactive' => 'inactive',
            'maintenance' => 'maintenance',
            'lost' => 'lost',
            'written_off' => 'voided',
            'active' => 'success',
        ];
    }
};
?>

<x-tab title="Оборудование">
    <livewire:equipments.create/>
    <livewire:equipments.edit/>
    <livewire:transfers.create/>

    <x-tab-content>
        <x-tab-actions
            :current-filter="$currentFilter"
            :filters="EquipmentStatusEnum::cases()"
            placeholder="Поиск по номеру..."
            :model="Equipment::class"
            show-my-equipment-filter
            :is-my-equipment="$this->isMyEquipment"
        />

        <a href="{{ route('full-inventory-export') }}" class="btn btn--primary">Скачать отчет по оборудованию</a>

        <x-tables.table
            :headers="['Инв. номер', 'Тип', 'Модель', 'Статус', 'Держатель']"
            :items="$this->equipments"
            empty-text="Оборудование не найдено"
        >
            @php /** @var Equipment $equipment */ @endphp

            @foreach($this->equipments as $equipment)
                <x-tables.tr :key="$equipment->id">
                    <x-tables.td mod="equipments">
                        <div>{{ $equipment->inventory_number }}</div>
                        <div>{{ $equipment->serial_number ?? '' }}</div>
                    </x-tables.td>

                    <x-tables.td>{{ $equipment->type->name }}</x-tables.td>
                    <x-tables.td>{{ $equipment->model->name ?? '-' }}</x-tables.td>

                    <x-tables.td>
                        <div class="status status--{{ $this->statuses[$equipment->status->value] }}">
                            {{ $equipment->status->label() }}
                        </div>
                    </x-tables.td>

                    <x-tables.td>{{ $equipment->currentHolder?->getInitials() ?? '-' }}</x-tables.td>

                    <x-tables.td>
                        <x-actions :model="$equipment"/>
                    </x-tables.td>
                </x-tables.tr>
            @endforeach
        </x-tables.table>
    </x-tab-content>
</x-tab>

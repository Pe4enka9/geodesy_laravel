<?php

namespace App\Livewire\Equipments;

use App\Models\Equipments\Enums\EquipmentStatusEnum;
use App\Models\Equipments\Equipment;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

class Index extends Component
{
    public string $search = '';
    public ?EquipmentStatusEnum $currentFilter = null;

    #[On('equipment-updated')]
    public function refreshList(): void
    {
    }

    public function delete(int $id): void
    {
        Equipment::find($id)->delete();
        $this->dispatch('equipment-updated');
    }

    public function setFilter(?EquipmentStatusEnum $currentFilter): void
    {
        if (!$currentFilter) {
            $this->currentFilter = null;
            return;
        }

        $this->currentFilter = $currentFilter;
    }

    public function render(): View
    {
        $equipments = Equipment::with(['type', 'model'])
            ->when($this->search, function (Builder $query) {
                $query->where('inventory_number', 'like', "%$this->search%");
            })
            ->when($this->currentFilter, function (Builder $query) {
                $query->where('status', $this->currentFilter);
            })
            ->latest()
            ->get();

        $statuses = [
            'calibration_expired' => 'error',
            'inactive' => 'inactive',
            'maintenance' => 'maintenance',
            'lost' => 'lost',
            'written_off' => 'voided',
            'active' => 'success',
        ];

        return view('livewire.equipments.index', [
            'equipments' => $equipments,
            'statuses' => $statuses,
        ]);
    }
}

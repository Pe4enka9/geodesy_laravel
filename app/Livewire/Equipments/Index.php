<?php

namespace App\Livewire\Equipments;

use App\Models\Equipments\Equipment;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

class Index extends Component
{
    public string $search = '';

    #[On('equipment-updated')]
    public function refreshList(): void
    {
    }

    public function delete(int $id): void
    {
        $equipment = Equipment::find($id)->delete();
        $this->dispatch('equipment-updated');
    }

    public function render(): View
    {
        $equipments = Equipment::when($this->search, function (Builder $query) {
            $query->where('inventory_number', 'like', "%$this->search%");
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

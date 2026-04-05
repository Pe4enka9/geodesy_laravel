<?php

namespace App\Livewire\Equipments;

use App\Models\Equipments\Equipment;
use Illuminate\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

class Index extends Component
{
    #[On('equipment-updated')]
    public function refreshList(): void
    {
    }

    public function delete(Equipment $equipment): void
    {
        $equipment->delete();
        $this->dispatch('equipment-updated');
    }

    public function render(): View
    {
        $equipments = Equipment::latest()->get();

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

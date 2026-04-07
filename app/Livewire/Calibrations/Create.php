<?php

namespace App\Livewire\Calibrations;

use App\Livewire\Forms\CalibrationForm;
use App\Models\Equipments\Equipment;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Livewire\Component;

class Create extends Component
{
    public CalibrationForm $form;

    public Collection $equipments;

    public function save(): void
    {
        $this->form->store();
        $this->form->reset();

        $this->dispatch('calibration-updated');
        $this->dispatch('close-create');
    }

    public function mount(): void
    {
        $this->equipments = Equipment::select('id', 'inventory_number')->latest()->get();
    }

    public function render(): View
    {
        return view('components.calibrations.create');
    }
}

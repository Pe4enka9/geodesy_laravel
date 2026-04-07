<?php

namespace App\Livewire\Calibrations;

use App\Livewire\Forms\CalibrationForm;
use App\Models\Calibrations\Calibration;
use App\Models\Equipments\Equipment;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

class Edit extends Component
{
    public CalibrationForm $form;

    public Collection $equipments;

    #[On('open-edit')]
    public function open(int $id): void
    {
        $calibration = Calibration::findOrFail($id);
        $this->form->setCalibration($calibration);
    }

    public function save(): void
    {
        $calibration = Calibration::findOrFail($this->form->editId);
        $this->authorize('update', $calibration);
        $this->form->update($calibration);
        $this->form->reset();

        $this->dispatch('calibration-updated');
        $this->dispatch('close-edit');
    }

    public function mount(): void
    {
        $this->equipments = Equipment::select('id', 'inventory_number')->latest()->get();
    }

    public function render(): View
    {
        return view('components.forms.calibrations.edit');
    }
}

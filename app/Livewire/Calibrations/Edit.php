<?php

namespace App\Livewire\Calibrations;

use App\Livewire\Forms\CalibrationForm;
use App\Models\Calibrations\Calibration;
use App\Models\Calibrations\Enums\CalibrationStatusEnum;
use App\Models\Equipments\Equipment;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;

class Edit extends Component
{
    public CalibrationForm $form;

    #[On('calibration-updated')]
    public function refreshEquipments(): void
    {
    }

    #[Computed]
    public function equipments(): Collection
    {
        return Equipment::select('id', 'inventory_number')
            ->where(function (Builder $query) {
                $query->doesntHave('calibrations')
                    ->orWhereHas('calibrations', function (Builder $q) {
                        $q->where('status', CalibrationStatusEnum::EXPIRED)
                            ->orWhere('equipment_id', $this->form->equipment_id);
                    });
            })
            ->latest()
            ->get();
    }

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

    public function render(): View
    {
        return view('components.forms.calibrations.edit');
    }
}

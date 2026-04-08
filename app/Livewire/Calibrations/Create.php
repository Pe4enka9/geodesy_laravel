<?php

namespace App\Livewire\Calibrations;

use App\Livewire\Forms\CalibrationForm;
use App\Models\Calibrations\Calibration;
use App\Models\Calibrations\Enums\CalibrationStatusEnum;
use App\Models\Equipments\Enums\EquipmentStatusEnum;
use App\Models\Equipments\Equipment;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;

class Create extends Component
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
                        $q->where('status', CalibrationStatusEnum::EXPIRED);
                    });
            })
            ->whereIn('status', [
                EquipmentStatusEnum::INACTIVE,
                EquipmentStatusEnum::CALIBRATION_EXPIRED
            ])
            ->latest()
            ->get();
    }

    public function save(): void
    {
        $this->authorize('create', Calibration::class);
        $this->form->store();
        $this->form->reset();

        $this->dispatch('calibration-updated');
        $this->dispatch('close-create');
    }

    public function render(): View
    {
        return view('components.forms.calibrations.create');
    }
}

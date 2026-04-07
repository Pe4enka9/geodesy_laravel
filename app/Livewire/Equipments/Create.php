<?php

namespace App\Livewire\Equipments;

use App\Livewire\Forms\EquipmentForm;
use App\Models\EquipmentModel;
use App\Models\EquipmentType;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Livewire\Component;

class Create extends Component
{
    public Collection $types;
    public Collection $models;

    public EquipmentForm $form;

    public function save(): void
    {
        $this->form->store();
        $this->form->reset();

        $this->dispatch('equipment-updated');
        $this->dispatch('close-create');
    }

    public function mount(): void
    {
        $this->types = EquipmentType::select('id', 'name')->get();
        $this->models = EquipmentModel::select('id', 'name')->get();
    }

    public function render(): View
    {
        return view('components.equipments.create');
    }
}

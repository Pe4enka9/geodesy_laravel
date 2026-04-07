<?php

namespace App\Livewire\Equipments;

use App\Livewire\Forms\EquipmentForm;
use App\Models\EquipmentModel;
use App\Models\Equipments\Equipment;
use App\Models\EquipmentType;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

class Edit extends Component
{
    public EquipmentForm $form;

    public Collection $types;
    public Collection $models;

    public Equipment $equipment;

    public function mount(): void
    {
        $this->types = EquipmentType::select('id', 'name')->get();
        $this->models = EquipmentModel::select('id', 'name')->get();
    }

    #[On('open-edit')]
    public function open(int $id): void
    {
        $equipment = Equipment::findOrFail($id);
        $this->form->setEquipment($equipment);
    }

    public function save(): void
    {
        $equipment = Equipment::findOrFail($this->form->editId);
        $this->authorize('update', $equipment);
        $this->form->update($equipment);
        $this->form->reset();

        $this->dispatch('equipment-updated');
        $this->dispatch('close-edit');
    }

    public function render(): View
    {
        return view('components.forms.equipments.edit');
    }
}

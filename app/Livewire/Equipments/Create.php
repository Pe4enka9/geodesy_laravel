<?php

namespace App\Livewire\Equipments;

use App\Models\EquipmentModel;
use App\Models\Equipments\Equipment;
use App\Models\EquipmentType;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Livewire\Component;

class Create extends Component
{
    public Collection $types;
    public Collection $models;

    public int $type;
    public string $inventory_number;
    public ?string $serial_number = null;
    public ?int $model = null;

    protected function rules(): array
    {
        return [
            'type' => ['required', 'integer', Rule::exists(EquipmentType::class, 'id')],
            'inventory_number' => ['required', 'string', Rule::unique(Equipment::class, 'inventory_number')],
            'serial_number' => ['nullable', 'string'],
            'model' => ['nullable', 'integer', Rule::exists(EquipmentModel::class, 'id')],
        ];
    }

    public function save(): void
    {
        $this->validate();

        Equipment::create([
            'type_id' => $this->type,
            'inventory_number' => $this->inventory_number,
            'serial_number' => $this->serial_number,
            'model_id' => $this->model,
        ]);

        $this->reset(['type', 'inventory_number', 'serial_number', 'model']);
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
        return view('livewire.equipments.create');
    }
}

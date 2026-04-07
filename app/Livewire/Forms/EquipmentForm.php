<?php

namespace App\Livewire\Forms;

use App\Models\EquipmentModel;
use App\Models\Equipments\Enums\EquipmentStatusEnum;
use App\Models\Equipments\Equipment;
use App\Models\EquipmentType;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use Livewire\Attributes\Validate;
use Livewire\Form;

class EquipmentForm extends Form
{
    public ?int $editId = null;
    #[Validate]
    public int $type = 0;
    #[Validate]
    public string $inventory_number = '';
    #[Validate]
    public ?string $serial_number = null;
    #[Validate]
    public ?int $model = null;
    #[Validate]
    public EquipmentStatusEnum $status = EquipmentStatusEnum::INACTIVE;

    protected function rules(?Equipment $equipment = null): array
    {
        return [
            'type' => ['required', 'integer', Rule::exists(EquipmentType::class, 'id')],
            'inventory_number' => ['required', 'string', Rule::unique(Equipment::class, 'inventory_number')->ignore($equipment?->id)],
            'serial_number' => ['nullable', 'string'],
            'model' => ['nullable', 'integer', Rule::exists(EquipmentModel::class, 'id')],
            'status' => ['required', new Enum(EquipmentStatusEnum::class)],
        ];
    }

    public function store(): Equipment
    {
        $this->validate($this->rules());

        return Equipment::create([
            'type_id' => $this->type,
            'inventory_number' => $this->inventory_number,
            'serial_number' => $this->serial_number,
            'model_id' => $this->model,
            'status' => $this->status,
        ]);
    }

    public function update(Equipment $equipment): Equipment
    {
        $this->validate($this->rules($equipment));

        $equipment->update([
            'type_id' => $this->type,
            'inventory_number' => $this->inventory_number,
            'serial_number' => $this->serial_number,
            'model_id' => $this->model,
            'status' => $this->status,
        ]);

        return $equipment;
    }

    public function setEquipment(Equipment $equipment): void
    {
        $this->editId = $equipment->id;
        $this->type = $equipment->type_id;
        $this->inventory_number = $equipment->inventory_number;
        $this->serial_number = $equipment->serial_number;
        $this->model = $equipment->model_id;
        $this->status = $equipment->status;
    }
}

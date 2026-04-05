<?php

namespace App\Livewire\Equipments;

use App\Models\EquipmentModel;
use App\Models\Equipments\Enums\EquipmentStatusEnum;
use App\Models\Equipments\Equipment;
use App\Models\EquipmentType;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use Illuminate\View\View;
use Livewire\Component;

class Edit extends Component
{
    protected $listeners = ['open-edit' => 'open'];

    public Collection $types;
    public Collection $models;

    public Equipment $equipment;
    public int $type;
    public string $inventory_number;
    public ?string $serial_number = null;
    public ?int $model = null;
    public EquipmentStatusEnum $status;

    protected function rules(): array
    {
        return [
            'type' => ['required', 'integer', Rule::exists(EquipmentType::class, 'id')],
            'inventory_number' => ['required', 'string', Rule::unique(Equipment::class, 'inventory_number')->ignore($this->equipment)],
            'serial_number' => ['nullable', 'string'],
            'model' => ['nullable', 'integer', Rule::exists(EquipmentModel::class, 'id')],
            'status' => ['required', new Enum(EquipmentStatusEnum::class)],
        ];
    }

    public function mount(): void
    {
        $this->types = EquipmentType::select('id', 'name')->get();
        $this->models = EquipmentModel::select('id', 'name')->get();
    }

    public function open(Equipment $item): void
    {
        $this->equipment = $item;
        $this->type = $item->type_id;
        $this->inventory_number = $item->inventory_number;
        $this->serial_number = $item->serial_number;
        $this->model = $item->model_id;
        $this->status = $item->status;
    }

    public function save(): void
    {
        $this->validate();

        $this->equipment->update([
            'type_id' => $this->type,
            'inventory_number' => $this->inventory_number,
            'serial_number' => $this->serial_number,
            'model_id' => $this->model,
            'status' => $this->status,
        ]);

        $this->reset(['type', 'inventory_number', 'serial_number', 'model']);
        $this->dispatch('equipment-updated');
        $this->dispatch('close-edit');
    }

    public function render(): View
    {
        return view('livewire.equipments.edit');
    }
}

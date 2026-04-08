<?php

namespace App\Livewire\Forms;

use App\Models\EquipmentType;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class TypeForm extends Form
{
    public ?int $editId = null;
    #[Validate(as: 'название')]
    public string $name = '';
    #[Validate(as: 'код')]
    public string $code = '';
    #[Validate(as: 'описание')]
    public ?string $description = null;

    protected function rules(?EquipmentType $type = null): array
    {
        return [
            'name' => ['required', 'string'],
            'code' => ['required', 'string', Rule::unique(EquipmentType::class, 'code')->ignore($type?->id)],
            'description' => ['nullable', 'string'],
        ];
    }

    public function store(): EquipmentType
    {
        $this->validate($this->rules());

        return EquipmentType::create([
            'name' => $this->name,
            'code' => $this->code,
            'description' => $this->description,
        ]);
    }

    public function update(EquipmentType $type): EquipmentType
    {
        $this->validate($this->rules($type));

        $type->update([
            'name' => $this->name,
            'code' => $this->code,
            'description' => $this->description,
        ]);

        return $type;
    }

    public function setType(EquipmentType $type): void
    {
        $this->editId = $type->id;
        $this->name = $type->name;
        $this->code = $type->code;
        $this->description = $type->description;
    }
}

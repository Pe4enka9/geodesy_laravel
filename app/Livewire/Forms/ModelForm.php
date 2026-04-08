<?php

namespace App\Livewire\Forms;

use App\Models\EquipmentModel;
use Livewire\Attributes\Validate;
use Livewire\Form;

class ModelForm extends Form
{
    public ?int $editId = null;
    #[Validate(as: 'название')]
    public string $name = '';

    protected function rules(): array
    {
        return [
            'name' => ['required', 'string'],
        ];
    }

    public function store(): EquipmentModel
    {
        $this->validate();

        return EquipmentModel::create(['name' => $this->name]);
    }

    public function update(EquipmentModel $model): EquipmentModel
    {
        $this->validate();
        $model->update(['name' => $this->name]);

        return $model;
    }

    public function setModel(EquipmentModel $model): void
    {
        $this->editId = $model->id;
        $this->name = $model->name;
    }
}

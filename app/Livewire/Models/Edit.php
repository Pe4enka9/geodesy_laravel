<?php

namespace App\Livewire\Models;

use App\Models\EquipmentModel;
use Illuminate\View\View;
use Livewire\Component;

class Edit extends Component
{
    protected $listeners = ['open-edit' => 'open'];

    public EquipmentModel $model;
    public string $name;

    protected function rules(): array
    {
        return [
            'name' => ['required', 'string'],
        ];
    }

    public function open(int $id): void
    {
        $model = EquipmentModel::find($id);
        $this->model = $model;
        $this->name = $model->name;
    }

    public function save(): void
    {
        $this->validate();

        $this->model->update(['name' => $this->name]);

        $this->reset();
        $this->dispatch('model-updated');
        $this->dispatch('close-edit');
    }

    public function render(): View
    {
        return view('livewire.models.edit');
    }
}

<?php

namespace App\Livewire\Models;

use App\Models\EquipmentModel;
use Illuminate\View\View;
use Livewire\Component;

class Create extends Component
{
    public string $name;

    protected function rules(): array
    {
        return [
            'name' => ['required', 'string'],
        ];
    }

    public function save(): void
    {
        $this->validate();

        EquipmentModel::create(['name' => $this->name]);

        $this->reset();
        $this->dispatch('model-updated');
        $this->dispatch('close-create');
    }

    public function render(): View
    {
        return view('livewire.models.create');
    }
}

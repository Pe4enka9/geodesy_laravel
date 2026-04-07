<?php

namespace App\Livewire\Models;

use App\Livewire\Forms\ModelForm;
use App\Models\EquipmentModel;
use Illuminate\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

class Edit extends Component
{
    public ModelForm $form;

    #[On('open-edit')]
    public function open(int $id): void
    {
        $model = EquipmentModel::findOrFail($id);
        $this->form->setModel($model);
    }

    public function save(): void
    {
        $model = EquipmentModel::findOrFail($this->form->editId);
        $this->authorize('update', $model);
        $this->form->update($model);
        $this->form->reset();

        $this->dispatch('model-updated');
        $this->dispatch('close-edit');
    }

    public function render(): View
    {
        return view('components.forms.models.edit');
    }
}

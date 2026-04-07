<?php

namespace App\Livewire\Types;

use App\Livewire\Forms\TypeForm;
use App\Models\EquipmentType;
use Illuminate\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

class Edit extends Component
{
    public TypeForm $form;

    #[On('open-edit')]
    public function open(int $id): void
    {
        $type = EquipmentType::findOrFail($id);
        $this->form->setType($type);
    }

    public function save(): void
    {
        $type = EquipmentType::findOrFail($this->form->editId);
        $this->authorize('update', $type);
        $this->form->update($type);
        $this->form->reset();

        $this->dispatch('type-updated');
        $this->dispatch('close-edit');
    }

    public function render(): View
    {
        return view('components.forms.types.edit');
    }
}

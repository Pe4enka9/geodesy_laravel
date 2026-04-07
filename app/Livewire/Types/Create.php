<?php

namespace App\Livewire\Types;

use App\Livewire\Forms\TypeForm;
use Illuminate\View\View;
use Livewire\Component;

class Create extends Component
{
    public TypeForm $form;

    public function save(): void
    {
        $this->form->store();
        $this->form->reset();

        $this->dispatch('type-updated');
        $this->dispatch('close-create');
    }

    public function render(): View
    {
        return view('components.types.create');
    }
}

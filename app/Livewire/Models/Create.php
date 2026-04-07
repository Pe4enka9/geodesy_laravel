<?php

namespace App\Livewire\Models;

use App\Livewire\Forms\ModelForm;
use Illuminate\View\View;
use Livewire\Component;

class Create extends Component
{
    public ModelForm $form;

    public function save(): void
    {
        $this->form->store();
        $this->form->reset();

        $this->dispatch('model-updated');
        $this->dispatch('close-create');
    }

    public function render(): View
    {
        return view('components.models.create');
    }
}

<?php

namespace App\Livewire\Users;

use App\Livewire\Forms\UserForm;
use Illuminate\View\View;
use Livewire\Component;

class Create extends Component
{
    public UserForm $form;

    public function save(): void
    {
        $this->form->store();
        $this->form->reset();

        $this->dispatch('user-updated');
        $this->dispatch('close-create');
    }

    public function render(): View
    {
        return view('components.users.create');
    }
}

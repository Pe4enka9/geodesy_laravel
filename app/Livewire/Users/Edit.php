<?php

namespace App\Livewire\Users;

use App\Livewire\Forms\UserForm;
use App\Models\Users\User;
use App\Services\User\Actions\ChangePasswordAction;
use Illuminate\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

class Edit extends Component
{
    public UserForm $form;

    #[On('open-edit')]
    public function open(int $id): void
    {
        $user = User::findOrFail($id);
        $this->form->setUser($user);
    }

    public function save(ChangePasswordAction $changePasswordAction): void
    {
        $user = User::findOrFail($this->form->editId);
        $this->authorize('update', $user);
        $this->form->update($user, $changePasswordAction);
        $this->form->reset();

        $this->dispatch('user-updated');
        $this->dispatch('close-edit');
    }

    public function render(): View
    {
        return view('components.forms.users.edit');
    }
}

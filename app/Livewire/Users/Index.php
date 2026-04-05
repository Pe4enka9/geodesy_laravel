<?php

namespace App\Livewire\Users;

use App\Models\Users\User;
use Illuminate\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

class Index extends Component
{
    #[On('user-updated')]
    public function refreshList(): void
    {
    }

    public function delete(User $user): void
    {
        $user->delete();
        $this->dispatch('user-updated');
    }

    public function render(): View
    {
        $users = User::latest()->get();

        return view('livewire.users.index', ['users' => $users]);
    }
}

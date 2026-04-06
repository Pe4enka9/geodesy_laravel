<?php

namespace App\Livewire\Users;

use App\Models\Users\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

class Index extends Component
{
    public string $search = '';

    #[On('user-updated')]
    public function refreshList(): void
    {
    }

    public function delete(int $id): void
    {
        User::find($id)->delete();
        $this->dispatch('user-updated');
    }

    public function render(): View
    {
        $users = User::when($this->search, function (Builder $query) {
            $query->where('first_name', 'like', "%$this->search%")
                ->orWhere('last_name', 'like', "%$this->search%")
                ->orWhere('login', 'like', "%$this->search%");
        })
            ->latest()
            ->get();

        return view('livewire.users.index', ['users' => $users]);
    }
}

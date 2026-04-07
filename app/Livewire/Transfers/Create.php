<?php

namespace App\Livewire\Transfers;

use App\Models\Equipments\Equipment;
use App\Models\Users\User;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Livewire\Component;

class Create extends Component
{
    protected $listeners = ['open-create-transfer' => 'open'];

    public Collection $users;

    public Equipment $equipment;
    public int $equipmentId;
    public int $user;
    public string $comment = '';

    protected function rules(): array
    {
        return [
            'equipmentId' => ['required', 'integer', Rule::exists(Equipment::class, 'id')],
            'user' => ['required', 'integer', Rule::exists(User::class, 'id')],
            'comment' => ['nullable', 'string'],
        ];
    }

    public function open(int $id): void
    {
        $equipment = Equipment::find($id);
        $this->equipment = $equipment;
        $this->equipmentId = $equipment->id;
    }

    public function save(): void
    {
        $this->validate();

        $this->equipment->transfers()->create([
            'sender_id' => auth()->id(),
            'receiver_id' => $this->user,
            'comment' => $this->comment,
        ]);

        $this->reset(['equipment', 'equipmentId', 'user', 'comment']);
        $this->dispatch('transfer-updated');
        $this->dispatch('close-create-transfer');
    }

    public function mount(): void
    {
        $this->users = User::exceptMe()->get();
    }

    public function render(): View
    {
        return view('livewire.transfers.create');
    }
}

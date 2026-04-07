<?php

namespace App\Livewire\Transfers;

use App\Livewire\Forms\TransferForm;
use App\Models\Equipments\Equipment;
use App\Models\Users\User;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

class Create extends Component
{
    public TransferForm $form;

    public Collection $users;

    public ?int $currentEquipmentId = null;

    #[On('open-create-transfer')]
    public function open(int $id): void
    {
        $this->currentEquipmentId = $id;
        $this->form->equipmentId = $id;
        $this->form->user = 0;
        $this->form->comment = null;
    }

    public function save(): void
    {
        $this->form->store();
        $this->form->reset();
        $this->currentEquipmentId = null;

        $this->dispatch('transfer-updated');
        $this->dispatch('close-create-transfer');
    }

    public function mount(): void
    {
        $this->users = User::exceptMe()->get();
    }

    public function render(): View
    {
        $equipment = $this->currentEquipmentId
            ? Equipment::findOrFail($this->currentEquipmentId)
            : null;

        return view('components.transfers.create', ['equipment' => $equipment]);
    }
}

<?php

namespace App\Livewire\Forms;

use App\Models\Equipments\Equipment;
use App\Models\TransferRequests\TransferRequest;
use App\Models\Users\User;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class TransferForm extends Form
{
    #[Validate]
    public int $equipmentId = 0;
    #[Validate]
    public int $user = 0;
    #[Validate]
    public ?string $comment = null;

    protected function rules(): array
    {
        return [
            'equipmentId' => ['required', 'integer', Rule::exists(Equipment::class, 'id')],
            'user' => ['required', 'integer', Rule::exists(User::class, 'id')],
            'comment' => ['nullable', 'string'],
        ];
    }

    public function store(): TransferRequest
    {
        $this->validate();

        $equipment = Equipment::findOrFail($this->equipmentId);

        return $equipment->transfers()->create([
            'sender_id' => auth()->id(),
            'receiver_id' => $this->user,
            'comment' => $this->comment,
        ]);
    }
}

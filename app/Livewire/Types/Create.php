<?php

namespace App\Livewire\Types;

use App\Models\EquipmentType;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Livewire\Component;

class Create extends Component
{
    public string $name;
    public string $code;
    public ?string $description = null;

    protected function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'code' => ['required', 'string', Rule::unique(EquipmentType::class, 'code')],
            'description' => ['nullable', 'string'],
        ];
    }

    public function save(): void
    {
        $this->validate();

        EquipmentType::create([
            'name' => $this->name,
            'code' => $this->code,
            'description' => $this->description,
        ]);

        $this->reset();
        $this->dispatch('type-updated');
        $this->dispatch('close-create');
    }

    public function render(): View
    {
        return view('livewire.types.create');
    }
}

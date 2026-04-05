<?php

namespace App\Livewire\Types;

use App\Models\EquipmentType;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Livewire\Component;

class Edit extends Component
{
    protected $listeners = ['open-edit' => 'open'];

    public EquipmentType $type;
    public string $name;
    public string $code;
    public ?string $description = null;

    protected function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'code' => ['required', 'string', Rule::unique(EquipmentType::class, 'code')->ignore($this->type)],
            'description' => ['nullable', 'string'],
        ];
    }

    public function open(EquipmentType $item): void
    {
        $this->type = $item;
        $this->name = $item->name;
        $this->code = $item->code;
        $this->description = $item->description;
    }

    public function save(): void
    {
        $this->validate();

        $this->type->update([
            'name' => $this->name,
            'code' => $this->code,
            'description' => $this->description,
        ]);

        $this->reset();
        $this->dispatch('type-updated');
        $this->dispatch('close-edit');
    }

    public function render(): View
    {
        return view('livewire.types.edit');
    }
}

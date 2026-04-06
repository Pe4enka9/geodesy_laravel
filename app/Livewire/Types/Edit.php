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

    public function open(int $id): void
    {
        $type = EquipmentType::find($id);
        $this->type = $type;
        $this->name = $type->name;
        $this->code = $type->code;
        $this->description = $type->description;
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

<?php

namespace App\Livewire\Types;

use App\Models\EquipmentType;
use Illuminate\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

class Index extends Component
{
    #[On('type-updated')]
    public function refreshList(): void
    {
    }

    public function delete(EquipmentType $type): void
    {
        $type->delete();
        $this->dispatch('type-updated');
    }

    public function render(): View
    {
        $types = EquipmentType::latest()->get();

        return view('livewire.types.index', ['types' => $types]);
    }
}

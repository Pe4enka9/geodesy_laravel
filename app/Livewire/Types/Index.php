<?php

namespace App\Livewire\Types;

use App\Models\EquipmentType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

class Index extends Component
{
    public string $search = '';

    #[On('type-updated')]
    public function refreshList(): void
    {
    }

    public function delete(int $id): void
    {
        EquipmentType::find($id)->delete();
        $this->dispatch('type-updated');
    }

    public function render(): View
    {
        $types = EquipmentType::when($this->search, function (Builder $query) {
            $query->where('name', 'like', "%$this->search%")
                ->orWhere('code', 'like', "%$this->search%");
        })
            ->latest()
            ->get();

        return view('livewire.types.index', ['types' => $types]);
    }
}

<?php

namespace App\Livewire\Models;

use App\Models\EquipmentModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

class Index extends Component
{
    public string $search = '';

    #[On('model-updated')]
    public function refreshList(): void
    {
    }

    public function delete(int $id): void
    {
        EquipmentModel::find($id)->delete();
        $this->dispatch('model-updated');
    }

    public function render(): View
    {
        $models = EquipmentModel::when($this->search, function (Builder $query) {
            $query->where('name', 'like', "%$this->search%");
        })
            ->latest()
            ->get();

        return view('livewire.models.index', ['models' => $models]);
    }
}

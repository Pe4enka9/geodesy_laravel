<?php

namespace App\Livewire\Models;

use App\Models\EquipmentModel;
use Illuminate\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

class Index extends Component
{
    #[On('model-updated')]
    public function refreshList(): void
    {
    }

    public function delete(EquipmentModel $model): void
    {
        $model->delete();
        $this->dispatch('model-updated');
    }

    public function render(): View
    {
        $models = EquipmentModel::latest()->get();

        return view('livewire.models.index', ['models' => $models]);
    }
}

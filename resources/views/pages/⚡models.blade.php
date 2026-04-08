<?php

use App\Models\EquipmentModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Title('Модели оборудования')]
class extends Component {
    public string $search = '';

    #[On('model-updated')]
    public function refreshList(): void
    {
    }

    #[Computed]
    public function models(): Collection
    {
        return EquipmentModel::when($this->search, function (Builder $query) {
            $query->where('name', 'like', "%$this->search%");
        })
            ->latest()
            ->get();
    }

    public function delete(int $id): void
    {
        $model = EquipmentModel::findOrFail($id);
        $this->authorize('delete', $model);
        $model->delete();
    }
};
?>

<x-tab title="Модели оборудования">
    <livewire:models.create/>
    <livewire:models.edit/>

    <x-tab-content>
        <x-tab-actions
            placeholder="Поиск по названию..."
            btn="Добавить модель"
            :model="EquipmentModel::class"
        />

        <x-cards.cards
            :items="$this->models"
            empty-icon="models"
            empty-text="Модели не найдены"
        >
            @php /** @var EquipmentModel $model */ @endphp

            @foreach($this->models as $model)
                <x-cards.card
                    :key="$model->id"
                    :item="$model"
                    img="models"
                >
                    <x-slot name="content">
                        <h3 class="card__title">{{ $model->name }}</h3>
                        <div class="card__updated-at">Обновлено: {{ $model->updated_at->format('d.m.Y') }}</div>
                    </x-slot>

                    <x-slot name="actions">
                        <x-actions :model="$model"/>
                    </x-slot>
                </x-cards.card>
            @endforeach
        </x-cards.cards>
    </x-tab-content>
</x-tab>

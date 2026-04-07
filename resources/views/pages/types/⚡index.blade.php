<?php

use App\Models\EquipmentType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Title('Типы оборудования')]
class extends Component {
    public string $search = '';

    #[On('type-updated')]
    public function refreshList(): void
    {
    }

    #[Computed]
    public function types(): Collection
    {
        return EquipmentType::when($this->search, function (Builder $query) {
            $query->where('name', 'like', "%$this->search%")
                ->orWhere('code', 'like', "%$this->search%");
        })
            ->latest()
            ->get();
    }

    public function delete(int $id): void
    {
        EquipmentType::findOrFail($id)->delete();
    }
};
?>

<x-tab title="Типы оборудования">
    <livewire:types.create/>
    <livewire:types.edit/>

    <x-tab-content>
        <x-tab-actions placeholder="Поиск по названию, коду..." btn="Добавить тип"/>

        <x-cards.cards
            :items="$this->types"
            :empty-icon="asset('icons/types-gray.svg')"
            empty-text="Типы не найдены"
        >
            @php /** @var EquipmentType $type */ @endphp

            @foreach($this->types as $type)
                <x-cards.card
                    :key="$type->id"
                    :item="$type"
                    :img="asset('icons/types-purple.svg')"
                    purple-img-wrapper
                >
                    <x-slot name="content">
                        <h3 class="card__title">{{ $type->name }}</h3>
                        <div class="card__code">Код: {{ $type->code }}</div>
                    </x-slot>

                    <x-slot name="body">
                        @if($type->description)
                            <div class="card__description">{{ $type->description }}</div>
                        @endif

                        <div class="card__updated-at card__updated-at--light">
                            Обновлено: {{ $type->updated_at->format('d.m.Y') }}
                        </div>
                    </x-slot>
                </x-cards.card>
            @endforeach
        </x-cards.cards>
    </x-tab-content>
</x-tab>

<x-tab-content>
    <x-tab-actions placeholder="Поиск по названию, коду..." btn="Добавить тип"/>

    <x-cards.cards
        :items="$types"
        :empty-icon="asset('icons/types-gray.svg')"
        empty-text="Типы не найдены"
    >
        @foreach($types as $type)
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
                    <div class="card__description">{{ $type->description }}</div>
                    <div class="card__updated-at card__updated-at--light">
                        Обновлено: {{ $type->updated_at->format('d.m.Y') }}
                    </div>
                </x-slot>
            </x-cards.card>
        @endforeach
    </x-cards.cards>
</x-tab-content>

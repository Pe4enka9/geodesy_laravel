<x-tab-content>
    <x-tab-actions placeholder="Поиск по названию..." btn="Добавить модель"/>

    <x-cards.cards
        :items="$models"
        :empty-icon="asset('icons/models-gray.svg')"
        empty-text="Модели не найдены"
    >
        @foreach($models as $model)
            <x-cards.card
                :key="$model->id"
                :item="$model"
                :img="asset('icons/models-primary.svg')"
            >
                <x-slot name="content">
                    <h3 class="card__title">{{ $model->name }}</h3>
                    <div class="card__updated-at">Обновлено: {{ $model->updated_at->format('d.m.Y') }}</div>
                </x-slot>
            </x-cards.card>
        @endforeach
    </x-cards.cards>
</x-tab-content>

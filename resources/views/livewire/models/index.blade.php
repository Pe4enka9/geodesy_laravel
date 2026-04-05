<div class="cards">
    @foreach($models as $model)
        <div class="card" wire:key="{{ $model->id }}">
            <div class="card__header">
                <div class="card__img-wrapper">
                    <img src="{{ asset('icons/models-primary.svg') }}" alt="" class="card__img">
                </div>

                <div class="card__content">
                    <h3 class="card__title">{{ $model->name }}</h3>
                    <div class="card__updated-at">Обновлено: {{ $model->updated_at->format('d.m.Y') }}</div>
                </div>

                <livewire:actions :item="$model">
                    @include('components.delete-btn', ['item' => $model])
                </livewire:actions>
            </div>
        </div>
    @endforeach
</div>

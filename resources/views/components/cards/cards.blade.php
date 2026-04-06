@props(['items', 'emptyIcon', 'emptyText', 'column' => false])

<div @class(['cards', 'cards--column' => $column])>
    @if($items->isEmpty())
        <div class="card__empty">
            <img src="{{ $emptyIcon }}" alt="" class="card__empty-icon">
            <div class="card__empty-text">{{ $emptyText }}</div>
        </div>
    @else
        {{ $slot }}
    @endif
</div>

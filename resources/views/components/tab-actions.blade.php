@props([
    'filters',
    'currentFilter' => null,
    'placeholder' => 'Поиск...',
    'hasBtn' => true,
    'btn' => 'Добавить',
])

<div class="tab-actions" x-data>
    <form class="tab-actions__form">
        @isset($filters)
            <div class="tab-actions__sort-wrapper">
                <button
                    type="button"
                    @class(['tab-actions__sort', 'tab-actions__sort--active' => $currentFilter === null])
                    wire:click="setFilter(null)"
                >
                    Все
                </button>
                @foreach($filters as $filter)
                    <button
                        type="button"
                        @class(['tab-actions__sort', 'tab-actions__sort--active' => $currentFilter === $filter])
                        wire:click="setFilter('{{ $filter }}')"
                    >
                        {{ $filter->label() }}
                    </button>
                @endforeach
            </div>
        @endisset

        <div @class(['tab-actions__search-wrapper', 'input-wrapper', 'input-wrapper--search', 'tab-actions__search-wrapper--w100' => !isset($filters)])>
            <input type="search" class="tab-actions__search" placeholder="{{ $placeholder }}"
                   wire:model.live.debounce.500ms="search">
        </div>
    </form>

    @if($hasBtn)
        <button type="button" class="tab-actions__add-btn btn btn--primary" @click="$dispatch('open-create')">
            <img src="{{ asset('icons/plus.svg') }}" alt="" class="btn__icon">
            {{ $btn }}
        </button>
    @endif
</div>

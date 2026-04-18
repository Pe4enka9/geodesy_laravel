@props([
    'filters' => null,
    'currentFilter' => null,
    'placeholder' => 'Поиск...',
    'hasBtn' => true,
    'btn' => 'Добавить',
    'model' => null,
    'showMyEquipmentFilter' => false,
    'isMyEquipment' => false,
])

<div class="tab-actions" x-data>
    <form class="tab-actions__form">
        @isset($filters)
            <div class="tab-actions__sort-wrapper">
                <button
                    type="button"
                    @class(['tab-actions__sort', 'tab-actions__sort--active' => $currentFilter === null && !$isMyEquipment])
                    wire:click="setFilter(null)"
                >
                    Все
                </button>

                @if($showMyEquipmentFilter)
                    <button
                        type="button"
                        @class(['tab-actions__sort', 'tab-actions__sort--active' => $isMyEquipment])
                        wire:click="setMyEquipment"
                    >
                        Моё оборудование
                    </button>
                @endif

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
        @can('create', $model)
            <button type="button" class="tab-actions__add-btn btn btn--primary" @click="$dispatch('open-create')">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" class="btn__icon" stroke-width="2" stroke-linecap="round"
                     stroke-linejoin="round" aria-hidden="true">
                    <path d="M5 12h14"/>
                    <path d="M12 5v14"/>
                </svg>
                {{ $btn }}
            </button>
        @endcan
    @endif
</div>

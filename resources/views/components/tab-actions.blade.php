@props(['hasBtn' => true])

<div class="tab-actions" x-data>
    <form class="tab-actions__form">
        @isset($sorts)
            <div class="tab-actions__sort-wrapper">
                <button type="button" class="tab-actions__sort tab-actions__sort--active">Все</button>
                @foreach($sorts as $sort)
                    <button type="button" class="tab-actions__sort">{{ $sort->label() }}</button>
                @endforeach
            </div>
        @endisset

        <div @class(['tab-actions__search-wrapper', 'input-wrapper', 'input-wrapper--search', 'tab-actions__search-wrapper--w100' => !isset($sorts)])>
            <input type="search" class="tab-actions__search" placeholder="{{ $placeholder ?? 'Поиск...' }}"
                   wire:model.live.debounce.500ms="search">
        </div>
    </form>

    @if($hasBtn)
        <button type="button" class="tab-actions__add-btn btn btn--primary" @click="$dispatch('open-create')">
            <img src="{{ asset('icons/plus.svg') }}" alt="" class="btn__icon">
            {{ $btn ?? 'Добавить' }}
        </button>
    @endif
</div>

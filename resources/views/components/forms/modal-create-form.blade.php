@props([
    'customEvent' => 'create',
    'title' => 'Добавить',
])

<div
    class="modal"
    :class="{ 'modal--active' : open }"
    x-data="{ open: false }"
    x-effect="document.body.style.overflow = open ? 'hidden' : ''"
    @open-{{ $customEvent }}.window="open = true"
    @close-{{ $customEvent }}.window="open = false"
    @click="open = false"
>
    <form
        class="modal__form"
        :class="{ 'modal__form--active' : open }"
        wire:submit.prevent="save"
        @click.stop
    >
        <div class="modal__title-wrapper">
            <h2 class="modal__title">{{ $title }}</h2>

            <button type="button" class="modal__cross-btn" @click="open = false">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" class="modal__cross-img img img--contain" stroke-width="2"
                     stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M18 6 6 18"/>
                    <path d="m6 6 12 12"/>
                </svg>
            </button>
        </div>

        {{ $slot }}

        <div class="modal__buttons">
            <button type="button" class="btn btn--outline-primary" @click="open = false">Отмена</button>
            <button type="submit" class="btn btn--primary">Добавить</button>
        </div>
    </form>
</div>

<div
    class="modal"
    :class="{ 'modal--active' : open }"
    x-data="{ open: false }"
    x-effect="document.body.style.overflow = open ? 'hidden' : ''"
    @open-edit.window="open = true"
    @close-edit.window="open = false"
    @click="open = false"
>
    <form
        method="post"
        class="modal__form"
        :class="{ 'modal__form--active' : open }"
        wire:submit.prevent="save"
        @click.stop
    >
        <div class="modal__title-wrapper">
            <h2 class="modal__title">{{ $title ?? 'Изменить' }}</h2>

            <button type="button" class="modal__cross-btn" @click="open = false">
                <img src="{{ asset('icons/cross.svg') }}" alt="" class="modal__cross-img img img--contain">
            </button>
        </div>
        @csrf
        @method('PATCH')

        {{ $slot }}

        <div class="modal__buttons">
            <button type="button" class="btn btn--outline-primary" @click="open = false">Отмена</button>
            <button type="submit" class="btn btn--primary">Сохранить</button>
        </div>
    </form>
</div>

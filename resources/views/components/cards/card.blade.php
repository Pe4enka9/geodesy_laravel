@props(['key', 'item', 'img' => null, 'mod' => '', 'header' => null, 'content' => null, 'body' => null, 'bodyRow' => false])

<div @class(['card', "card--$mod" => $mod]) wire:key="{{ $key }}">
    <div class="card__header">
        @if($img)
            <div class="card__img-wrapper">
                <img src="{{ $img }}" alt="" class="card__img">
            </div>
        @endif

        @if($header)
            {{ $header }}
        @endif

        @if($content)
            <div class="card__content">
                {{ $content }}
            </div>
        @endif

        <x-actions :id="$item->id"/>
    </div>

    @if($body)
        <div @class(['card__body', 'card__body--row' => $bodyRow])>
            {{ $body }}
        </div>
    @endif

    {{ $slot }}
</div>

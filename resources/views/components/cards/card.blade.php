@props([
    'key',
    'item',
    'img' => null,
    'mod' => '',
    'header' => null,
    'content' => null,
    'body' => null,
    'bodyRow' => false,
    'actions' => null,
    'purpleImgWrapper' => false,
])

<div @class(['card', "card--$mod" => $mod]) wire:key="{{ $key }}">
    <div class="card__header">
        @if($img)
            <div @class(['card__img-wrapper', 'card__img-wrapper--purple' => $purpleImgWrapper])>
                @switch($img)
                    @case('models')
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" class="card__img card__img--models" stroke-width="2"
                             stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path
                                d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"/>
                            <path d="m3.3 7 8.7 5 8.7-5"/>
                            <path d="M12 22V12"/>
                        </svg>
                        @break
                    @case('types')
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" class="card__img card__img--types" stroke-width="2"
                             stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path
                                d="M12.83 2.18a2 2 0 0 0-1.66 0L2.6 6.08a1 1 0 0 0 0 1.83l8.58 3.91a2 2 0 0 0 1.66 0l8.58-3.9a1 1 0 0 0 0-1.83z"/>
                            <path d="M2 12a1 1 0 0 0 .58.91l8.6 3.91a2 2 0 0 0 1.65 0l8.58-3.9A1 1 0 0 0 22 12"/>
                            <path d="M2 17a1 1 0 0 0 .58.91l8.6 3.91a2 2 0 0 0 1.65 0l8.58-3.9A1 1 0 0 0 22 17"/>
                        </svg>
                        @break
                @endswitch
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

        @if($actions)
            {{ $actions }}
        @endif
    </div>

    @if($body)
        <div @class(['card__body', 'card__body--row' => $bodyRow])>
            {{ $body }}
        </div>
    @endif

    {{ $slot }}
</div>

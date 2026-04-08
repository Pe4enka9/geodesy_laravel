@props(['mod' => ''])

<div @class(['logo', "logo--$mod" => $mod])>
    <img src="{{ asset('icons/geo.svg') }}" alt="ГеоКонтроль" class="logo__img">
</div>

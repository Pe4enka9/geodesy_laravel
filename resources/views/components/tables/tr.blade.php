@props(['key' => '', 'mod' => ''])

<tr
    @class(['table-wrapper__tr', "table-wrapper__tr--$mod" => $mod])
    {{ $key ? "wire:key=$key" : '' }}
>
    {{ $slot }}
</tr>

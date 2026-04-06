@props(['mod' => ''])

<td @class(['table-wrapper__td', "table-wrapper__td--$mod" => $mod])>
    {{ $slot }}
</td>

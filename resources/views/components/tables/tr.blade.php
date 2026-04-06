@props(['key' => ''])

<tr class="table-wrapper__tr" {{ $key ? "wire:key=$key" : '' }}>{{ $slot }}</tr>

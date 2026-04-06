@props(['headers', 'items', 'emptyText' => 'Ничего не найдено'])

<div class="table-wrapper">
    <table class="table-wrapper__table">
        <thead class="table-wrapper__thead">
        <x-tables.tr class="table-wrapper__tr">
            @foreach($headers as $header)
                <th class="table-wrapper__th">{{ $header }}</th>
            @endforeach

            <th class="table-wrapper__th">Действия</th>
        </x-tables.tr>
        </thead>
        <tbody class="table-wrapper__tbody">
        @if($items->isEmpty())
            <tr>
                <td class="table-wrapper__empty" colspan="{{ count($headers) }}">{{ $emptyText }}</td>
            </tr>
        @else
            {{ $slot }}
        @endif
        </tbody>
    </table>
</div>

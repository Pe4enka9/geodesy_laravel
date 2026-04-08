@props([
    'equipmentName',
    'sender',
    'receiver',
    'updatedAt',
    'status',
])

@php
    $statuses = [
        'pending' => 'pending',
        'accepted' => 'success',
        'rejected' => 'decline',
        'cancelled' => 'cancel',
        ];
@endphp

<div class="dashboard__transfers-card">
    <div class="dashboard__transfers-card-content">
        <div class="dashboard__transfers-card-left">
            <div class="dashboard__transfers-card-equipment">{{ $equipmentName }}</div>

            @if($sender)
                <div class="dashboard__transfers-card-arrow">→</div>
                <div class="dashboard__transfers-card-user">{{ $sender }}</div>
            @endif

            @if($receiver)
                <div class="dashboard__transfers-card-arrow">→</div>
                <div class="dashboard__transfers-card-user">{{ $receiver }}</div>
            @endif
        </div>

        <div class="dashboard__transfers-card-updated-at">{{ $updatedAt }}</div>
    </div>

    <div class="status status--{{ $statuses[$status->value] }}">
        {{ $status->label() }}
    </div>
</div>

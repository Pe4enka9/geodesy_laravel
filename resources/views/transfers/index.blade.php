@use(App\Models\TransferRequests\Enums\TransferRequestStatusEnum,Status)

@php
    $statuses = [
        'pending' => 'pending',
        'accepted' => 'success',
        'rejected' => 'decline',
        'cancelled' => 'cancel',
];
@endphp

@extends('theme')
@section('title', 'Передачи оборудования')
@section('content')
    <div class="tab">
        <h2 class="tab__title">Передачи оборудования</h2>

        <div class="tab__content">
            @include('components.tab-actions', ['sorts' => Status::cases(), 'placeholder' => 'Поиск по оборудованию...', 'hasBtn' => false])

            <div class="cards cards--column">
                @foreach($transfers as $transfer)
                    <div class="card card--no-shadow">
                        <div class="card__header">
                            <h3 class="card__title">{{ $transfer->equipment->inventory_number }}</h3>

                            <div class="status status--{{ $statuses[$transfer->status->value] }}">
                                {{ $transfer->status->label() }}
                            </div>

                            <div class="badge badge--pending">Требуется действие</div>
                        </div>

                        <div class="card__body card__body--row">
                            <div class="card__sender">
                                <span>От:</span> {{ $transfer->sender->getInitials() }}
                            </div>

                            <div class="card__receiver">
                                <span>Кому:</span> {{ $transfer->receiver->getInitials() }}
                            </div>

                            <div class="card__created-at">
                                <span>Создано:</span> {{ $transfer->created_at->format('d.m.Y H:i') }}
                            </div>

                            @isset($transfer->resolved_at)
                                <div class="card__resolved-at">
                                    <span>Решение:</span> {{ $transfer->resolved_at->format('d.m.Y H:i') }}
                                </div>
                            @endisset
                        </div>

                        <div class="card__transfer-comment">{{ $transfer->comment }}</div>

                        <div class="card__actions">
                            <button type="button" class="btn btn--success btn--sm">
                                <img src="{{ asset('icons/success-white.svg') }}" alt="" class="btn__icon">
                                Принять
                            </button>

                            <button type="button" class="btn btn--outline-danger btn--sm">
                                <img src="{{ asset('icons/decline.svg') }}" alt="" class="btn__icon">
                                Отклонить
                            </button>

                            <button type="button" class="btn btn--outline-disabled btn--sm">
                                <img src="{{ asset('icons/cancel.svg') }}" alt="" class="btn__icon">
                                Отменить
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection

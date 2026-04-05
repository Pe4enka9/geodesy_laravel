@use(App\Models\TransferRequests\Enums\TransferRequestStatusEnum, Status)

<div class="cards cards--column">
    @foreach($transfers as $transfer)
        <div class="card card--no-shadow" wire:key="{{ $transfer->id }}">
            <div class="card__header">
                <h3 class="card__title">{{ $transfer->equipment->inventory_number }}</h3>

                <div class="status status--{{ $statuses[$transfer->status->value] }}">
                    {{ $transfer->status->label() }}
                </div>

                @if($transfer->isReceiver() && $transfer->isPending())
                    <div class="badge badge--pending">Требуется действие</div>
                @endif
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

            @if($transfer->canAction())
                <div class="card__actions">
                    @if($transfer->isSender())
                        <button type="button" class="btn btn--outline-disabled btn--sm"
                                wire:click="cancel({{ $transfer }})">
                            <img src="{{ asset('icons/cancel.svg') }}" alt="" class="btn__icon">
                            Отменить
                        </button>
                    @elseif($transfer->isReceiver())
                        <button type="button" class="btn btn--success btn--sm" wire:click="accept({{ $transfer }})">
                            <img src="{{ asset('icons/success-white.svg') }}" alt="" class="btn__icon">
                            Принять
                        </button>

                        <button type="button" class="btn btn--outline-danger btn--sm"
                                wire:click="reject({{ $transfer }})">
                            <img src="{{ asset('icons/decline.svg') }}" alt="" class="btn__icon">
                            Отклонить
                        </button>
                    @endif
                </div>
            @endif
        </div>
    @endforeach
</div>

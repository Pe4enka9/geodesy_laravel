@use(App\Models\TransferRequests\Enums\TransferRequestStatusEnum,Status)

<x-tab-content>
    <x-tab-actions
        :current-filter="$currentFilter"
        :filters="Status::cases()"
        placeholder="Поиск по оборудованию..."
        :has-btn="false"
    />

    <x-cards.cards
        :items="$transfers"
        :empty-icon="asset('icons/transfers-gray.svg')"
        empty-text="Передачи не найдены"
        column
    >
        @foreach($transfers as $transfer)
            <x-cards.card
                mod="no-shadow"
                :key="$transfer->id"
                :item="$transfer"
                body-row
            >
                <x-slot name="header">
                    <h3 class="card__title">{{ $transfer->equipment->inventory_number }}</h3>

                    <div class="status status--{{ $statuses[$transfer->status->value] }}">
                        {{ $transfer->status->label() }}
                    </div>

                    @if($transfer->isReceiver() && $transfer->isPending())
                        <div class="badge badge--pending">Требуется действие</div>
                    @endif
                </x-slot>

                <x-slot name="body">
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
                </x-slot>

                @if($transfer->comment)
                    <div class="card__transfer-comment">{{ $transfer->comment }}</div>
                @endif

                @if($transfer->canAction())
                    <div class="card__actions">
                        @if($transfer->isSender())
                            <button type="button" class="btn btn--outline-disabled btn--sm"
                                    wire:click="cancel({{ $transfer->id }})">
                                <img src="{{ asset('icons/cancel.svg') }}" alt="" class="btn__icon">
                                Отменить
                            </button>
                        @elseif($transfer->isReceiver())
                            <button type="button" class="btn btn--success btn--sm"
                                    wire:click="accept({{ $transfer->id }})">
                                <img src="{{ asset('icons/success-white.svg') }}" alt="" class="btn__icon">
                                Принять
                            </button>

                            <button type="button" class="btn btn--outline-danger btn--sm"
                                    wire:click="reject({{ $transfer->id }})">
                                <img src="{{ asset('icons/decline.svg') }}" alt="" class="btn__icon">
                                Отклонить
                            </button>
                        @endif
                    </div>
                @endif
            </x-cards.card>
        @endforeach
    </x-cards.cards>
</x-tab-content>

<?php

use App\Models\TransferRequests\Enums\TransferRequestStatusEnum;
use App\Models\TransferRequests\TransferRequest;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Title('Передачи оборудования')]
class extends Component {
    public array $statuses;
    public string $search = '';
    public ?TransferRequestStatusEnum $currentFilter = null;

    #[On('transfer-updated')]
    public function refreshList(): void
    {
    }

    #[Computed]
    public function transfers(): Collection
    {
        return TransferRequest::with(['equipment', 'sender', 'receiver'])
            ->when($this->search, function (Builder $query) {
                $query->whereHas('equipment', function (Builder $q) {
                    $q->where('inventory_number', 'like', "%$this->search%");
                });
            })
            ->when($this->currentFilter, function (Builder $query) {
                $query->where('status', $this->currentFilter);
            })
            ->latest()
            ->get();
    }

    public function delete(int $id): void
    {
        TransferRequest::findOrFail($id)->delete();
    }

    public function setFilter(?TransferRequestStatusEnum $currentFilter): void
    {
        $this->currentFilter = $currentFilter;
    }

    // Принять запрос
    public function accept(int $id): void
    {
        $transfer = TransferRequest::find($id);

        if (!$transfer->isReceiver()) return;

        $transfer->equipment->update(['current_holder_id' => auth()->id()]);

        $transfer->update([
            'status' => TransferRequestStatusEnum::ACCEPTED,
            'resolved_at' => now(),
        ]);

        $this->dispatch('transfer-updated');
    }

    // Отклонить запрос
    public function reject(int $id): void
    {
        $transfer = TransferRequest::find($id);

        if (!$transfer->isReceiver()) return;

        $transfer->update([
            'status' => TransferRequestStatusEnum::REJECTED,
            'resolved_at' => now(),
        ]);

        $this->dispatch('transfer-updated');
    }

    // Отменить запрос
    public function cancel(int $id): void
    {
        $transfer = TransferRequest::find($id);

        if (!$transfer->isSender()) return;

        $transfer->update([
            'status' => TransferRequestStatusEnum::CANCELLED,
            'resolved_at' => now(),
        ]);

        $this->dispatch('transfer-updated');
    }

    public function mount(): void
    {
        $this->statuses = [
            'pending' => 'pending',
            'accepted' => 'success',
            'rejected' => 'decline',
            'cancelled' => 'cancel',
        ];
    }
};
?>

<x-tab title="Передачи оборудования">
    <x-tab-content>
        <x-tab-actions
            :current-filter="$currentFilter"
            :filters="TransferRequestStatusEnum::cases()"
            placeholder="Поиск по оборудованию..."
            :has-btn="false"
        />

        <x-cards.cards
            :items="$this->transfers"
            :empty-icon="asset('icons/transfers-gray.svg')"
            empty-text="Передачи не найдены"
            column
        >
            @php /** @var TransferRequest $transfer */ @endphp

            @foreach($this->transfers as $transfer)
                <x-cards.card
                    mod="no-shadow"
                    :key="$transfer->id"
                    :item="$transfer"
                    :has-actions="false"
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
</x-tab>

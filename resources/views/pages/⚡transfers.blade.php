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

    public function setFilter(?TransferRequestStatusEnum $currentFilter): void
    {
        $this->currentFilter = $currentFilter;
    }

    // Принять запрос
    public function accept(int $id): void
    {
        $transfer = TransferRequest::find($id);
        $this->authorize('accept', $transfer);
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
        $this->authorize('reject', $transfer);

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
        $this->authorize('cancel', $transfer);

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

        <a href="{{ route('full-transfers-export') }}" class="btn btn--primary">Скачать отчет по передачам</a>

        <x-cards.cards
            :items="$this->transfers"
            empty-icon="transfers"
            empty-text="Передачи не найдены"
            column
        >
            @php /** @var TransferRequest $transfer */ @endphp

            @foreach($this->transfers as $transfer)
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
                        @if($transfer->sender_id)
                            <div class="card__sender">
                                <span>От:</span> {{ $transfer->sender->getInitials() }}
                            </div>
                        @endif

                        @if($transfer->receiver_id)
                            <div class="card__receiver">
                                <span>Кому:</span> {{ $transfer->receiver->getInitials() }}
                            </div>
                        @endif

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
                            @can('cancel', $transfer)
                                <button type="button" class="btn btn--outline-disabled btn--sm"
                                        wire:click="cancel({{ $transfer->id }})">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                         fill="none" stroke="currentColor" class="btn__icon" stroke-width="2"
                                         stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <path d="M4.929 4.929 19.07 19.071"/>
                                        <circle cx="12" cy="12" r="10"/>
                                    </svg>
                                    Отменить
                                </button>
                            @endcan

                            @can('accept', $transfer)
                                <button type="button" class="btn btn--success btn--sm"
                                        wire:click="accept({{ $transfer->id }})">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                         fill="none" stroke="currentColor" class="btn__icon" stroke-width="2"
                                         stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <circle cx="12" cy="12" r="10"/>
                                        <path d="m9 12 2 2 4-4"/>
                                    </svg>
                                    Принять
                                </button>
                            @endcan

                            @can('reject', $transfer)
                                <button type="button" class="btn btn--outline-danger btn--sm"
                                        wire:click="reject({{ $transfer->id }})">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                         fill="none" stroke="currentColor" class="btn__icon" stroke-width="2"
                                         stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <circle cx="12" cy="12" r="10"/>
                                        <path d="m15 9-6 6"/>
                                        <path d="m9 9 6 6"/>
                                    </svg>
                                    Отклонить
                                </button>
                            @endcan
                        </div>
                    @endif

                    @if($transfer->receiver && $transfer->sender && $transfer->isAccepted())
                        <div class="card__actions">
                            <a class="btn btn--primary" href="{{ route('print-act', $transfer) }}" target="_blank">
                                Скачать акт
                            </a>

                            <form action="{{ route('upload-act', $transfer) }}" method="post"
                                  enctype="multipart/form-data" class="file-upload-form">
                                @csrf

                                <label class="btn btn--outline-primary file-upload__label">
                                    <input type="file" name="act_file" class="file-upload__input" accept=".pdf"
                                           required>

                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                         stroke-width="2">
                                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                                        <polyline points="17 8 12 3 7 8"/>
                                        <line x1="12" y1="3" x2="12" y2="15"/>
                                    </svg>

                                    <span class="file-upload__text">Загрузить скан</span>
                                </label>
                            </form>

                            @if($transfer->act_path)
                                <a href="{{ route('download-act', $transfer) }}" class="btn btn--success"
                                   target="_blank">Посмотреть скан</a>
                            @endif
                        </div>
                    @endif
                </x-cards.card>
            @endforeach
        </x-cards.cards>
    </x-tab-content>
</x-tab>

@push('scripts')
    <script>
        document.addEventListener('change', (e) => {
            if (!e.target.matches('.file-upload__input')) return;

            const form = e.target.closest('form');
            const textEl = e.target.closest('.file-upload__label').querySelector('.file-upload__text');

            if (e.target.files.length && form) {
                if (textEl) textEl.textContent = 'Загрузка...';
                form.requestSubmit();
            }
        });
    </script>
@endpush

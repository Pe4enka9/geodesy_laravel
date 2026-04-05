<?php

namespace App\Livewire\Transfers;

use App\Models\TransferRequests\Enums\TransferRequestStatusEnum;
use App\Models\TransferRequests\TransferRequest;
use Illuminate\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

class Index extends Component
{
    #[On('transfer-updated')]
    public function refreshList(): void
    {
    }

    public function delete(TransferRequest $transfer): void
    {
        $transfer->delete();
        $this->dispatch('transfer-updated');
    }

    // Принять запрос
    public function accept(TransferRequest $transfer): void
    {
        if (!$transfer->isReceiver()) return;

        $transfer->equipment->update(['current_holder_id' => auth()->id()]);

        $transfer->update([
            'status' => TransferRequestStatusEnum::ACCEPTED,
            'resolved_at' => now(),
        ]);

        $this->dispatch('transfer-updated');
    }

    // Отклонить запрос
    public function reject(TransferRequest $transfer): void
    {
        if (!$transfer->isReceiver()) return;

        $transfer->update([
            'status' => TransferRequestStatusEnum::REJECTED,
            'resolved_at' => now(),
        ]);

        $this->dispatch('transfer-updated');
    }

    // Отменить запрос
    public function cancel(TransferRequest $transfer): void
    {
        if (!$transfer->isSender()) return;

        $transfer->update([
            'status' => TransferRequestStatusEnum::CANCELLED,
            'resolved_at' => now(),
        ]);

        $this->dispatch('transfer-updated');
    }

    public function render(): View
    {
        $transfers = TransferRequest::latest()->get();

        $statuses = [
            'pending' => 'pending',
            'accepted' => 'success',
            'rejected' => 'decline',
            'cancelled' => 'cancel',
        ];

        return view('livewire.transfers.index', [
            'transfers' => $transfers,
            'statuses' => $statuses,
        ]);
    }
}

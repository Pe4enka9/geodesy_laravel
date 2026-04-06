<?php

namespace App\Livewire\Transfers;

use App\Models\TransferRequests\Enums\TransferRequestStatusEnum;
use App\Models\TransferRequests\TransferRequest;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

class Index extends Component
{
    public string $search = '';

    #[On('transfer-updated')]
    public function refreshList(): void
    {
    }

    public function delete(int $id): void
    {
        TransferRequest::find($id)->delete();
        $this->dispatch('transfer-updated');
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

    public function render(): View
    {
        $transfers = TransferRequest::with('equipment')
            ->when($this->search, function (Builder $query) {
                $query->whereHas('equipment', function (Builder $q) {
                    $q->where('inventory_number', 'like', "%$this->search%");
                });
            })
            ->latest()
            ->get();

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

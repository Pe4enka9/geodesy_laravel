<?php

namespace App\Models\TransferRequests;

use App\Models\Equipments\Equipment;
use App\Models\TransferRequests\Enums\TransferRequestStatusEnum;
use App\Models\Users\User;
use Illuminate\Database\Eloquent\Attributes\Guarded;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Guarded(['id'])]
class TransferRequest extends Model
{
    protected $casts = [
        'status' => TransferRequestStatusEnum::class,
        'resolved_at' => 'datetime',
    ];

    public function equipment(): BelongsTo
    {
        return $this->belongsTo(Equipment::class);
    }

    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function receiver(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function isReceiver(): bool
    {
        return $this->receiver_id === auth()->id();
    }

    public function isSender(): bool
    {
        return $this->sender_id === auth()->id();
    }

    public function isPending(): bool
    {
        return $this->status === TransferRequestStatusEnum::PENDING;
    }

    public function isAccepted(): bool
    {
        return $this->status === TransferRequestStatusEnum::ACCEPTED;
    }

    public function canAction(): bool
    {
        return ($this->isSender() || $this->isReceiver()) && $this->isPending();
    }
}

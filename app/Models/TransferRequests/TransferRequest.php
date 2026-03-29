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
}

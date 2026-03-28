<?php

namespace App\Models\TransferRequests;

use App\Models\TransferRequests\Enums\TransferRequestStatusEnum;
use Illuminate\Database\Eloquent\Attributes\Guarded;
use Illuminate\Database\Eloquent\Model;

#[Guarded(['id'])]
class TransferRequest extends Model
{
    protected $casts = [
        'status' => TransferRequestStatusEnum::class,
        'resolved_at' => 'timestamp',
    ];
}

<?php

namespace App\Models;

use App\Enums\TransferRequests\Status;
use Illuminate\Database\Eloquent\Attributes\Guarded;
use Illuminate\Database\Eloquent\Model;

#[Guarded(['id'])]
class TransferRequest extends Model
{
    protected $casts = [
        'status' => Status::class,
        'resolved_at' => 'timestamp',
    ];
}

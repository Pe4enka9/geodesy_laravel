<?php

namespace App\Models\Transactions;

use App\Models\Transactions\Enums\TransactionTypeEnum;
use Illuminate\Database\Eloquent\Attributes\Guarded;
use Illuminate\Database\Eloquent\Model;

#[Guarded(['id'])]
class Transaction extends Model
{
    protected $casts = [
        'type' => TransactionTypeEnum::class,
        'occurred_at' => 'timestamp',
    ];
}

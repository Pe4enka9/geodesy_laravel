<?php

namespace App\Models;

use App\Enums\Transactions\Type;
use Illuminate\Database\Eloquent\Attributes\Guarded;
use Illuminate\Database\Eloquent\Model;

#[Guarded(['id'])]
class Transaction extends Model
{
    protected $casts = [
        'type' => Type::class,
        'occurred_at' => 'timestamp',
    ];
}

<?php

namespace App\Http\Requests\Transfer;

use App\Models\Equipments\Equipment;
use App\Models\Users\User;
use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Attributes\Validation\Exists;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapName(SnakeCaseMapper::class)]
class TransferDto extends Data
{
    public function __construct(
        #[Exists(Equipment::class, 'id')]
        public int     $equipment,
        #[Exists(User::class, 'id')]
        public int     $receiver,
        public ?string $comment,
    )
    {
    }
}

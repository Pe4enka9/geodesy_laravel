<?php

namespace App\Http\Requests\Type;

use App\Models\EquipmentType;
use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Attributes\Validation\Unique;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapName(SnakeCaseMapper::class)]
class CreateDto extends Data
{
    public function __construct(
        public string  $name,
        #[Unique(EquipmentType::class, 'code')]
        public string  $code,
        public ?string $description,
    )
    {
    }
}

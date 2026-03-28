<?php

namespace App\Http\Requests\Type;

use App\Models\EquipmentType;
use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Attributes\Validation\Unique;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;
use Spatie\LaravelData\Support\Validation\References\RouteParameterReference;

#[MapName(SnakeCaseMapper::class)]
class UpdateDto extends Data
{
    public function __construct(
        public string  $name,
        #[Unique(EquipmentType::class, 'code', ignore: new RouteParameterReference('type', 'id'))]
        public string  $code,
        public ?string $description,
    )
    {
    }
}

<?php

namespace App\Http\Requests\Model;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapName(SnakeCaseMapper::class)]
class ModelDto extends Data
{
    public function __construct(
        public string $name,
    )
    {
    }
}

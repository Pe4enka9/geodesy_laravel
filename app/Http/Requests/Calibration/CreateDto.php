<?php

namespace App\Http\Requests\Calibration;

use App\Models\Equipments\Equipment;
use Carbon\Carbon;
use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Attributes\Validation\After;
use Spatie\LaravelData\Attributes\Validation\Exists;
use Spatie\LaravelData\Attributes\Validation\Url;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;
use Spatie\LaravelData\Support\Validation\References\FieldReference;

#[MapName(SnakeCaseMapper::class)]
class CreateDto extends Data
{
    public function __construct(
        #[Exists(Equipment::class, 'id')]
        public int    $equipment,
        public string $certificateNumber,
        #[Url]
        public string $verificationUrl,
        public Carbon $issuedAt,
        #[After(new FieldReference('issuedAt'))]
        public Carbon $expiresAt,
    )
    {
    }
}

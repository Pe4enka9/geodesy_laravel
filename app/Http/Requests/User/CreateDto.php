<?php

namespace App\Http\Requests\User;

use App\Models\Users\Enums\UserPositionEnum;
use App\Models\Users\Enums\UserRoleEnum;
use App\Models\Users\User;
use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Attributes\Validation\Confirmed;
use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Attributes\Validation\Unique;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapName(SnakeCaseMapper::class)]
class CreateDto extends Data
{
    public function __construct(
        public string            $name,
        #[Unique(User::class, 'login')]
        public string            $login,
        public ?UserPositionEnum $position,
        public UserRoleEnum      $role,
        #[Confirmed, Min(6)]
        public string            $password,
    )
    {
    }
}

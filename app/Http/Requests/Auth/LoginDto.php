<?php

namespace App\Http\Requests\Auth;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapName(SnakeCaseMapper::class)]
class LoginDto extends Data
{
    public function __construct(
        public string $login,
        public string $password,
    )
    {
    }

    public static function messages(): array
    {
        return [
            'required' => 'Это поле обязательно.',
        ];
    }
}

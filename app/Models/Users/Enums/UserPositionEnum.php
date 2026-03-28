<?php

namespace App\Models\Users\Enums;

enum UserPositionEnum: string
{
    case SURVEYOR = 'SURVEYOR';
    case FOREMAN = 'FOREMAN';

    public function label(): string
    {
        return match ($this) {
            self::SURVEYOR => 'Геодезист',
            self::FOREMAN => 'Бригадир',
        };
    }
}

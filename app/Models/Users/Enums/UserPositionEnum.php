<?php

namespace App\Models\Users\Enums;

enum UserPositionEnum: string
{
    case SURVEYOR = 'surveyor';
    case FOREMAN = 'foreman';

    public function label(): string
    {
        return match ($this) {
            self::SURVEYOR => 'Геодезист',
            self::FOREMAN => 'Бригадир',
        };
    }
}

<?php

namespace App\Enums\Equipments;

enum Status: string
{
    case ACTIVE = 'active';
    case MAINTENANCE = 'maintenance';
    case CALIBRATION_EXPIRED = 'calibration_expired';
    case LOST = 'lost';
    case WRITTEN_OFF = 'written_off';

    public function label(): string
    {
        return match ($this) {
            self::ACTIVE => 'В работе/На складе',
            self::MAINTENANCE => 'В ремонте',
            self::CALIBRATION_EXPIRED => 'Просрочена поверка',
            self::LOST => 'Утерян',
            self::WRITTEN_OFF => 'Списан',
        };
    }
}

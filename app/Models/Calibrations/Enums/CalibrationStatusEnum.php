<?php

namespace App\Models\Calibrations\Enums;

enum CalibrationStatusEnum: string
{
    case ACTIVE = 'active';
    case EXPIRED = 'expired';
    case VOIDED = 'voided';

    public function label(): string
    {
        return match ($this) {
            self::ACTIVE => 'Активный',
            self::EXPIRED => 'Истекший',
            self::VOIDED => 'Аннулированный',
        };
    }
}

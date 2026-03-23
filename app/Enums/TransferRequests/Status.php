<?php

namespace App\Enums\TransferRequests;

enum Status: string
{
    case PENDING = 'pending';
    case ACCEPTED = 'accepted';
    case REJECTED = 'rejected';
    case CANCELLED = 'cancelled';

    public function label(): string
    {
        return match ($this) {
            self::PENDING => 'В ожидании',
            self::ACCEPTED => 'Принят',
            self::REJECTED => 'Отклонен',
            self::CANCELLED => 'Отменен',
        };
    }
}

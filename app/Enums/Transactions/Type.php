<?php

namespace App\Enums\Transactions;

enum Type: string
{
    case CHECKOUT = 'checkout';
    case RETURN = 'return';
    case TRANSFER = 'transfer';

    public function label(): string
    {
        return match ($this) {
            self::CHECKOUT => 'Проверен',
            self::RETURN => 'Возвращен',
            self::TRANSFER => 'Передан',
        };
    }
}

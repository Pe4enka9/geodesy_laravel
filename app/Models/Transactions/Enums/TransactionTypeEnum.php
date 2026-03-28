<?php

namespace App\Models\Transactions\Enums;

enum TransactionTypeEnum: string
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

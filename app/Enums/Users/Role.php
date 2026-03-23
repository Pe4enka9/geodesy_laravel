<?php

namespace App\Enums\Users;

enum Role: string
{
    case ADMIN = 'admin';
    case MANAGER = 'manager';
    case EMPLOYEE = 'employee';

    public function label(): string
    {
        return match ($this) {
            self::ADMIN => 'Администратор',
            self::MANAGER => 'Менеджер',
            self::EMPLOYEE => 'Сотрудник',
        };
    }
}

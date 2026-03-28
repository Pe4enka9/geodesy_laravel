<?php

namespace App\Models\Users\Enums;

enum UserRoleEnum: string
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

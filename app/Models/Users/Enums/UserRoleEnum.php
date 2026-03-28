<?php

namespace App\Models\Users\Enums;

enum UserRoleEnum: string
{
    case OWNER = 'owner';
    case ADMIN = 'admin';
    case EMPLOYEE = 'employee';

    public function label(): string
    {
        return match ($this) {
            self::OWNER => 'Владелец',
            self::ADMIN => 'Администратор',
            self::EMPLOYEE => 'Сотрудник',
        };
    }
}

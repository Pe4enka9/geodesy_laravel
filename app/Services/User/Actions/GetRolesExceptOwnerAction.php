<?php

namespace App\Services\User\Actions;

use App\Models\Users\Enums\UserRoleEnum;

class GetRolesExceptOwnerAction
{
    public function __invoke(): array
    {
        return array_filter(UserRoleEnum::cases(), fn($role) => $role !== UserRoleEnum::OWNER);
    }
}

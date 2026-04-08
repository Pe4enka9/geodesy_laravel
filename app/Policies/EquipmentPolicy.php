<?php

namespace App\Policies;

use App\Models\Equipments\Enums\EquipmentStatusEnum;
use App\Models\Equipments\Equipment;
use App\Models\Users\User;

class EquipmentPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Equipment $equipment): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    public function update(User $user, Equipment $equipment): bool
    {
        return $user->isAdmin();
    }

    public function delete(User $user, Equipment $equipment): bool
    {
        return $user->isAdmin();
    }

    public function restore(User $user, Equipment $equipment): bool
    {
        return false;
    }

    public function forceDelete(User $user, Equipment $equipment): bool
    {
        return false;
    }

    public function transfer(User $user, Equipment $equipment): bool
    {
        return $equipment->isCurrentHolder($user);
    }

    public function take(User $user, Equipment $equipment): bool
    {
        return !$equipment->current_holder_id && $equipment->status === EquipmentStatusEnum::INACTIVE;
    }

    public function release(User $user, Equipment $equipment): bool
    {
        return $equipment->isCurrentHolder($user);
    }
}

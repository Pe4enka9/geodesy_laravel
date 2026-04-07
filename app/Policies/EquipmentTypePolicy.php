<?php

namespace App\Policies;

use App\Models\EquipmentType;
use App\Models\Users\User;

class EquipmentTypePolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, EquipmentType $equipmentType): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    public function update(User $user, EquipmentType $equipmentType): bool
    {
        return $user->isAdmin();
    }

    public function delete(User $user, EquipmentType $equipmentType): bool
    {
        return $user->isAdmin();
    }

    public function restore(User $user, EquipmentType $equipmentType): bool
    {
        return false;
    }

    public function forceDelete(User $user, EquipmentType $equipmentType): bool
    {
        return false;
    }
}

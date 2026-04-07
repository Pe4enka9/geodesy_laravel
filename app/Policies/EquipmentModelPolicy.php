<?php

namespace App\Policies;

use App\Models\EquipmentModel;
use App\Models\Users\User;

class EquipmentModelPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, EquipmentModel $equipmentModel): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    public function update(User $user, EquipmentModel $equipmentModel): bool
    {
        return $user->isAdmin();
    }

    public function delete(User $user, EquipmentModel $equipmentModel): bool
    {
        return $user->isAdmin();
    }

    public function restore(User $user, EquipmentModel $equipmentModel): bool
    {
        return false;
    }

    public function forceDelete(User $user, EquipmentModel $equipmentModel): bool
    {
        return false;
    }
}

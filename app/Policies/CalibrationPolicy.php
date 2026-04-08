<?php

namespace App\Policies;

use App\Models\Calibrations\Calibration;
use App\Models\Equipments\Enums\EquipmentStatusEnum;
use App\Models\Users\User;

class CalibrationPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Calibration $calibration): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    public function update(User $user, Calibration $calibration): bool
    {
        return $user->isAdmin()
            && (
                $calibration->equipment->status === EquipmentStatusEnum::INACTIVE
                || $calibration->equipment->status === EquipmentStatusEnum::CALIBRATION_EXPIRED
            );
    }

    public function delete(User $user, Calibration $calibration): bool
    {
        return $user->isAdmin();
    }

    public function restore(User $user, Calibration $calibration): bool
    {
        return false;
    }

    public function forceDelete(User $user, Calibration $calibration): bool
    {
        return false;
    }
}

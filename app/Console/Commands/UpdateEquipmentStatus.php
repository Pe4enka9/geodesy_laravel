<?php

namespace App\Console\Commands;

use App\Models\Equipments\Enums\EquipmentStatusEnum;
use App\Models\Equipments\Equipment;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;

#[Signature('equipment:update-status')]
#[Description('Update equipments status')]
class UpdateEquipmentStatus extends Command
{
    public function handle(): int
    {
        Equipment::whereNotIn('status', [
            EquipmentStatusEnum::MAINTENANCE,
            EquipmentStatusEnum::CALIBRATION_EXPIRED,
            EquipmentStatusEnum::LOST,
            EquipmentStatusEnum::WRITTEN_OFF,
        ])
            ->whereHas('calibrations', function (Builder $query) {
                $query->where('expires_at', '<', now())
                    ->orderByDesc('expires_at')
                    ->limit(1);
            })
            ->update(['status' => EquipmentStatusEnum::CALIBRATION_EXPIRED]);

        return self::SUCCESS;
    }
}

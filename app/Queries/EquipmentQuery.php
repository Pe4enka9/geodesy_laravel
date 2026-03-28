<?php

namespace App\Queries;

use App\Models\Equipments\Equipment;
use Illuminate\Support\Collection;

class EquipmentQuery
{
    public function noCalibrations(): Collection
    {
        return Equipment::doesntHave('calibrations')->latest()->get();
    }
}

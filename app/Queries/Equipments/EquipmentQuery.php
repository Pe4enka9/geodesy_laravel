<?php

namespace App\Queries\Equipments;

use App\Models\Equipment;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class EquipmentQuery
{
    /**
     * Поиск по инвентарному номеру или модели
     *
     * @return Builder<Equipment>
     */
    public function apply(Request $request): Builder
    {
        $query = Equipment::with(['currentHolder', 'lastCalibration']);

        if ($request->filled('search')) {
            $query->where('inventory_number', 'like', "%$request->search%")
                ->orWhere('model', 'like', "%$request->search%");
        }

        return $query;
    }
}

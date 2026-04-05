<?php

namespace App\Http\Resources;

use App\Models\Equipments\Equipment;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Equipment
 */
class EquipmentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'type_id' => $this->type_id,
            'inventory_number' => $this->inventory_number,
            'serial_number' => $this->serial_number,
            'model_id' => $this->model_id,
            'status' => $this->status,
            'current_holder_id' => $this->current_holder_id,
        ];
    }
}

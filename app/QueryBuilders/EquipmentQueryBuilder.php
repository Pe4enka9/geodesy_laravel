<?php

namespace App\QueryBuilders;

use Illuminate\Database\Eloquent\Builder;

class EquipmentQueryBuilder extends Builder
{

    public function onlyMyEquipments(): self
    {
        return $this->where('current_holder_id', auth()->id());
    }
}

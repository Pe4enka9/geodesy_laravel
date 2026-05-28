<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class FullInventoryExport implements WithMultipleSheets
{
    protected Collection $equipment;

    public function __construct(Collection $equipment)
    {
        $this->equipment = $equipment;
    }

    public function sheets(): array
    {
        return [
            new EquipmentListSheet($this->equipment),
            new SummarySheet($this->equipment),
            new ByHolderSheet($this->equipment),
        ];
    }
}

<?php

namespace App\Exports\Transfer;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class TransferReportExport implements WithMultipleSheets
{
    protected Collection $transfers;

    public function __construct(Collection $transfers)
    {
        $this->transfers = $transfers;
    }

    public function sheets(): array
    {
        return [
            new TransferListSheet($this->transfers),
            new TransferStatsSheet($this->transfers),
        ];
    }
}

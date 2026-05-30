<?php

namespace App\Exports\Calibration;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class CalibrationReportExport implements WithMultipleSheets
{
    protected Collection $calibrations;

    public function __construct(Collection $calibrations)
    {
        $this->calibrations = $calibrations;
    }

    public function sheets(): array
    {
        return [
            new CalibrationListSheet($this->calibrations),
        ];
    }
}

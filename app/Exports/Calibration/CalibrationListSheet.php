<?php

namespace App\Exports\Calibration;

use App\Models\Calibrations\Calibration;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CalibrationListSheet implements FromCollection, WithHeadings, WithTitle, WithStyles
{
    protected Collection $calibrations;

    public function __construct(Collection $calibrations)
    {
        $this->calibrations = $calibrations;
    }

    public function title(): string
    {
        return 'Поверки';
    }

    public function headings(): array
    {
        return [
            'Инв. номер',
            'Оборудование',
            'Номер сертификата',
            'Дата выдачи',
            'Действует до',
            'Статус поверки',
        ];
    }

    public function collection(): Collection
    {
        return $this->calibrations->map(function (Calibration $calibration) {
            return [
                $calibration->equipment->inventory_number,
                $calibration->equipment->type->name,

                $calibration->certificate_number,

                $calibration->issued_at ? Carbon::parse($calibration->issued_at)->format('d.m.Y') : '—',
                $calibration->expires_at ? Carbon::parse($calibration->expires_at)->format('d.m.Y') : '—',

                $calibration->status->label(),
            ];
        });
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => ['font' => ['bold' => true]],

            'A' => ['width' => 15],
            'B' => ['width' => 25],
            'C' => ['width' => 20],
            'D' => ['width' => 15],
            'E' => ['width' => 15],
            'F' => ['width' => 20],
        ];
    }
}

<?php

namespace App\Exports\Calibration;

use App\Models\Calibrations\Calibration;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

class CalibrationListSheet implements FromCollection, WithHeadings, WithTitle, WithEvents
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

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet;
                $range = $sheet->calculateWorksheetDimension();

                $sheet->getStyle('A1:F1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                $sheet->getColumnDimension('A')->setAutoSize(true);
                $sheet->getColumnDimension('B')->setAutoSize(true);
                $sheet->getColumnDimension('C')->setAutoSize(true);
                $sheet->getColumnDimension('D')->setAutoSize(true);
                $sheet->getColumnDimension('E')->setAutoSize(true);
                $sheet->getColumnDimension('F')->setAutoSize(true);

                $sheet->getStyle('A1:F1')->getFont()->setBold(true);

                $sheet->getStyle($range)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['argb' => '222222'],
                        ],
                    ],
                ]);
            },
        ];
    }
}

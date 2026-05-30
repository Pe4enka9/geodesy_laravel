<?php

namespace App\Exports\Equipment;

use App\Models\Equipments\Equipment;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

class EquipmentListSheet implements FromCollection, WithHeadings, WithTitle, WithEvents
{
    protected Collection $equipment;

    public function __construct(Collection $equipment)
    {
        $this->equipment = $equipment;
    }

    public function title(): string
    {
        return 'Оборудование';
    }

    public function headings(): array
    {
        return [
            'Инвентарный номер',
            'Серийный номер',
            'Тип',
            'Модель',
            'Статус',
            'Держатель',
            'Дата поверки',
        ];
    }

    public function collection(): Collection
    {
        return $this->equipment->map(function (Equipment $item) {
            $lastCalibration = $item->calibrations()->latest('issued_at')->first();

            $verificationDate = $lastCalibration
                ? Carbon::parse($lastCalibration->issued_at)->format('d.m.Y')
                : '—';

            return [
                $item->inventory_number,
                $item->serial_number ?? '—',
                $item->type->name,
                $item->model?->name ?? '—',
                $item->status->label(),
                $item->currentHolder?->getFullName() ?? '—',
                $verificationDate,
            ];
        });
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet;
                $range = $sheet->calculateWorksheetDimension();

                $sheet->getStyle('A1:G1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                $sheet->getColumnDimension('A')->setAutoSize(true);
                $sheet->getColumnDimension('B')->setAutoSize(true);
                $sheet->getColumnDimension('C')->setAutoSize(true);
                $sheet->getColumnDimension('D')->setAutoSize(true);
                $sheet->getColumnDimension('E')->setAutoSize(true);
                $sheet->getColumnDimension('F')->setAutoSize(true);
                $sheet->getColumnDimension('G')->setAutoSize(true);

                $sheet->getStyle('A1:G1')->getFont()->setBold(true);

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

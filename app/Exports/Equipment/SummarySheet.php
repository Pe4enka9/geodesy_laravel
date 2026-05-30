<?php

namespace App\Exports\Equipment;

use App\Models\Equipments\Enums\EquipmentStatusEnum;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

class SummarySheet implements FromCollection, WithHeadings, WithTitle, WithEvents
{
    protected Collection $equipment;

    public function __construct(Collection $equipment)
    {
        $this->equipment = $equipment;
    }

    public function title(): string
    {
        return 'Сводка';
    }

    public function headings(): array
    {
        return ['Показатель', 'Значение'];
    }

    public function collection(): Collection
    {
        $total = $this->equipment->count();

        $inWork = $this->equipment->where('status', EquipmentStatusEnum::ACTIVE)->count();

        $inStock = $this->equipment->where('status', EquipmentStatusEnum::INACTIVE)->count();

        $expired = $this->equipment->where('status', EquipmentStatusEnum::CALIBRATION_EXPIRED)->count();

        $writtenOff = $this->equipment->where('status', EquipmentStatusEnum::WRITTEN_OFF)->count();

        return collect([
            ['Всего оборудования', $total],
            ['В работе', $inWork],
            ['На складе', $inStock],
            ['Просрочена поверка', $expired],
            ['Списано', $writtenOff],
        ]);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet;
                $range = $sheet->calculateWorksheetDimension();

                $sheet->getStyle('A1:B1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                $sheet->getColumnDimension('A')->setAutoSize(true);
                $sheet->getColumnDimension('B')->setAutoSize(true);

                $sheet->getStyle('A1:B1')->getFont()->setBold(true);

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

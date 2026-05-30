<?php

namespace App\Exports\Equipment;

use App\Models\Equipments\Equipment;
use Illuminate\Support\Collection;
use Illuminate\Support\Enumerable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

class ByHolderSheet implements FromCollection, WithHeadings, WithTitle, WithEvents
{
    protected Collection $equipment;

    public function __construct(Collection $equipment)
    {
        $this->equipment = $equipment;
    }

    public function title(): string
    {
        return 'По держателям';
    }

    public function headings(): array
    {
        return ['Держатель', 'Количество единиц', 'Список инв. номеров'];
    }

    public function collection(): Enumerable
    {
        $grouped = $this->equipment->groupBy(function (Equipment $item) {
            return $item->currentHolder?->getFullName() ?? 'Не назначен';
        });

        return $grouped
            ->reject(function (Collection $items, string $holderName) {
                return $holderName === 'Не назначен' || empty($holderName);
            })
            ->map(function (Collection $items, $holderName) {
                return [
                    $holderName,
                    $items->count(),
                    $items->pluck('inventory_number')->implode(', '),
                ];
            })
            ->values();
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet;
                $range = $sheet->calculateWorksheetDimension();

                $sheet->getStyle('A1:C1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                $sheet->getColumnDimension('A')->setAutoSize(true);
                $sheet->getColumnDimension('B')->setAutoSize(true);
                $sheet->getColumnDimension('C')->setAutoSize(true);

                $sheet->getStyle('A1:C1')->getFont()->setBold(true);

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

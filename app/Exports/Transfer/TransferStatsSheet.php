<?php

namespace App\Exports\Transfer;

use App\Models\TransferRequests\Enums\TransferRequestStatusEnum;
use Illuminate\Support\Collection;
use Illuminate\Support\Enumerable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

class TransferStatsSheet implements FromCollection, WithHeadings, WithTitle, WithEvents
{
    protected Collection $transfers;

    public function __construct(Collection $transfers)
    {
        $this->transfers = $transfers;
    }

    public function title(): string
    {
        return 'Статистика передач';
    }

    public function headings(): array
    {
        return ['Статус', 'Количество', 'Доля, %'];
    }

    public function collection(): Enumerable|Collection
    {
        $total = $this->transfers->count();

        $stats = $this->transfers->groupBy('status')->map(function (Collection $items, string $statusKey) use ($total) {
            $count = $items->count();
            $percent = $total > 0 ? round(($count / $total) * 100) : 0;

            $enumCase = TransferRequestStatusEnum::tryFrom($statusKey);
            $label = $enumCase ? $enumCase->label() : $statusKey;

            return [
                'label' => $label,
                'count' => $count,
                'percent' => $percent . '%',
            ];
        });

        $rows = $stats->values()->map(fn($item) => [
            $item['label'],
            $item['count'],
            $item['percent'],
        ]);

        $rows->push([
            'Итого',
            $total,
            '100%',
        ]);

        return $rows;
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

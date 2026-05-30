<?php

namespace App\Exports\Transfer;

use App\Models\TransferRequests\Enums\TransferRequestStatusEnum;
use Illuminate\Support\Collection;
use Illuminate\Support\Enumerable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TransferStatsSheet implements FromCollection, WithHeadings, WithTitle, WithStyles
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
                'percent' => $percent . '%'
            ];
        });

        $rows = $stats->values()->map(fn($item) => [
            $item['label'],
            $item['count'],
            $item['percent']
        ]);

        $rows->push([
            'Итого',
            $total,
            '100%'
        ]);

        return $rows;
    }

    public function styles(Worksheet $sheet): array
    {
        $lastRow = $this->transfers->count() + 2;

        return [
            1 => ['font' => ['bold' => true]],
            $lastRow => ['font' => ['bold' => true]],

            'A' => ['width' => 20],
            'B' => ['width' => 15],
            'C' => ['width' => 15],
        ];
    }
}

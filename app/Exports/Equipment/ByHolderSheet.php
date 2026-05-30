<?php

namespace App\Exports\Equipment;

use App\Models\Equipments\Equipment;
use Illuminate\Support\Collection;
use Illuminate\Support\Enumerable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ByHolderSheet implements FromCollection, WithHeadings, WithTitle, WithStyles
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

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => ['font' => ['bold' => true]],

            'A' => ['width' => 25],
            'B' => ['width' => 10],
            'C' => ['width' => 40],
        ];
    }
}

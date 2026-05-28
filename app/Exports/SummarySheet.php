<?php

namespace App\Exports;

use App\Models\Equipments\Enums\EquipmentStatusEnum;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SummarySheet implements FromCollection, WithHeadings, WithTitle, WithStyles
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

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => ['font' => ['bold' => true]],

            'A' => ['width' => 25],
            'B' => ['width' => 10],
        ];
    }
}

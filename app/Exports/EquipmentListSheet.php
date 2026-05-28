<?php

namespace App\Exports;

use App\Models\Equipments\Equipment;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class EquipmentListSheet implements FromCollection, WithHeadings, WithTitle, WithStyles
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

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => ['font' => ['bold' => true]],

            'A' => ['width' => 20],
            'B' => ['width' => 15],
            'C' => ['width' => 20],
            'D' => ['width' => 20],
            'E' => ['width' => 20],
            'F' => ['width' => 20],
            'G' => ['width' => 15],
        ];
    }
}

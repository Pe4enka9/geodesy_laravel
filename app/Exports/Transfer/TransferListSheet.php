<?php

namespace App\Exports\Transfer;

use App\Models\TransferRequests\TransferRequest;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TransferListSheet implements FromCollection, WithHeadings, WithTitle, WithStyles
{
    protected Collection $transfers;

    public function __construct(Collection $transfers)
    {
        $this->transfers = $transfers;
    }

    public function title(): string
    {
        return 'Список передач';
    }

    public function headings(): array
    {
        return [
            '№ заявки',
            'Оборудование',
            'Отправитель',
            'Получатель',
            'Статус',
            'Дата создания',
            'Дата завершения',
            'Комментарий',
        ];
    }

    public function collection(): Collection
    {
        return $this->transfers->map(function (TransferRequest $transfer) {
            return [
                $transfer->id,
                $transfer->equipment->inventory_number,
                $transfer->sender?->getFullName() ?? '—',
                $transfer->receiver?->getFullName() ?? '—',
                $transfer->status->label(),

                $transfer->created_at ? Carbon::parse($transfer->created_at)->format('d.m.Y H:i') : '—',
                $transfer->resolved_at ? Carbon::parse($transfer->resolved_at)->format('d.m.Y H:i') : '—',

                $transfer->comment ?? '—',
            ];
        });
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => ['font' => ['bold' => true]],

            'A' => ['width' => 12],
            'B' => ['width' => 15],
            'C' => ['width' => 20],
            'D' => ['width' => 20],
            'E' => ['width' => 15],
            'F' => ['width' => 18],
            'G' => ['width' => 18],
            'H' => ['width' => 30],
        ];
    }
}

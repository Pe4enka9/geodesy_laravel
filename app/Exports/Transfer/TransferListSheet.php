<?php

namespace App\Exports\Transfer;

use App\Models\TransferRequests\TransferRequest;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

class TransferListSheet implements FromCollection, WithHeadings, WithTitle, WithEvents
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

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet;
                $range = $sheet->calculateWorksheetDimension();

                $sheet->getStyle('A1:H1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                $sheet->getColumnDimension('A')->setAutoSize(true);
                $sheet->getColumnDimension('B')->setAutoSize(true);
                $sheet->getColumnDimension('C')->setAutoSize(true);
                $sheet->getColumnDimension('D')->setAutoSize(true);
                $sheet->getColumnDimension('E')->setAutoSize(true);
                $sheet->getColumnDimension('F')->setAutoSize(true);
                $sheet->getColumnDimension('G')->setAutoSize(true);
                $sheet->getColumnDimension('H')->setAutoSize(true);

                $sheet->getStyle('A1:H1')->getFont()->setBold(true);

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

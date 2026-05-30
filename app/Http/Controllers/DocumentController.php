<?php

namespace App\Http\Controllers;

use App\Exports\Calibration\CalibrationReportExport;
use App\Exports\Equipment\FullInventoryExport;
use App\Exports\Transfer\TransferReportExport;
use App\Models\Calibrations\Calibration;
use App\Models\Equipments\Equipment;
use App\Models\TransferRequests\TransferRequest;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DocumentController extends Controller
{
    public function printAct(TransferRequest $transfer)
    {
        $data = [
            'city' => 'Абакан',
            'date' => $transfer->created_at,
            'sender' => $transfer->sender,
            'receiver' => $transfer->receiver,
            'equipment' => $transfer->equipment,
            'comment' => $transfer->comment,
        ];

        $pdf = Pdf::loadView('documents.act', $data);

        return $pdf->download("Акт приема-передачи геодезического оборудования_$transfer->id.pdf");
    }

    public function uploadAct(TransferRequest $transfer, Request $request): RedirectResponse
    {
        $request->validate([
            'act_file' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
        ]);

        if ($transfer->act_path) {
            Storage::disk('public')->delete($transfer->act_path);
        }

        if ($request->hasFile('act_file')) {
            $path = $request->file('act_file')->store('acts', 'public');
            $transfer->update(['act_path' => $path]);
        }

        return back();
    }

    public function downloadAct(TransferRequest $transfer): StreamedResponse
    {
        return Storage::disk('public')->response($transfer->act_path);
    }

    public function exportEquipment(): BinaryFileResponse
    {
        $equipments = Equipment::with(['type', 'model', 'currentHolder', 'calibrations'])->get();

        return Excel::download(new FullInventoryExport($equipments), 'inventory_full_report.xlsx');
    }

    public function exportTransfers(): BinaryFileResponse
    {
        $transfers = TransferRequest::with(['equipment', 'sender', 'receiver'])->latest()->get();

        return Excel::download(new TransferReportExport($transfers), 'transfers_report.xlsx');
    }

    public function exportCalibrations(): BinaryFileResponse
    {
        $calibrations = Calibration::with(['equipment', 'equipment.type'])
            ->latest('issued_at')
            ->get();

        return Excel::download(new CalibrationReportExport($calibrations), 'calibrations_report.xlsx');
    }
}

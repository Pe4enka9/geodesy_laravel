<?php

namespace App\Http\Controllers;

use App\Models\TransferRequests\TransferRequest;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
}

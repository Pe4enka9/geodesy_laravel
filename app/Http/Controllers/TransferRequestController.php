<?php

namespace App\Http\Controllers;

use App\Http\Requests\Transfer\TransferDto;
use App\Models\Equipments\Equipment;
use App\Models\TransferRequests\Enums\TransferRequestStatusEnum;
use App\Models\TransferRequests\TransferRequest;
use App\Models\Users\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TransferRequestController extends Controller
{
    // Все передачи
    public function index(): View
    {
        $transfers = TransferRequest::latest()->get();

        return view('transfers.index', ['transfers' => $transfers]);
    }

    // Форма создания запроса на передачу
    public function create(): View
    {
        $equipments = Equipment::onlyMyEquipments()->get();
        $receivers = User::exceptMe()->get();

        return view('transfers.create', [
            'equipments' => $equipments,
            'receivers' => $receivers,
        ]);
    }

    // Создать запрос на передачу
    public function store(TransferDto $transferDto): RedirectResponse
    {
        TransferRequest::create([
            'equipment_id' => $transferDto->equipment,
            'sender_id' => auth()->id(),
            'receiver_id' => $transferDto->receiver,
            'comment' => $transferDto->comment,
        ]);

        return redirect()->route('transfers.index');
    }

    // Отменить запрос
    public function cancel(TransferRequest $transfer): RedirectResponse
    {
        $transfer->update([
            'status' => TransferRequestStatusEnum::CANCELLED,
            'resolved_at' => now(),
        ]);

        return redirect()->route('transfers.index');
    }

    // Принять запрос
    public function accept(TransferRequest $transfer): RedirectResponse
    {
        $transfer->equipment->update(['current_holder_id' => auth()->id()]);

        $transfer->update([
            'status' => TransferRequestStatusEnum::ACCEPTED,
            'resolved_at' => now(),
        ]);

        return redirect()->route('transfers.index');
    }

    // Отклонить запрос
    public function reject(TransferRequest $transfer): RedirectResponse
    {
        $transfer->update([
            'status' => TransferRequestStatusEnum::REJECTED,
            'resolved_at' => now(),
        ]);

        return redirect()->route('transfers.index');
    }
}

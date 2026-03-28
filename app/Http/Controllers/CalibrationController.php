<?php

namespace App\Http\Controllers;

use App\Http\Requests\Calibration\CreateDto;
use App\Http\Requests\Calibration\UpdateDto;
use App\Models\Calibrations\Calibration;
use App\Queries\EquipmentQuery;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CalibrationController extends Controller
{
    public function __construct(
        private EquipmentQuery $equipmentQuery,
    )
    {
    }

    // Все поверки
    public function index(): View
    {
        $calibrations = Calibration::latest()->get();

        return view('calibrations.index', ['calibrations' => $calibrations]);
    }

    // Форма создания поверки
    public function create(): View
    {
        $equipments = $this->equipmentQuery->noCalibrations();

        return view('calibrations.create', ['equipments' => $equipments]);
    }

    // Создание поверки
    public function store(CreateDto $createDto): RedirectResponse
    {
        Calibration::create([
            'equipment_id' => $createDto->equipment,
            'certificate_number' => $createDto->certificateNumber,
            'verification_url' => $createDto->verificationUrl,
            'issued_at' => $createDto->issuedAt,
            'expires_at' => $createDto->expiresAt,
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('calibrations.index');
    }

    // Форма редактирования поверки
    public function edit(Calibration $calibration): View
    {
        return view('calibrations.edit', ['calibration' => $calibration]);
    }

    // Обновление поверки
    public function update(
        Calibration $calibration,
        UpdateDto   $updateDto,
    ): RedirectResponse
    {
        $calibration->update([
            'certificate_number' => $updateDto->certificateNumber,
            'verification_url' => $updateDto->verificationUrl,
            'issued_at' => $updateDto->issuedAt,
            'expires_at' => $updateDto->expiresAt,
        ]);

        return redirect()->route('calibrations.index');
    }

    // Удаление поверки
    public function destroy(Calibration $calibration): RedirectResponse
    {
        $calibration->delete();

        return redirect()->route('calibrations.index');
    }
}

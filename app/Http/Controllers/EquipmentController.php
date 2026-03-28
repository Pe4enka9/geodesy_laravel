<?php

namespace App\Http\Controllers;

use App\Http\Requests\Equipment\CreateDto;
use App\Http\Requests\Equipment\UpdateDto;
use App\Models\EquipmentModel;
use App\Models\Equipments\Equipment;
use App\Models\EquipmentType;
use App\Queries\Equipment\EquipmentQuery;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EquipmentController extends Controller
{
    public function __construct(
        private EquipmentQuery $equipmentQuery,
    )
    {
    }

    // Всё оборудование
    public function index(): View
    {
        $equipments = Equipment::latest()->get();

        return view('equipments.index', ['equipments' => $equipments]);
    }

    // Форма добавления оборудование
    public function create(): View
    {
        $types = EquipmentType::all();
        $models = EquipmentModel::all();

        return view('equipments.create', [
            'types' => $types,
            'models' => $models,
        ]);
    }

    // Добавление оборудования
    public function store(
        CreateDto $dto,
        Request   $request,
    ): RedirectResponse
    {
        $hasCalibration = $request->boolean('has_calibration');

        if ($hasCalibration) {
            $request->validate([
                'certificate_number' => ['required', 'string'],
                'verification_url' => ['required', 'string', 'url'],
                'issued_at' => ['required', 'date:Y-m-d'],
                'expires_at' => ['required', 'date:Y-m-d', 'after:issued_at'],
            ]);
        }

        $equipment = Equipment::create([
            'equipment_type_id' => $dto->equipmentType,
            'inventory_number' => $dto->inventoryNumber,
            'serial_number' => $dto->serialNumber,
            'equipment_model_id' => $dto->equipmentModel,
        ]);

        if ($hasCalibration) {
            $equipment->calibrations()->create([
                'certificate_number' => $request->input('certificate_number'),
                'verification_url' => $request->input('verification_url'),
                'issued_at' => $request->input('issued_at'),
                'expires_at' => $request->input('expires_at'),
                'created_by' => auth()->id(),
            ]);
        }

        return redirect()->route('equipments.index');
    }

    // Форма редактирование оборудования
    public function edit(Equipment $equipment): View
    {
        $types = EquipmentType::all();
        $models = EquipmentModel::all();

        return view('equipments.edit', [
            'equipment' => $equipment,
            'types' => $types,
            'models' => $models,
        ]);
    }

    // Обновление оборудования
    public function update(
        Equipment $equipment,
        UpdateDto $dto,
        Request   $request,
    ): RedirectResponse
    {
        $hasCalibration = $request->boolean('has_calibration');

        if ($hasCalibration) {
            $request->validate([
                'certificate_number' => ['required', 'string'],
                'verification_url' => ['required', 'string', 'url'],
                'issued_at' => ['required', 'date:Y-m-d'],
                'expires_at' => ['required', 'date:Y-m-d', 'after:issued_at'],
            ]);
        }

        $equipment->update([
            'equipment_type_id' => $dto->equipmentType,
            'inventory_number' => $dto->inventoryNumber,
            'serial_number' => $dto->serialNumber,
            'equipment_model_id' => $dto->equipmentModel,
        ]);

        if ($hasCalibration) {
            $equipment->lastCalibration()->update([
                'certificate_number' => $request->input('certificate_number'),
                'verification_url' => $request->input('verification_url'),
                'issued_at' => $request->input('issued_at'),
                'expires_at' => $request->input('expires_at'),
                'created_by' => auth()->id(),
            ]);
        }

        return redirect()->route('equipments.index');
    }

    // Удаление оборудования
    public function destroy(Equipment $equipment): RedirectResponse
    {
        $equipment->delete();

        return redirect()->route('equipments.index');
    }
}

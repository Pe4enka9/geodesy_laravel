<?php

namespace App\Http\Controllers;

use App\Http\Requests\Equipment\CreateDto;
use App\Http\Requests\Equipment\UpdateDto;
use App\Models\EquipmentModel;
use App\Models\Equipments\Equipment;
use App\Models\EquipmentType;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class EquipmentController extends Controller
{

    // Всё оборудование
    public function index(): View
    {
        $equipments = Equipment::latest()->get();

        return view('equipments.index', ['equipments' => $equipments]);
    }

    // Просмотр оборудования
    public function show(Equipment $equipment): View
    {
        return view('equipments.show', ['equipment' => $equipment]);
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
    public function store(CreateDto $createDto): RedirectResponse
    {
        Equipment::create([
            'type_id' => $createDto->type,
            'inventory_number' => $createDto->inventoryNumber,
            'serial_number' => $createDto->serialNumber,
            'model_id' => $createDto->model,
        ]);

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
    public function update(Equipment $equipment, UpdateDto $updateDto): RedirectResponse
    {
        $equipment->update([
            'type_id' => $updateDto->type,
            'inventory_number' => $updateDto->inventoryNumber,
            'serial_number' => $updateDto->serialNumber,
            'model_id' => $updateDto->model,
        ]);

        return redirect()->route('equipments.index');
    }

    // Удаление оборудования
    public function destroy(Equipment $equipment): RedirectResponse
    {
        $equipment->delete();

        return redirect()->route('equipments.index');
    }
}

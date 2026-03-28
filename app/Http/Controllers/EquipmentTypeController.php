<?php

namespace App\Http\Controllers;

use App\Http\Requests\Type\CreateDto;
use App\Http\Requests\Type\UpdateDto;
use App\Models\EquipmentType;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class EquipmentTypeController extends Controller
{
    // Все типы
    public function index(): View
    {
        $types = EquipmentType::latest()->get();

        return view('types.index', ['types' => $types]);
    }

    // Форма создания типа
    public function create(): View
    {
        return view('types.create');
    }

    // Создание типа
    public function store(CreateDto $createDto): RedirectResponse
    {
        EquipmentType::create([
            'name' => $createDto->name,
            'code' => $createDto->code,
            'description' => $createDto->description,
        ]);

        return redirect()->route('types.index');
    }

    // Форма редактирования типа
    public function edit(EquipmentType $type): View
    {
        return view('types.edit', ['type' => $type]);
    }

    // Обновление типа
    public function update(EquipmentType $type, UpdateDto $updateDto): RedirectResponse
    {
        $type->update([
            'name' => $updateDto->name,
            'code' => $updateDto->code,
            'description' => $updateDto->description,
        ]);

        return redirect()->route('types.index');
    }

    // Удаление типа
    public function destroy(EquipmentType $type): RedirectResponse
    {
        $type->delete();

        return redirect()->route('types.index');
    }
}

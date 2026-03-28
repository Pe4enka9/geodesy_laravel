<?php

namespace App\Http\Controllers;

use App\Http\Requests\Model\ModelDto;
use App\Models\EquipmentModel;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class EquipmentModelController extends Controller
{
    // Все модели
    public function index(): View
    {
        $models = EquipmentModel::latest()->get();

        return view('models.index', ['models' => $models]);
    }

    // Форма создания модели
    public function create(): View
    {
        return view('models.create');
    }

    // Создание модели
    public function store(ModelDto $modelDto): RedirectResponse
    {
        EquipmentModel::create(['name' => $modelDto->name]);

        return redirect()->route('models.index');
    }

    // Форма редактирования модели
    public function edit(EquipmentModel $model): View
    {
        return view('models.edit', ['model' => $model]);
    }

    // Обновление модели
    public function update(EquipmentModel $model, ModelDto $modelDto): RedirectResponse
    {
        $model->update(['name' => $modelDto->name]);

        return redirect()->route('models.index');
    }

    // Удаление модели
    public function destroy(EquipmentModel $model): RedirectResponse
    {
        $model->delete();

        return redirect()->route('models.index');
    }
}

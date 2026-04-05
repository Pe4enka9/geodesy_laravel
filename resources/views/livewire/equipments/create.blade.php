<x-forms.modal-create-form title="Добавить оборудование">
    <div class="input-wrapper">
        <label for="type">Тип оборудования</label>
        <select @class(['invalid' => $errors->has('type')]) wire:model="type">
            <option value="" hidden>Выберите тип</option>
            @foreach($types as $type)
                <option value="{{ $type->id }}">{{ $type->name }}</option>
            @endforeach
        </select>

        @error('type')
        <div class="error">{{ $message }}</div>
        @enderror
    </div>

    <div class="input-wrapper">
        <label for="inventory_number">Инвентарный номер</label>
        <input type="text" @class(['invalid' => $errors->has('inventory_number')]) placeholder="Инвентарный номер"
               wire:model="inventory_number">

        @error('inventory_number')
        <div class="error">{{ $message }}</div>
        @enderror
    </div>

    <div class="input-wrapper">
        <label for="serial_number">Серийный номер</label>
        <input type="text" @class(['invalid' => $errors->has('serial_number')]) placeholder="Серийный номер"
               wire:model="serial_number">

        @error('serial_number')
        <div class="error">{{ $message }}</div>
        @enderror
    </div>

    <div class="input-wrapper">
        <label for="model">Модель</label>
        <select @class(['invalid' => $errors->has('model')]) wire:model="model">
            <option value="">Не выбрана</option>
            @foreach($models as $model)
                <option value="{{ $model->id }}">{{ $model->name }}</option>
            @endforeach
        </select>

        @error('model')
        <div class="error">{{ $message }}</div>
        @enderror
    </div>
</x-forms.modal-create-form>

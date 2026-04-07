@use(App\Models\Equipments\Enums\EquipmentStatusEnum, Status)

<x-forms.modal-edit-form title="Редактировать оборудование">
    <x-forms.select
        label="Тип оборудования"
        id="edit_type"
        name="form.type"
        placeholder="Выберите тип"
        hidden-placeholder
        required
    >
        @foreach($types as $type)
            <option value="{{ $type->id }}">
                {{ $type->name }}
            </option>
        @endforeach
    </x-forms.select>

    <x-forms.input
        label="Инвентарный номер"
        type="text"
        id="edit_inventory_number"
        name="form.inventory_number"
        placeholder="Например: TAH-001"
        required
    />

    <x-forms.input
        label="Серийный номер"
        type="text"
        id="edit_serial_number"
        name="form.serial_number"
        placeholder="Необязательно"
    />

    <x-forms.select
        label="Модель"
        id="edit_model"
        name="form.model"
        placeholder="Не выбрана"
    >
        @foreach($models as $model)
            <option value="{{ $model->id }}">
                {{ $model->name }}
            </option>
        @endforeach
    </x-forms.select>

    <x-forms.select
        label="Статус"
        id="edit_status"
        name="form.status"
        required
    >
        @foreach(Status::cases() as $status)
            <option value="{{ $status }}">
                {{ $status->label() }}
            </option>
        @endforeach
    </x-forms.select>
</x-forms.modal-edit-form>

<x-forms.modal-create-form title="Добавить поверку">
    <x-forms.select
        label="Оборудование"
        id="create_equipment_id"
        name="form.equipment_id"
        placeholder="Выберите оборудование"
        hidden-placeholder
        required
    >
        @foreach($this->equipments as $equipment)
            <option value="{{ $equipment->id }}">
                {{ $equipment->inventory_number }}
            </option>
        @endforeach
    </x-forms.select>

    <x-forms.input
        label="Номер сертификата"
        type="text"
        id="create_certificate_number"
        name="form.certificate_number"
        placeholder="Например: СЕРТ-2024-001"
        required
    />

    <x-forms.input
        label="Ссылка на сертификат"
        type="url"
        id="create_verification_url"
        name="form.verification_url"
        placeholder="https://..."
        required
    />

    <div class="input-wrapper-row">
        <x-forms.input
            label="Дата получения"
            type="date"
            id="create_issued_at"
            name="form.issued_at"
            required
        />

        <x-forms.input
            label="Действует до"
            type="date"
            id="create_expires_at"
            name="form.expires_at"
            required
        />
    </div>
</x-forms.modal-create-form>

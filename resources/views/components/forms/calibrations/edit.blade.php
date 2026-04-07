<x-forms.modal-edit-form title="Редактировать поверку">
    <x-forms.select
        label="Оборудование"
        id="edit_equipment"
        name="form.equipment"
        placeholder="Выберите оборудование"
        hidden-placeholder
        required
    >
        @foreach($equipments as $equipment)
            <option value="{{ $equipment->id }}">
                {{ $equipment->inventory_number }}
            </option>
        @endforeach
    </x-forms.select>

    <x-forms.input
        label="Номер сертификата"
        type="text"
        id="edit_certificate_number"
        name="form.certificate_number"
        placeholder="Например: СЕРТ-2024-001"
        required
    />

    <x-forms.input
        label="Ссылка на сертификат"
        type="url"
        id="edit_verification_url"
        name="form.verification_url"
        placeholder="https://..."
        required
    />

    <div class="input-wrapper-row">
        <x-forms.input
            label="Дата получения"
            type="date"
            id="edit_issued_at"
            name="form.issued_at"
            required
        />

        <x-forms.input
            label="Действует до"
            type="date"
            id="edit_expires_at"
            name="form.expires_at"
            required
        />
    </div>
</x-forms.modal-edit-form>

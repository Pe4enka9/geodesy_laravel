<x-forms.modal-edit-form title="Редактировать тип">
    <x-forms.input
        label="Название"
        type="text"
        id="edit_name"
        name="form.name"
        placeholder="Например: Тахеометр"
        required
    />

    <x-forms.input
        label="Код"
        type="text"
        id="edit_code"
        name="form.code"
        placeholder="Например: TAH"
        required
    />

    <x-forms.textarea
        label="Описание"
        id="edit_description"
        name="form.description"
        placeholder="Необязательное описание"
    />
</x-forms.modal-edit-form>
